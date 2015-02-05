Ext.override(MODx.panel.Resource, {
    taggerOriginals: {
        getFields: MODx.panel.Resource.prototype.getFields
        ,beforeSubmit: MODx.panel.Resource.prototype.beforeSubmit
    }

    ,taggerFields: {}
    ,taggerLabels: {}

    ,getFields: function(config) {
        var fields = this.taggerOriginals.getFields.call(this, config);

        this.taggerFields = this.taggerGetFields(config);
        this.taggerLabels = this.taggerGetLabels(config);

        if (this.taggerFields['in-tab'].length > 0) {
            var tabs = fields.filter(function (row) {
                if(row.id == 'modx-resource-tabs') {
                    return row;
                } else {
                    return false;
                }
            });

            if (tabs != false && tabs[0]) {
                tabs[0].items.push({
                    title: this.taggerLabels['in_tab']
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
                    ,items: this.taggerFields['in-tab']
                });
            }
        }

        if (this.taggerFields['above-content'].length > 0 || this.taggerFields['below-content'].length > 0) {
            var indexOfContent;
            var found = false;

            for (indexOfContent = 0; indexOfContent < fields.length; indexOfContent++) {
                if (fields[indexOfContent].id == 'modx-resource-content') {
                    found = true;
                    break;
                }
            }

            if (this.taggerFields['above-content'].length > 0) {
                fields.splice(
                    indexOfContent
                    ,0
                    ,this.placeFields('above_content', this.taggerFields['above-content'])
                );

                indexOfContent++;
            }

            if (this.taggerFields['below-content'].length > 0) {
                fields.splice(
                    indexOfContent + 1
                    ,0
                    ,this.placeFields('below_content', this.taggerFields['below-content'])
                );
            }
        }

        if (this.taggerFields['bottom-page'].length > 0) {
            fields.push(
                this.placeFields('bottom_page', this.taggerFields['bottom-page'])
            );
        }

        if (this.taggerFields['in-tvs'].length > 0) {
            Ext.onReady(function() {
                var tvTab = Ext.getCmp('modx-resource-vtabs');

                tvTab.insert(this.taggerFields['in-tvs'][0].inTVsPosition, {
                    title: this.taggerLabels['tvs_tab']
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
                        ,anchor: '100%'
                    }
                    ,items: this.taggerFields['in-tvs']
                });

                if (this.taggerFields['in-tvs'][0].inTVsPosition == 0) {
                    tvTab.setActiveTab(0);

                    var tvPanel = Ext.getCmp('modx-panel-resource-tv');
                    tvPanel.on('show', function () {
                        tvTab.doLayout();
                    }, this, {single: true});
                }

            }, this, {delay: 1});
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
            title: (MODx.config[key] == 1) ? this.taggerLabels[position] : ''
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
            ,'in-tvs': []
        };

        Ext.each(Tagger.groups, function(group) {
           if (group.show_for_templates.indexOf(parseInt(config.record.template)) != -1) {
               var groupName = _('tagger.custom.' + group.alias);
               var groupDescription = _('tagger.custom.' + group.alias + '_desc');
               fields[group.place].push({
                   xtype: group.field_type
                   ,inTVsPosition: group.in_tvs_position
                   ,fieldLabel: groupName ? groupName : group.name
                   ,name: 'tagger-' + group.id
                   ,description: groupDescription ? groupDescription : group.description
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
                   ,value: Tagger.tags['tagger-' + group.id] ? Tagger.tags['tagger-' + group.id] : ''
                   ,baseParams: {
                       action: 'mgr/extra/gettags'
                       ,group: group.id
                   }
               });
            }
        });

        return fields;
    }

    ,taggerGetLabels: function(config) {
        return {
            'above_content': this.taggerGetLabel('above_content', config.record.template)
            ,'below_content': this.taggerGetLabel('below_content', config.record.template)
            ,'bottom_page': this.taggerGetLabel('bottom_page', config.record.template)
            ,'in_tab': this.taggerGetLabel('in_tab', config.record.template)
            ,'tvs_tab': this.taggerGetLabel('tvs_tab', config.record.template)
        };
    }

    ,taggerGetLabel: function(place, template) {
        var labels = MODx.config['tagger.place_' + place + '_label'];

        if (labels == undefined) return _('tagger.tab.label');

        if (labels.indexOf('||') == -1 && labels.indexOf('==') == -1) {
            if (_(labels) == undefined) {
                return labels;
            }

            return _(labels);
        }

        var placeLabel = _('tagger.tab.label');

        labels = labels.split('||');
        Ext.each(labels, function (label) {
            label = label.split('==');

            if (label.length == 2) {
                if (label[0] == template) {
                    if (_(label[1]) == undefined) {
                        placeLabel = label[1];
                    } else {
                        placeLabel = _(label[1]);
                    }

                    return false;
                }
            }
        }, this);

        return placeLabel;
    }
});
