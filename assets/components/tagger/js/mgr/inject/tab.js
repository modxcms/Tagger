Ext.override(MODx.panel.Resource, {
    taggerOriginals: {
        getFields: MODx.panel.Resource.prototype.getFields
        ,setup: MODx.panel.Resource.prototype.setup
        ,beforeSubmit: MODx.panel.Resource.prototype.beforeSubmit
    }
    ,getFields: function(config) {
        var fields = this.taggerOriginals.getFields.call(this, config);

        var taggerFields = this.taggerGetFields(config);

        if (taggerFields['in-tab'].length > 0) {
            var tabs = fields.filter(function (row) {
                if(row.id == 'modx-resource-tabs') {
                    return row;
                } else {
                    return false;
                }
            });

            if (tabs != false && tabs[0]) {
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
                    ,items: taggerFields['in-tab']
                });
            }
        }

        if (taggerFields['above-content'].length > 0 || taggerFields['below-content'].length > 0) {
            var indexOfContent;
            var found = false;

            for (indexOfContent = 0; indexOfContent < fields.length; indexOfContent++) {
                if (fields[indexOfContent].id == 'modx-resource-content') {
                    found = true;
                    break;
                }
            }

            if (taggerFields['above-content'].length > 0) {
                fields.splice(indexOfContent, 0, {
                    title: 'Tagger'
                    ,layout: 'form'
                    ,bodyCssClass: 'main-wrapper'
                    ,autoHeight: true
                    ,collapsible: true
                    ,animCollapse: false
                    ,hideMode: 'offsets'
                    ,items: taggerFields['above-content']
                    ,style: 'margin-top: 10px'
                });

                indexOfContent++;
            }

            if (taggerFields['below-content'].length > 0) {
                fields.splice(indexOfContent + 1, 0, {
                    title: 'Tagger'
                    ,layout: 'form'
                    ,bodyCssClass: 'main-wrapper'
                    ,autoHeight: true
                    ,collapsible: true
                    ,animCollapse: false
                    ,hideMode: 'offsets'
                    ,items: taggerFields['below-content']
                    ,style: 'margin-top: 10px'
                });
            }
        }

        if (taggerFields['bottom-page'].length > 0) {
            fields.push({
                title: 'Tagger'
                ,layout: 'form'
                ,bodyCssClass: 'main-wrapper'
                ,autoHeight: true
                ,collapsible: true
                ,animCollapse: false
                ,hideMode: 'offsets'
                ,items: taggerFields['bottom-page']
                ,style: 'margin-top: 10px'
            });
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
        var fields = {
            'above-content': []
            ,'below-content': []
            ,'bottom-page': []
            ,'in-tab': []
        };

        Ext.each(Tagger.groups, function(group) {
           if (group.show_for_templates.indexOf(parseInt(config.record.template)) != -1) {
               fields[group.place].push({
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
                   ,pageSize: 20
                   ,editable: group.allow_type
                   ,autoTag: group.show_autotag
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
