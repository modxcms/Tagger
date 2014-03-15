Tagger.grid.Tag = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'tagger-grid-tag'
        ,url: Tagger.config.connectorUrl
        ,baseParams: {
            action: 'mgr/tag/getlist'
        }
        ,save_action: 'mgr/tag/updatefromgrid'
        ,autosave: true
        ,fields: ['id','name', 'group']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: true
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,width: 70
        },{
            header: _('tagger.tag.name')
            ,dataIndex: 'name'
            ,width: 200
            ,editor: { xtype: 'textfield' }
        },{
            header: _('tagger.tag.group')
            ,dataIndex: 'group'
            ,width: 200
            ,editor: {xtype: 'tagger-combo-group', renderer: true, disabled: true}
        }]
        ,tbar: [{
            text: _('tagger.tag.create')
            ,handler: this.createTag
            ,scope: this
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
};
Ext.extend(Tagger.grid.Tag,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
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


