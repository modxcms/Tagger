Tagger.window.Group = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('tagger.group.create')
        ,height: 150
        ,width: 475
        ,closeAction: 'close'
        ,fileUpload: true
        ,url: Tagger.config.connectorUrl
        ,action: 'mgr/group/create'
        ,fields: this.getFields(config)
    });
    Tagger.window.Group.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.window.Group,MODx.Window, {
    getFields: function(config) {
        var fields = [{
            xtype: 'textfield'
            ,name: 'id'
            ,anchor: '100%'
            ,hidden: true
        },{
            xtype: 'textfield'
            ,fieldLabel: _('tagger.group.name')
            ,name: 'name'
            ,anchor: '100%'
            ,allowBlank: false
        }];

        return fields;
    }
});
Ext.reg('tagger-window-group',Tagger.window.Group);

