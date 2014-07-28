Ext.override(MODx.panel.Resource, {
    taggerOriginals: {
        getFields: MODx.panel.Resource.prototype.getFields
        ,setup: MODx.panel.Resource.prototype.setup
        ,beforeSubmit: MODx.panel.Resource.prototype.beforeSubmit
    }

    ,getFields: function(config) {
        var fields = this.taggerOriginals.getFields.call(this, config)
            ,taggerFields = this.taggerGetFields(config)
            ,tabLabel = _('tagger.tab.label');

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
                    title: tabLabel
                    ,layout: 'form'
                    ,forceLayout: true
                    ,deferredRender: false
                    ,labelWidth: 200
                    ,bodyCssClass: 'main-wrapper'
                    ,autoHeight: true
                    ,labelAlign: 'top'
                    ,defaults: {
                        border: false
                        ,msgTarget: 'under'
                        ,labelSeparator: ''
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
                fields.splice(
                    indexOfContent
                    ,0
                    ,this.placeFields('above_content', taggerFields['above-content'])
                );

                indexOfContent++;
            }

            if (taggerFields['below-content'].length > 0) {
                fields.splice(
                    indexOfContent + 1
                    ,0
                    ,this.placeFields('below_content', taggerFields['below-content'])
                );
            }
        }

        if (taggerFields['bottom-page'].length > 0) {
            fields.push(
                this.placeFields('bottom_page', taggerFields['bottom-page'])
            );
        }

        return fields;
    }

    /**
     * Convenient method to help generate the fields container
     *
     * @param {String} position (above_content||below_content||bottom_page)
     * @param {Object} fields
     *
     * @returns {Object}
     */
    ,placeFields: function(position, fields) {
        var key = 'tagger.place_'+ position +'_header';

        return {
            title: (MODx.config[key] == 1) ? _('tagger.tab.label') : ''
            ,layout: 'form'
            ,bodyCssClass: 'main-wrapper'
            ,autoHeight: true
            ,collapsible: MODx.config[key] == 1
            ,animCollapse: false
            ,hideMode: 'offsets'
            ,items: fields
            ,style: 'margin-top: 10px;'
            ,cls: 'tagger-header'
            ,labelSeparator: ''
            ,labelAlign: 'top'
        };
    }

    ,setup: function() {
        if (!this.initialized) {
            this.getForm().setValues(Tagger.tags);
        }

        this.taggerOriginals.setup.call(this);
    }

    ,beforeSubmit: function(o) {
        var tagFields = this.find('xtype', 'tagger-field-tags');

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
                   ,description: group.description
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
                   ,hideInput: group.hide_input
                   ,tagLimit: group.tag_limit
                   ,anchor: '100%'
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
