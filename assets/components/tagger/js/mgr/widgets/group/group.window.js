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
        },{
            xtype: 'tagger-combo-field-type'
            ,fieldLabel: _('tagger.group.field_type')
            ,name: 'field_type'
            ,hiddenName: 'field_type'
            ,anchor: '100%'
            ,allowBlank: false
            ,listeners: {
                select: {fn: function(t, rec) {
                    var els = this.find('name', 'show_autotag');
                    if (els.length == 1) {
                        if (rec.data.v == 'tagger-field-tags') {
                            els[0].show();
                        } else {
                            els[0].hide();
                        }
                    }
                }, scope: this}
            }
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('tagger.group.remove_unused')
            ,name: 'remove_unused'
            ,anchor: '100%'
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('tagger.group.allow_new')
            ,name: 'allow_new'
            ,anchor: '100%'
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('tagger.group.allow_blank')
            ,name: 'allow_blank'
            ,anchor: '100%'
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('tagger.group.allow_type')
            ,name: 'allow_type'
            ,anchor: '100%'
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('tagger.group.show_autotag')
            ,name: 'show_autotag'
            ,anchor: '100%'
            ,hidden: config.record && config.record.field_type != 'tagger-field-tags'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('tagger.group.show_for_templates')
            ,name: 'show_for_templates'
            ,anchor: '100%'
            ,hiddenName: 'show_for_templates'
        }];

        return fields;
    }
});
Ext.reg('tagger-window-group',Tagger.window.Group);

