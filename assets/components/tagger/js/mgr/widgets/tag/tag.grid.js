Tagger.grid.Tag = function(config) {
    config = config || {};

    this.sm = new Ext.grid.CheckboxSelectionModel({
        listeners: {
            rowselect: {
                fn: function (sm, rowIndex, record) {
                    this.rememberRow(record);
                }, scope: this
            },
            rowdeselect: {
                fn: function (sm, rowIndex, record) {
                    this.forgotRow(record);
                }
                ,scope: this
            }
        }
    });

    Ext.applyIf(config,{
        url: Tagger.config.connectorUrl
        ,baseParams: {
            action: 'mgr/tag/getlist'
        }
        ,save_action: 'mgr/tag/updatefromgrid'
        ,autosave: true
        ,fields: ['id', 'tag', 'alias', 'group']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,sm: this.sm
        ,columns: [this.sm, {
            header: _('id')
            ,dataIndex: 'id'
            ,width: 70
            ,sortable: true
            ,hidden: false
        },{
            header: _('tagger.tag.name')
            ,dataIndex: 'tag'
            ,width: 200
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('tagger.tag.alias')
            ,dataIndex: 'alias'
            ,width: 200
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('tagger.tag.group')
            ,dataIndex: 'group'
            ,width: 200
            ,sortable: true
            ,editor: {xtype: 'tagger-combo-group', renderer: true, disabled: true}
        }]
        ,tbar: [{
            text: _('tagger.tag.create')
            ,handler: this.createTag
            ,scope: this
        },'',{
            text: _('tagger.tag.bulk_actions')
            ,id: 'tagger-grid-tag-bulk-actions'
            ,disabled: true
            ,menu: [{
                text: _('tagger.tag.merge_selected')
                ,handler: this.mergeTags
                ,scope: this
            },'-',{
                text: _('tagger.tag.remove_selected')
                ,handler: this.removeTags
                ,scope: this
            }]
        },'->',{
            xtype: 'tagger-combo-group'
            ,id: 'tagger-tag-filter-group'
            ,baseParams:{
                action: 'mgr/group/getlist'
                ,addNone: true
            }
            ,value: _('tagger.group.all')
            ,listeners: {
                'select': {
                    fn: this.filterByGroup
                    ,scope: this
                }
            }
        },{
            xtype: 'textfield'
            ,emptyText: _('tagger.global.search') + '...'
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        }]
    });
    Tagger.grid.Tag.superclass.constructor.call(this,config);
    this.getView().on('refresh', this.refreshSelection, this);
};
Ext.extend(Tagger.grid.Tag,MODx.grid.Grid,{
    windows: {}

    ,selectedRecords: []

    ,rememberRow: function(record) {
        if(this.selectedRecords.indexOf(record.id) == -1){
            this.selectedRecords.push(record.id);
        }

        Ext.getCmp('tagger-grid-tag-bulk-actions').enable();
    }

    ,forgotRow: function(record){
        this.selectedRecords.remove(record.id);

        if (this.selectedRecords.length == 0) {
            Ext.getCmp('tagger-grid-tag-bulk-actions').disable();
        }
    }

    ,refreshSelection: function() {
        var rowsToSelect = [];
        Ext.each(this.selectedRecords, function(item){
            rowsToSelect.push(this.store.indexOfId(item));
        },this);

        this.getSelectionModel().selectRows(rowsToSelect);
    }

    ,getSelectedAsList: function(){
        return this.selectedRecords.join();
    }

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('tagger.tag.assigned_resources')
            ,handler: this.assignedResources
        });
        m.push('-');
        m.push({
            text: _('tagger.tag.update')
            ,handler: this.updateTag
        });
        m.push('-');
        m.push({
            text: _('tagger.tag.remove')
            ,handler: this.removeTag
        });
        this.addContextMenuItem(m);
    }

    ,assignedResources: function(btn,e) {
        var assignedResources = MODx.load({
            xtype: 'tagger-window-assigned-resources'
            ,tagId: this.menu.record.id
            ,title: _('tagger.tag.assigned_resources_to', {tag: this.menu.record.tag})
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        assignedResources.show(e.target);
    }

    ,createTag: function(btn,e) {
        var group = parseInt(Ext.getCmp('tagger-tag-filter-group').getValue());
        var r = {};

        if (group > 0) {
            r.group = group;
        }

        var createTag = MODx.load({
            xtype: 'tagger-window-tag'
            ,title: _('tagger.tag.create')
            ,record: r
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        createTag.fp.getForm().reset();
        createTag.fp.getForm().setValues(r);
        createTag.show(e.target);
    }

    ,updateTag: function(btn,e) {

        var updateTag = MODx.load({
            xtype: 'tagger-window-tag'
            ,title: _('tagger.tag.update')
            ,action: 'mgr/tag/update'
            ,isUpdate: true
            ,record: this.menu.record
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        updateTag.fp.getForm().reset();
        updateTag.fp.getForm().setValues(this.menu.record);
        updateTag.show(e.target);
    }

    ,removeTag: function(btn,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('tagger.tag.remove')
            ,text: _('tagger.tag.remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/tag/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });

        return true;
    }

    ,removeTags: function(btn,e) {
        var tags = this.getSelectedAsList();
        if (tags == '') return false;

        MODx.msg.confirm({
            title: _('tagger.tag.remove_selected')
            ,text: _('tagger.tag.remove_selected_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/tag/removemultiple'
                ,tags: tags
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });

        return true;
    }

    ,mergeTags: function(btn,e) {
        var tags = this.getSelectionModel().getSelections();

        var record = {
            tags: this.getSelectedAsList()
            ,name: tags[0].data.tag
            ,group: tags[0].data.group
            ,tagNames: tags.map(function(tag){return tag.data.tag;}).join(', ')
        };

        if (record.tags == '') return false;

        var groups = tags.map(function(tag){return tag.data.group;});
        groups = groups.reduce(function(p, c) {
            if (p.indexOf(c) < 0) p.push(c);
            return p;
        }, []);

        if (groups.length > 1) {
            btn.ownerCt.hide();
            MODx.msg.alert(_('tagger.err.merge_same_groups'), _('tagger.err.merge_same_groups_desc'));
            return false;
        }

        var mergeTags = MODx.load({
            xtype: 'tagger-window-merge-tags'
            ,title: _('tagger.tag.merge')
            ,action: 'mgr/tag/merge'
            ,record: record
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        mergeTags.fp.getForm().reset();
        mergeTags.fp.getForm().setValues(record);
        mergeTags.show(e.target);

        return true;
    }

    ,search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,filterByGroup: function(combo, record) {
        var s = this.getStore();
        s.baseParams.group = record.id;
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});
Ext.reg('tagger-grid-tag',Tagger.grid.Tag);

Tagger.grid.AssignedResources = function(config) {
    config = config || {};

    this.sm = new Ext.grid.CheckboxSelectionModel({
        listeners: {
            rowselect: function (sm, rowIndex, record) {
                this.rememberRow(record);
            }, scope: this, rowdeselect: function (sm, rowIndex, record) {
                this.forgotRow(record);
            }, scope: this
        }
    });

    Ext.applyIf(config,{
        url: Tagger.config.connectorUrl
        ,baseParams: {
            action: 'mgr/tag/getassignedresources'
        }
        ,fields: ['id','pagetitle', 'alias']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,pageSize: 8
        ,sm: this.sm
        ,columns: [this.sm,{
            header: _('id')
            ,dataIndex: 'id'
            ,width: 70
            ,sortable: true
        },{
            header: _('pagetitle')
            ,dataIndex: 'pagetitle'
            ,width: 200
            ,sortable: true
        },{
            header: _('alias')
            ,dataIndex: 'alias'
            ,width: 200
            ,sortable: true
        }]
        ,tbar: [{
            text: _('tagger.tag.resource_unasign_selected')
            ,id: 'tagger-grid-assigned-resources-unasign-selected'
            ,handler: this.unassignSelected
            ,scope: this
            ,disabled: true
        },'->',{
            xtype: 'textfield'
            ,emptyText: _('tagger.global.search') + '...'
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        }]
    });
    Tagger.grid.AssignedResources.superclass.constructor.call(this,config);

    this.getView().on('refresh', this.refreshSelection, this);
};
Ext.extend(Tagger.grid.AssignedResources,MODx.grid.Grid,{
    windows: {}

    ,selectedRecords: []

    ,rememberRow: function(record) {
        if(!this.selectedRecords.in_array(record.id)){
            this.selectedRecords.push(record.id);
        }

        Ext.getCmp('tagger-grid-assigned-resources-unasign-selected').enable();
    }

    ,forgotRow: function(record){
        this.selectedRecords.remove(record.id);

        if (this.selectedRecords.length == 0) {
            Ext.getCmp('tagger-grid-assigned-resources-unasign-selected').disable();
        }
    }

    ,refreshSelection: function() {
        var rowsToSelect = [];
        Ext.each(this.selectedRecords, function(item){
            rowsToSelect.push(this.store.indexOfId(item));
        },this);
        this.getSelectionModel().selectRows(rowsToSelect);
    }

    ,getSelectedAsList: function(){
        return this.selectedRecords.join();
    }

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('tagger.tag.resource_update')
            ,handler: this.updateResource
        });
        m.push('-');
        m.push({
            text: _('tagger.tag.resource_unassign')
            ,handler: this.unassignResource
        });
        this.addContextMenuItem(m);
    }

    ,search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,updateResource: function() {
        if (!this.menu.record) return false;

        MODx.loadPage(MODx.action['resource/update'], 'id='+this.menu.record.id)
    }

    ,unassignResource: function() {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('tagger.tag.resource_unassign')
            ,text: _('tagger.tag.resource_unassign_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/tag/unassign'
                ,tag: this.config.baseParams.tagId
                ,resource: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }

    ,unassignSelected: function() {
        var resources = this.getSelectedAsList();
        if (!resources) return false;

        MODx.msg.confirm({
            title: _('tagger.tag.resource_unassign')
            ,text: _('tagger.tag.resource_unassign_multiple_confirm', {resources: resources})
            ,url: this.config.url
            ,params: {
                action: 'mgr/tag/unassign'
                ,tag: this.config.baseParams.tagId
                ,resource: resources
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
            }
        });
    }
});
Ext.reg('tagger-grid-assigned-resources',Tagger.grid.AssignedResources);



