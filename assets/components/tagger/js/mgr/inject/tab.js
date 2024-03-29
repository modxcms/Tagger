Ext.override(MODx.panel.Resource, {
    taggerOriginals: {
        getFields: MODx.panel.Resource.prototype.getFields,
        beforeSubmit: MODx.panel.Resource.prototype.beforeSubmit
    },

    taggerFields: {},
    taggerLabels: {},
    taggerInitDone: false,

    getFields: function(config) {
        var fields = this.taggerOriginals.getFields.call(this, config);

        if (this.taggerInitDone === true) return fields;
        this.taggerInitDone = true;

        this.taggerFields = this.taggerGetFields(config);
        this.taggerLabels = this.taggerGetLabels(config);

        if (this.taggerFields['in-tab'].length > 0) {
            var tabs = fields.filter(function (row) {
                if(row.id === 'modx-resource-tabs') {
                    return row;
                } else {
                    return false;
                }
            });

            if (tabs !== false && tabs[0]) {
                tabs[0].items.push({
                    title: this.taggerLabels['in_tab'],
                    id: 'tagger-resource-tab',
                    layout: 'form',
                    forceLayout: true,
                    deferredRender: false,
                    labelWidth: 200,
                    bodyCssClass: 'main-wrapper',
                    autoHeight: true,
                    labelAlign: 'top',
                    defaults: {
                        border: false
                        ,msgTarget: 'under'
                        ,labelSeparator: ''
                    }
                    ,items: this.taggerFields['in-tab']
                });
            }
        }

        // if (this.taggerFields['above-content'].length > 0 || this.taggerFields['below-content'].length > 0) {
        //     var indexOfContent;
        //     var found = false;
        //
        //     for (indexOfContent = 0; indexOfContent < fields.length; indexOfContent++) {
        //         if (fields[indexOfContent].id === 'modx-resource-content') {
        //             found = true;
        //             break;
        //         }
        //     }
        //
        //     if (this.taggerFields['above-content'].length > 0) {
        //         fields.splice(
        //             indexOfContent,
        //             0,
        //             this.placeFields('above_content', this.taggerFields['above-content'])
        //         );
        //
        //         indexOfContent++;
        //     }
        //
        //     if (this.taggerFields['below-content'].length > 0) {
        //         fields.splice(
        //             indexOfContent + 1,
        //             0,
        //             this.placeFields('below_content', this.taggerFields['below-content'])
        //         );
        //     }
        // }

        if (this.taggerFields['bottom-page'].length > 0) {
            fields.push(
                this.placeFields('bottom_page', this.taggerFields['bottom-page'])
            );
        }

        if (this.taggerFields['in-tvs'].length > 0) {
            Ext.onReady(function() {
                var tvTab = Ext.getCmp('modx-resource-vtabs');
                if (tvTab) {
                    tvTab.insert(this.taggerFields['in-tvs'][0].inTVsPosition, {
                        title: this.taggerLabels['tvs_tab'],
                        layout: 'form',
                        forceLayout: true,
                        deferredRender: false,
                        labelWidth: 200,
                        bodyCssClass: 'main-wrapper',
                        autoHeight: true,
                        labelAlign: 'top',
                        defaults: {
                            border: false,
                            msgTarget: 'under',
                            labelSeparator: '',
                            anchor: '100%'
                        },
                        items: this.taggerFields['in-tvs']
                    });

                    if (this.taggerFields['in-tvs'][0].inTVsPosition === 0) {
                        tvTab.setActiveTab(0);

                        var tvPanel = Ext.getCmp('modx-panel-resource-tv');
                        tvPanel.on('show', function () {
                            tvTab.doLayout();
                        }, this, {single: true});
                    }
                } else {
                    var taggerResourceTab = Ext.getCmp('tagger-resource-tab');
                    if (taggerResourceTab) {
                        taggerResourceTab.add(this.taggerFields['in-tvs']);
                    } else {
                        var resTab = Ext.getCmp('modx-resource-tabs');
                        resTab.add({
                            title: this.taggerLabels['tvs_tab'],
                            id: 'tagger-resource-tab',
                            layout: 'form',
                            forceLayout: true,
                            deferredRender: false,
                            labelWidth: 200,
                            bodyCssClass: 'main-wrapper',
                            autoHeight: true,
                            labelAlign: 'top',
                            defaults: {
                                border: false,
                                msgTarget: 'under',
                                labelSeparator: '',
                                anchor: '100%'
                            },
                            items: this.taggerFields['in-tvs']
                        });
                    }
                }
            }, this, {delay: 1});
        }

        return fields;
    }     ,

    /**
     * Convenient method to help generate the fields container
     *
     * @param {String} position (above_content||below_content||bottom_page)
     * @param {Object} fields
     *
     * @returns {Object}
     */
    placeFields: function(position, fields) {
        var key = 'tagger.place_'+ position +'_header';

        return {
            title: (MODx.config[key] == 1) ? this.taggerLabels[position] : '',
            layout: 'form',
            bodyCssClass: 'tab-panel-wrapper main-wrapper',
            autoHeight: true,
            collapsible: MODx.config[key] == 1,
            animCollapse: false,
            hideMode: 'offsets',
            items: fields,
            cls: 'container tagger-header',
            labelSeparator: '',
            labelAlign: 'top'
        };
    },

    beforeSubmit: function(o) {
        var tagFields = this.find('xtype', 'tagger-field-tags');

        Ext.each(tagFields, function(tagField) {
            tagField.addItemsFromField();
        });

        this.taggerOriginals.beforeSubmit.call(this, o);
    } ,

    taggerGetFields: function(config) {
        var fields = {
            'bottom-page': [],
            'in-tab': [],
            'in-tvs': []
        };

        Ext.each(tagger.groups, function(group) {
           if ((group.show_for_templates.indexOf(parseInt(config.record.template)) !== -1) && ((group.show_for_contexts.length === 0) || (group.show_for_contexts.indexOf(config.record.context_key) !== -1))) {
               var groupName = _('tagger.custom.' + group.alias);
               var groupDescription = _('tagger.custom.' + group.alias + '_desc');
               if (group.place === 'above-content') group.place = 'bottom-page';
               if (group.place === 'below-content') group.place = 'bottom-page';

               fields[group.place].push({
                   xtype: group.field_type,
                   inTVsPosition: group.in_tvs_position,
                   fieldLabel: groupName ? groupName : group.name,
                   name: 'tagger-' + group.id,
                   description: groupDescription ? groupDescription : group.description,
                   hiddenName: 'tagger-' + group.id,
                   displayField: 'tag',
                   valueField: 'tag',
                   fields: ['tag'],
                   url: MODx.config.connector_url,
                   allowAdd: group.allow_new,
                   allowBlank: group.allow_blank,
                   pageSize: 20,
                   editable: group.allow_type,
                   autoTag: group.show_autotag,
                   hideInput: group.hide_input,
                   tagLimit: group.tag_limit,
                   asRadio: group.as_radio,
                   anchor: '100%',
                   value: tagger.tags['tagger-' + group.id] ? tagger.tags['tagger-' + group.id] : '',
                   baseParams: {
                       action: 'Tagger\\Processors\\Extra\\GetTags',
                       group: group.id,
                       sort_field: group.sort_field,
                       sort_dir: group.sort_dir
                   }
               });
            }
        });

        return fields;
    },

    taggerGetLabels: function(config) {
        return {
            'bottom_page': this.taggerGetLabel('bottom_page', config.record.template),
            'in_tab': this.taggerGetLabel('in_tab', config.record.template),
            'tvs_tab': this.taggerGetLabel('tvs_tab', config.record.template)
        };
    },

    taggerGetLabel: function(place, template) {
        var labels = MODx.config['tagger.place_' + place + '_label'];

        if (labels === undefined) return _('tagger.tab.label');

        if (labels.indexOf('||') === -1 && labels.indexOf('==') === -1) {
            if (_(labels) === undefined) {
                return labels;
            }

            return _(labels);
        }

        var placeLabel = _('tagger.tab.label');

        labels = labels.split('||');
        Ext.each(labels, function (label) {
            label = label.split('==');

            if (label.length === 2) {
                if (label[0] === template) {
                    if (_(label[1]) === undefined) {
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
