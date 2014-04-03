Tagger.window.Tag = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('tagger.tag.create')
        ,height: 150
        ,width: 475
        ,closeAction: 'close'
        ,fileUpload: true
        ,isUpdate: false
        ,url: Tagger.config.connectorUrl
        ,action: 'mgr/tag/create'
        ,fields: this.getFields(config)
    });
    Tagger.window.Tag.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.window.Tag,MODx.Window, {
    getFields: function(config) {
        var fields = [{
            xtype: 'textfield'
            ,name: 'id'
            ,anchor: '100%'
            ,hidden: true
        },{
            xtype: 'textfield'
            ,fieldLabel: _('tagger.tag.name')
            ,name: 'tag'
            ,anchor: '100%'
            ,allowBlank: false
        },{
            xtype: 'tagger-combo-group'
            ,fieldLabel: _('tagger.tag.group')
            ,name: 'group'
            ,hiddenName: 'group'
            ,anchor: '100%'
            ,allowBlank: false
            ,readOnly: config.isUpdate
            ,cls: (config.isUpdate == true) ? 'x-item-disabled' : ''
        }];

        return fields;
    }
});
Ext.reg('tagger-window-tag',Tagger.window.Tag);

Tagger.window.AssignedResources = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('tagger.tag.assigned_resources')
        ,width: '60%'
        ,y: 40
        ,closeAction: 'close'
        ,url: Tagger.config.connectorUrl
        ,tagId: 0
        ,items: this.getFields(config)
        ,buttons: [{
            text: _('cancel')
            ,scope: this
            ,handler: function() {
                this.close();
            }
        }]
    });
    Tagger.window.AssignedResources.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.window.AssignedResources,MODx.Window, {
    getFields: function(config) {
        return [{
            xtype: 'tagger-grid-assigned-resources'
            ,baseParams: {
                action: 'mgr/tag/getassignedresources'
                ,tagId: config.tagId
            }
            ,preventRender: true
            ,cls: 'main-wrapper'
        }];
    }
});
Ext.reg('tagger-window-assigned-resources',Tagger.window.AssignedResources);
