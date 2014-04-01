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
            xtype: 'tagger-combo-group-place'
            ,fieldLabel: _('tagger.group.place')
            ,name: 'place'
            ,hiddenName: 'place'
            ,anchor: '100%'
            ,allowBlank: false
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

Tagger.window.GroupImport = function(config) {
    Ext.applyIf(config,{
        title: _('tagger.group.import')
        ,height: 150
        ,width: 475
        ,closeAction: 'close'
        ,fileUpload: true
        ,url: Tagger.config.connectorUrl
        ,grid: null
        ,action: 'mgr/group/import'
        ,fields: this.getFields(config)
    });
    Tagger.window.GroupImport.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.window.GroupImport,MODx.Window, {
    getFields: function(config) {
        var fields = [{
            xtype: 'tagger-combo-tv'
            ,fieldLabel: _('tagger.group.import_from')
            ,name: 'tv'
            ,hiddenName: 'tv'
            ,anchor: '100%'
            ,allowBlank: false
        },{
            xtype: 'tagger-combo-group'
            ,fieldLabel: _('tagger.group.import_to')
            ,baseParams: {
                action: 'mgr/group/getlist'
                ,fieldType: 'tagger-field-tags'
            }
            ,name: 'group'
            ,hiddenName: 'group'
            ,anchor: '100%'
            ,allowBlank: false
        }];

        return fields;
    }

});
Ext.reg('tagger-window-group-import',Tagger.window.GroupImport);

