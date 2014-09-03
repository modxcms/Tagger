Tagger.combo.Group = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'group'
        ,hiddenName: 'group'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id']
        ,pageSize: 20
        ,url: Tagger.config.connectorUrl
        ,baseParams:{
            action: 'mgr/group/getlist'
        }
    });
    Tagger.combo.Group.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.combo.Group,MODx.combo.ComboBox);
Ext.reg('tagger-combo-group',Tagger.combo.Group);

Tagger.combo.Tag = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'tag'
        ,hiddenName: 'tag'
        ,displayField: 'tag'
        ,valueField: 'id'
        ,fields: ['tag','id']
        ,pageSize: 20
        ,editable: config.allowAdd
        ,forceSelection: !config.allowAdd
        ,url: Tagger.config.connectorUrl
        ,baseParams:{
            action: 'mgr/tag/getlist'
        }
    });
    Tagger.combo.Tag.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.combo.Tag,MODx.combo.ComboBox);
Ext.reg('tagger-combo-tag',Tagger.combo.Tag);

Tagger.combo.FieldType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['d','v']
            ,data: [
                [_('tagger.field.tagfield') ,'tagger-field-tags'],
                [_('tagger.field.combobox') ,'tagger-combo-tag']
            ]
        })
        ,displayField: 'd'
        ,valueField: 'v'
        ,mode: 'local'
        ,value: 'tagger-field-tags'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: false
        ,preventRender: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    Tagger.combo.FieldType.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.combo.FieldType,MODx.combo.ComboBox);
Ext.reg('tagger-combo-field-type',Tagger.combo.FieldType);

Tagger.combo.Templates = function(config, getStore) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'templates'
        ,hiddenName: 'templates'
        ,displayField: 'templatename'
        ,valueField: 'id'
        ,fields: ['templatename','id']
        ,mode: 'remote'
        ,triggerAction: 'all'
        ,typeAhead: true
        ,editable: true
        ,forceSelection: true
        ,pageSize: 20
        ,url: MODx.config.connectors_url + 'element/template.php'
        ,baseParams: {
            action: 'getlist'
        }
    });
    Ext.applyIf(config,{
        store: new Ext.data.JsonStore({
            url: config.url
            ,root: 'results'
            ,totalProperty: 'total'
            ,fields: config.fields
            ,errorReader: MODx.util.JSONReader
            ,baseParams: config.baseParams || {}
            ,remoteSort: config.remoteSort || false
            ,autoDestroy: true
        })
    });
    if (getStore === true) {
        config.store.load();
        return config.store;
    }
    Tagger.combo.Templates.superclass.constructor.call(this,config);
    this.config = config;
    return this;
};
Ext.extend(Tagger.combo.Templates,Ext.ux.form.SuperBoxSelect);
Ext.reg('tagger-combo-templates',Tagger.combo.Templates);

Tagger.combo.TV = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'tv'
        ,hiddenName: 'tv'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id']
        ,pageSize: 20
        ,url: Tagger.config.connectorUrl
        ,baseParams:{
            action: 'mgr/extra/gettvs'
        }
    });
    Tagger.combo.TV.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.combo.TV,MODx.combo.ComboBox);
Ext.reg('tagger-combo-tv',Tagger.combo.TV);

Tagger.combo.GroupPlace = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['d','v']
            ,data: [
                [_('tagger.group.place_in_tab') ,'in-tab'],
                [_('tagger.group.place_tvs_tab') ,'in-tvs'],
                [_('tagger.group.place_above_content') ,'above-content'],
                [_('tagger.group.place_below_content') ,'below-content'],
                [_('tagger.group.place_bottom_page') ,'bottom-page']
            ]
        })
        ,displayField: 'd'
        ,valueField: 'v'
        ,mode: 'local'
        ,value: 'in-tab'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: false
        ,preventRender: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    Tagger.combo.GroupPlace.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.combo.GroupPlace,MODx.combo.ComboBox);
Ext.reg('tagger-combo-group-place',Tagger.combo.GroupPlace);
