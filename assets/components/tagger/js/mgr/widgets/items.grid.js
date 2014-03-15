Tagger.grid.Items = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'tagger-grid-items'
        ,url: Tagger.config.connectorUrl
        ,baseParams: {
            action: 'mgr/item/getlist'
        }
        ,save_action: 'mgr/item/updatefromgrid'
        ,autosave: true
        ,fields: ['id','name','description', 'position']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: true
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,width: 70
        },{
            header: _('name')
            ,dataIndex: 'name'
            ,width: 200
            ,editor: { xtype: 'textfield' }
        },{
            header: _('description')
            ,dataIndex: 'description'
            ,width: 250
            ,editor: { xtype: 'textfield' }
        },{
            header: _('tagger.position')
            ,dataIndex: 'position'
            ,width: 250
            ,editor: { xtype: 'numberfield', allowDecimal: false, allowNegative: false }
        }]
        ,tbar: [{
            text: _('tagger.item_create')
            ,handler: this.createItem
            ,scope: this
        },'->',{
            xtype: 'textfield'
            ,id: 'tagger-search-filter'
            ,emptyText: _('tagger.search') + '...'
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
    Tagger.grid.Items.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.grid.Items,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('tagger.item_update')
            ,handler: this.updateItem
        });
        m.push('-');
        m.push({
            text: _('tagger.item_remove')
            ,handler: this.removeItem
        });
        this.addContextMenuItem(m);
    }
    
    ,createItem: function(btn,e) {
        this.createUpdateItem(btn, e, false);
    }

    ,updateItem: function(btn,e) {
        this.createUpdateItem(btn, e, true);
    }

    ,createUpdateItem: function(btn,e,isUpdate) {
        var r;

        if(isUpdate){
            if (!this.menu.record || !this.menu.record.id) return false;
            r = this.menu.record;
        }else{
            r = {};
        }

        var createUpdateItem = MODx.load({
            xtype: 'tagger-window-item-create-update'
            ,isUpdate: isUpdate
            ,title: (isUpdate) ?  _('tagger.item_update') : _('tagger.item_create')
            ,record: r
            ,listeners: {
                'success': {fn:function() { this.refresh(); },scope:this}
            }
        });

        createUpdateItem.fp.getForm().reset();
        createUpdateItem.fp.getForm().setValues(r);
        createUpdateItem.show(e.target);
    }
    
    ,removeItem: function(btn,e) {
        if (!this.menu.record) return false;
        
        MODx.msg.confirm({
            title: _('tagger.item_remove')
            ,text: _('tagger.item_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/item/remove'
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

    ,getDragDropText: function(){
        return this.selModel.selections.items[0].data.name;
    }
});
Ext.reg('tagger-grid-items',Tagger.grid.Items);

Tagger.window.CreateUpdateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'tagger-mecitem'+Ext.id();
    Ext.applyIf(config,{
        id: this.ident
        ,height: 150
        ,width: 475
        ,closeAction: 'close'
        ,url: Tagger.config.connectorUrl
        ,action: (config.isUpdate)? 'mgr/item/update' : 'mgr/item/create'
        ,fields: [{
            xtype: 'textfield'
            ,name: 'id'
            ,id: this.ident+'-id'
            ,hidden: true
        },{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: this.ident+'-name'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: this.ident+'-description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,name: 'position'
            ,id: this.ident+'-position'
            ,hidden: true
        }]
    });
            Tagger.window.CreateUpdateItem.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.window.CreateUpdateItem,MODx.Window);
Ext.reg('tagger-window-item-create-update',Tagger.window.CreateUpdateItem);

