var originalGetFields = MODx.panel.Resource.prototype.getFields;
Ext.override(MODx.panel.Resource, {
    getFields: function(config) {
        var fields = originalGetFields.call(this, config);

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
                ,items: this.taggerGetFields(config)
            });
        }

        return fields;
    }

    ,taggerGetFields: function(config) {
        var fields = [];

        Ext.each(Tagger.groups, function(group) {
           fields.push({
               xtype: 'tagger-field-tags'
               ,fieldLabel: group.name
               ,name: 'tagger-' + group.id
               ,hiddenName: 'tagger-' + group.id
               ,displayField: 'tag'
               ,valueField: 'id'
               ,fields: ['tag','id']
               ,url: Tagger.config.connectorUrl
               ,baseParams: {
                   action: 'mgr/tag/getlist'
                   ,group: group.id
               }
           });
        });

        return fields;
    }
});