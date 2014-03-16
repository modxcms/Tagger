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