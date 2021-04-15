tagger.combo.Group = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'group',
        hiddenName: 'group',
        displayField: 'name',
        valueField: 'id',
        fields: ['name','id'],
        pageSize: 20,
        url: MODx.config.connector_url,
        baseParams:{
            action: 'Tagger\\Processors\\Group\\GetList'
        }
    });
    tagger.combo.Group.superclass.constructor.call(this,config);
};
Ext.extend(tagger.combo.Group,MODx.combo.ComboBox);
Ext.reg('tagger-combo-group',tagger.combo.Group);

tagger.combo.Tag = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'tag',
        hiddenName: 'tag',
        displayField: 'tag',
        valueField: 'id',
        fields: ['tag','id'],
        pageSize: 20,
        editable: config.allowAdd,
        forceSelection: !config.allowAdd,
        url: MODx.config.connector_url,
        baseParams: {
            action: 'Tagger\\Processors\\Tag\\GetList'
        }
    });
    tagger.combo.Tag.superclass.constructor.call(this,config);
};
Ext.extend(tagger.combo.Tag,MODx.combo.ComboBox);
Ext.reg('tagger-combo-tag',tagger.combo.Tag);

tagger.combo.FieldType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['d','v'],
            data: [
                [_('tagger.field.tagfield') ,'tagger-field-tags'],
                [_('tagger.field.combobox') ,'tagger-combo-tag']
            ]
        }),
        displayField: 'd',
        valueField: 'v',
        mode: 'local',
        value: 'tagger-field-tags',
        triggerAction: 'all',
        editable: false,
        selectOnFocus: false,
        preventRender: true,
        forceSelection: true,
        enableKeyEvents: true
    });
    tagger.combo.FieldType.superclass.constructor.call(this,config);
};
Ext.extend(tagger.combo.FieldType,MODx.combo.ComboBox);
Ext.reg('tagger-combo-field-type',tagger.combo.FieldType);

tagger.combo.Templates = function(config, getStore) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'templates',
        hiddenName: 'templates',
        displayField: 'templatename',
        valueField: 'id',
        fields: ['templatename','id'],
        mode: 'remote',
        triggerAction: 'all',
        typeAhead: true,
        editable: true,
        forceSelection: true,
        pageSize: 20,
        url: MODx.config.connector_url,
        baseParams: {
            action: 'MODX\\Revolution\\Processors\\Element\\Template\\GetList'
        }
    });
    Ext.applyIf(config,{
        store: new Ext.data.JsonStore({
            url: config.url,
            root: 'results',
            totalProperty: 'total',
            fields: config.fields,
            errorReader: MODx.util.JSONReader,
            baseParams: config.baseParams || {},
            remoteSort: config.remoteSort || false,
            autoDestroy: true
        })
    });
    if (getStore === true) {
        config.store.load();
        return config.store;
    }
    tagger.combo.Templates.superclass.constructor.call(this,config);
    this.config = config;
    return this;
};
Ext.extend(tagger.combo.Templates,Ext.ux.form.SuperBoxSelect);
Ext.reg('tagger-combo-templates',tagger.combo.Templates);

tagger.combo.TV = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'tv',
        hiddenName: 'tv',
        displayField: 'name',
        valueField: 'id',
        fields: ['name','id'],
        pageSize: 20,
        url: MODx.config.connector_url,
        baseParams:{
            action: 'Tagger\\Processors\\Extra\\GetTVs'
        }
    });
    tagger.combo.TV.superclass.constructor.call(this,config);
};
Ext.extend(tagger.combo.TV,MODx.combo.ComboBox);
Ext.reg('tagger-combo-tv',tagger.combo.TV);

tagger.combo.GroupPlace = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['d','v'],
            data: [
                [_('tagger.group.place_in_tab') ,'in-tab'],
                [_('tagger.group.place_tvs_tab') ,'in-tvs'],
                [_('tagger.group.place_bottom_page') ,'bottom-page']
            ]
        }),
        displayField: 'd',
        valueField: 'v',
        mode: 'local',
        value: 'in-tab',
        triggerAction: 'all',
        editable: false,
        selectOnFocus: false,
        preventRender: true,
        forceSelection: true,
        enableKeyEvents: true
    });
    tagger.combo.GroupPlace.superclass.constructor.call(this,config);
};
Ext.extend(tagger.combo.GroupPlace,MODx.combo.ComboBox);
Ext.reg('tagger-combo-group-place',tagger.combo.GroupPlace);

tagger.combo.SortDir = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['d','v'],
            data: [
                [_('tagger.group.sort_asc') ,'asc'],
                [_('tagger.group.sort_desc') ,'desc']
            ]
        }),
        displayField: 'd',
        valueField: 'v',
        mode: 'local',
        value: 'asc',
        triggerAction: 'all',
        editable: false,
        selectOnFocus: false,
        preventRender: true,
        forceSelection: true,
        enableKeyEvents: true
    });
    tagger.combo.SortDir.superclass.constructor.call(this,config);
};
Ext.extend(tagger.combo.SortDir,MODx.combo.ComboBox);
Ext.reg('tagger-combo-sort-dir',tagger.combo.SortDir);

tagger.combo.SortField = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['d','v'],
            data: [
                [_('tagger.group.sort_field_alias') ,'alias'],
                [_('tagger.group.sort_field_rank') ,'rank']
            ]
        }),
        displayField: 'd',
        valueField: 'v',
        mode: 'local',
        value: 'alias',
        triggerAction: 'all',
        editable: false,
        selectOnFocus: false,
        preventRender: true,
        forceSelection: true,
        enableKeyEvents: true
    });
    tagger.combo.SortField.superclass.constructor.call(this,config);
};
Ext.extend(tagger.combo.SortField,MODx.combo.ComboBox);
Ext.reg('tagger-combo-sort-field',tagger.combo.SortField);
