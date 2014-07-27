Ext.onReady(function() {
    MODx.load({ xtype: 'tagger-page-home'});
});

Tagger.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'tagger-panel-home'
        }]
    });
    Tagger.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.page.Home,MODx.Component);
Ext.reg('tagger-page-home',Tagger.page.Home);
