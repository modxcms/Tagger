Tagger.window.Group = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('tagger.group.create')
        ,width: 600
        ,closeAction: 'close'
        ,fileUpload: true
        ,url: Tagger.config.connectorUrl
        ,action: 'mgr/group/create'
        ,fields: this.getFields(config)
        ,autoHeight: true
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
            layout: 'column'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                layout: 'form'
                ,labelAlign: 'top'
                ,labelSeparator: ''
                ,anchor: '100%'
                ,border: false
            }
            ,items: [{
                columnWidth:.5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: this.getLeftColumnFields(config)
            },{
                columnWidth: .5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: this.getRightColumnFields(config)
            }]
        }];

        return fields;
    }

    ,getLeftColumnFields: function(config) {
        return [{
            xtype: 'textfield'
            ,fieldLabel: _('tagger.group.name')
            ,description: _('tagger.group.name_desc')
            ,name: 'name'
            ,allowBlank: false
        },{
            xtype: 'textarea'
            ,fieldLabel: _('tagger.group.description')
            ,description: _('tagger.group.description_desc')
            ,name: 'description'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('tagger.group.alias')
            ,description: _('tagger.group.alias_desc')
            ,name: 'alias'
            ,allowBlank: true
        },{
            xtype: 'tagger-combo-group-place'
            ,fieldLabel: _('tagger.group.place')
            ,description: _('tagger.group.place_desc')
            ,name: 'place'
            ,hiddenName: 'place'
            ,allowBlank: false
            ,listeners: {
                select: {fn: function(t, rec) {
                    var els = this.find('name', 'in_tvs_position');
                    if (els.length == 1) {
                        if (rec.data.v == 'in-tvs') {
                            els[0].show();
                        } else {
                            els[0].hide();
                        }
                    }
                }, scope: this}
            }
        },{
            xtype: 'numberfield'
            ,fieldLabel: _('tagger.group.in_tvs_position')
            ,description: _('tagger.group.in_tvs_position_desc')
            ,name: 'in_tvs_position'
            ,allowDecimals: false
            ,allowNegative: false
            ,hidden: config.record == undefined || config.record.place != 'in-tvs'
            ,value: (config.record && config.record.in_tvs_position) ? config.record.in_tvs_position : 9999
        },{
            xtype: 'textfield'
            ,fieldLabel: _('tagger.group.show_for_templates')
            ,description: _('tagger.group.show_for_templates_desc')
            ,name: 'show_for_templates'
            ,hiddenName: 'show_for_templates'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('tagger.group.show_for_contexts')
            ,description: _('tagger.group.show_for_contexts_desc')
            ,name: 'show_for_contexts'
            ,hiddenName: 'show_for_contexts'
        }];
    }

    ,getRightColumnFields: function(config) {
        return [{
            xtype: 'tagger-combo-field-type'
            ,fieldLabel: _('tagger.group.field_type')
            ,description: _('tagger.group.field_type_desc')
            ,name: 'field_type'
            ,hiddenName: 'field_type'
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

                    var ehi = this.find('name', 'hide_input');
                    if (ehi.length == 1) {
                        if (rec.data.v == 'tagger-field-tags') {
                            if (els.length == 1 && els[0].getValue() == 1) {
                                ehi[0].show();
                            }
                        } else {
                            ehi[0].hide();
                        }
                    }

                    var etl = this.find('name', 'tag_limit');
                    if (etl.length == 1) {
                        if (rec.data.v == 'tagger-field-tags') {
                            etl[0].show();
                        } else {
                            etl[0].hide();
                        }
                    }
                }, scope: this}
            }
        },{
            layout: 'column'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                layout: 'form'
                ,labelAlign: 'top'
                ,labelSeparator: ''
                ,anchor: '100%'
                ,border: false
            }
            ,items: [{
                columnWidth:.5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: [{
                    xtype: 'tagger-combo-sort-field'
                    ,fieldLabel: _('tagger.group.sort_field')
                    ,description: _('tagger.group.sort_field_desc')
                    ,name: 'sort_field',
                    hiddenName: 'sort_field'
                }]
            },{
                columnWidth: .5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: [{
                    xtype: 'tagger-combo-sort-dir'
                    ,fieldLabel: _('tagger.group.sort_dir')
                    ,description: _('tagger.group.sort_dir_desc')
                    ,name: 'sort_dir',
                    hiddenName: 'sort_dir'
                }]
            }]
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('tagger.group.remove_unused')
            ,description: _('tagger.group.remove_unused_desc')
            ,name: 'remove_unused'
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('tagger.group.allow_new')
            ,description: _('tagger.group.allow_new_desc')
            ,name: 'allow_new'
        },{
            layout: 'column'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                layout: 'form'
                ,labelAlign: 'top'
                ,labelSeparator: ''
                ,anchor: '100%'
                ,border: false
            }
            ,items: [{
                columnWidth:.5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: [{
                    xtype: 'xcheckbox'
                    ,fieldLabel: _('tagger.group.allow_blank')
                    ,description: _('tagger.group.allow_blank_desc')
                    ,name: 'allow_blank'
                }]
            },{
                columnWidth: .5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: [{
                    xtype: 'xcheckbox'
                    ,fieldLabel: _('tagger.group.allow_type')
                    ,description: _('tagger.group.allow_type_desc')
                    ,name: 'allow_type'
                }]
            }]
        },{
            layout: 'column'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                layout: 'form'
                ,labelAlign: 'top'
                ,labelSeparator: ''
                ,anchor: '100%'
                ,border: false
            }
            ,items: [{
                columnWidth:.5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: [{
                    xtype: 'xcheckbox'
                    ,fieldLabel: _('tagger.group.show_autotag')
                    ,description: _('tagger.group.show_autotag_desc')
                    ,name: 'show_autotag'
                    ,hidden: config.record && config.record.field_type != 'tagger-field-tags'
                    ,listeners: {
                        check: function(t, checked) {
                            var els = this.find('name', 'hide_input');
                            if (els.length == 1) {
                                if (checked) {
                                    els[0].show();
                                } else {
                                    els[0].hide();
                                }
                            }
                            try {
                                this.checkAsRadio(this.fp.form.getValues());
                            } catch (err) {}
                        }
                        ,scope: this
                    }
                }]
            },{
                columnWidth: .5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: [{
                    xtype: 'xcheckbox'
                    ,fieldLabel: _('tagger.group.hide_input')
                    ,description: _('tagger.group.hide_input_desc')
                    ,name: 'hide_input'
                    ,hidden: config.record == undefined || config.record.show_autotag != 1
                    ,listeners: {
                        check: function(t, checked) {
                            try {
                                this.checkAsRadio(this.fp.form.getValues());
                            } catch (err) {}
                        }
                        ,scope: this
                    }
                }]
            }]
        },{
            layout: 'column'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                layout: 'form'
                ,labelAlign: 'top'
                ,labelSeparator: ''
                ,anchor: '100%'
                ,border: false
            }
            ,items: [{
                columnWidth:.5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: [{
                    xtype: 'xcheckbox'
                    ,fieldLabel: _('tagger.group.as_radio')
                    ,description: _('tagger.group.as_radio_desc')
                    ,name: 'as_radio'
                    ,hidden: config.record == undefined || (!((config.record.show_autotag == 1) && (config.record.tag_limit == 1) && (config.record.hide_input == 1)))
                }]
            },{
                columnWidth: .5
                ,border: false
                ,defaults: {
                    msgTarget: 'under'
                    ,anchor: '100%'
                }
                ,items: []
            }]
        },{
            xtype: 'numberfield'
            ,fieldLabel: _('tagger.group.tag_limit')
            ,description: _('tagger.group.tag_limit_desc')
            ,name: 'tag_limit'
            ,hidden: false
            ,allowNegative: false
            ,allowDecimals: false
            ,hiddenName: 'tag_limit'
            ,enableKeyEvents: true
            ,value: (config.record && config.record.tag_limit) ? config.record.tag_limit : 0
            ,listeners: {
                keyup: {
                    fn: function() {
                        try {
                            this.checkAsRadio(this.fp.form.getValues());
                        } catch (err) {}
                    },
                    scope: this
                }
            }
        }];
    }
    
    ,checkAsRadio: function(formValues) {
        var els = this.find('name', 'as_radio');
        if (els.length == 1) {
            if ((formValues.show_autotag == 1) && (formValues.hide_input == 1) && (formValues.tag_limit == 1)) {
                els[0].show();
            } else {
                els[0].hide();
            }
        }
    }
});
Ext.reg('tagger-window-group',Tagger.window.Group);

Tagger.window.GroupImport = function(config) {
    Ext.applyIf(config,{
        title: _('tagger.group.import')
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

