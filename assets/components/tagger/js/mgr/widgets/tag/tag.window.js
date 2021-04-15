tagger.window.Tag = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('tagger.tag.create'),
        width: 475,
        closeAction: 'close',
        isUpdate: false,
        url: MODx.config.connector_url,
        action: 'Tagger\\Processors\\Tag\\Create',
        fields: this.getFields(config)
    });
    tagger.window.Tag.superclass.constructor.call(this,config);
};
Ext.extend(tagger.window.Tag,MODx.Window, {
    getFields: function(config) {
        return [{
            xtype: 'textfield',
            name: 'id',
            anchor: '100%',
            hidden: true
        },{
            xtype: 'textfield',
            fieldLabel: _('tagger.tag.name'),
            name: 'tag',
            anchor: '100%',
            allowBlank: false
        },{
            xtype: 'textfield',
            fieldLabel: _('tagger.tag.label'),
            name: 'label',
            anchor: '100%',
            allowBlank: true
        },{
            xtype: 'textfield',
            fieldLabel: _('tagger.tag.alias'),
            name: 'alias',
            anchor: '100%',
            allowBlank: true
        },{
            xtype: 'tagger-combo-group',
            fieldLabel: _('tagger.tag.group'),
            name: 'group',
            hiddenName: 'group',
            anchor: '100%',
            allowBlank: false,
            readOnly: config.isUpdate,
            cls: (config.isUpdate == true) ? 'x-item-disabled' : ''
        }];
    }
});
Ext.reg('tagger-window-tag',tagger.window.Tag);

tagger.window.AssignedResources = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('tagger.tag.assigned_resources'),
        width: '60%',
        y: 40,
        closeAction: 'close',
        url: MODx.config.connector_url,
        tagId: 0,
        items: this.getFields(config),
        buttons: [{
            text: _('cancel'),
            scope: this,
            handler: function() {
                this.close();
            }
        }]
    });
    tagger.window.AssignedResources.superclass.constructor.call(this,config);
};
Ext.extend(tagger.window.AssignedResources,MODx.Window, {
    getFields: function(config) {
        return [{
            xtype: 'tagger-grid-assigned-resources',
            baseParams: {
                action: 'Tagger\\Processors\\Tag\\GetAssignedResources',
                tagId: config.tagId
            },
            preventRender: true,
            cls: 'main-wrapper'
        }];
    }
});
Ext.reg('tagger-window-assigned-resources',tagger.window.AssignedResources);

tagger.window.MergeTags = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('tagger.tag.merge'),
        width: 475,
        closeAction: 'close',
        url: MODx.config.connector_url,
        action: 'Tagger\\Processors\\Tag\\Create',
        fields: this.getFields(config)
    });
    tagger.window.MergeTags.superclass.constructor.call(this,config);
};
Ext.extend(tagger.window.MergeTags,MODx.Window, {
    getFields: function(config) {
        return [{
            xtype: 'textfield',
            name: 'tags',
            anchor: '100%',
            hidden: true
        },{
            html: '<p><strong>Tags:</strong> ' + config.record.tagNames + '</p><p><strong>Will be merged as</strong></p>',
            border: false,
            bodyCssClass: 'panel-desc tagger-window-desc',
            readOnly: true
        },{
            xtype: 'textfield',
            fieldLabel: _('tagger.tag.name'),
            name: 'name',
            anchor: '100%',
            allowBlank: false
        },{
            xtype: 'tagger-combo-group',
            fieldLabel: _('tagger.tag.group'),
            name: 'group',
            anchor: '100%',
            allowBlank: false,
            readOnly: true,
            disable: true,
            cls: 'x-item-disabled'
        }];
    }
});
Ext.reg('tagger-window-merge-tags',tagger.window.MergeTags);
