tagger.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [
            {
                xtype: 'tagger-panel-home',
                renderTo: 'tagger-panel-home'
            }
        ]
    });
    tagger.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(tagger.page.Home, MODx.Component);
Ext.reg('tagger-page-home', tagger.page.Home);
