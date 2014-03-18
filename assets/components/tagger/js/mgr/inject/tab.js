Ext.override(MODx.panel.Resource, {
    taggerOriginals: {
        getFields: MODx.panel.Resource.prototype.getFields
        ,setup: MODx.panel.Resource.prototype.setup
        ,beforeSubmit: MODx.panel.Resource.prototype.beforeSubmit
    }
    ,getFields: function(config) {
        var fields = this.taggerOriginals.getFields.call(this, config);

        var tabs = fields.filter(function (row) {
            if(row.id == 'modx-resource-tabs') {
                return row;
            } else {
                return false;
            }
        });

        if (tabs != false && tabs[0]) {
            var taggerFields = this.taggerGetFields(config);

            if (taggerFields.length > 0) {
                tabs[0].items.push({
                    title: _('tagger')
                    ,layout: 'form'
                    ,forceLayout: true
                    ,deferredRender: false
                    ,labelWidth: 200
                    ,bodyCssClass: 'main-wrapper'
                    ,autoHeight: true
                    ,defaults: {
                        border: false
                        ,msgTarget: 'under'
                    }
                    ,items: this.taggerGetFields(config)
                });
            }
        }

        return fields;
    }

    ,setup: function() {
        if (!this.initialized) {
            this.getForm().setValues(Tagger.tags);
        }

        this.taggerOriginals.setup.call(this);
    }

    ,beforeSubmit: function(o) {
        var tagFields = this.find('xtype', 'tagger-field-tags')

        Ext.each(tagFields, function(tagField) {
            tagField.addItemsFromField();
        });

        this.taggerOriginals.beforeSubmit.call(this, o);
    }

    ,taggerGetFields: function(config) {
        var fields = [];

        Ext.each(Tagger.groups, function(group) {
           if (group.show_for_templates.indexOf(parseInt(config.record.template)) != -1) {
               fields.push({
                   xtype: group.field_type
                   ,fieldLabel: group.name
                   ,name: 'tagger-' + group.id
                   ,hiddenName: 'tagger-' + group.id
                   ,displayField: 'tag'
                   ,valueField: 'tag'
                   ,fields: ['tag']
                   ,url: Tagger.config.connectorUrl
                   ,allowAdd: group.allow_new
                   ,allowBlank: group.allow_blank
                   ,pageSize: 0
                   ,baseParams: {
                       action: 'mgr/extra/gettags'
                       ,group: group.id
                   }
               });
            }
        });

        return fields;
    }
});
