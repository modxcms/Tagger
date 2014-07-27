Tagger.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('tagger')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: {
                border: false
                ,autoHeight: true
                ,layout: 'anchor'
            }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('tagger.tag.tags')
                ,items: [{
                    html: '<p>'+_('tagger.tag.intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'tagger-grid-tag'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                    ,anchor: '100%'
                }]
            },{
                title: _('tagger.group.groups')
                ,items: [{
                    html: '<p>'+_('tagger.group.intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'tagger-grid-group'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                    ,anchor: '100%'
                }]
            }]
        }]
    });
    Tagger.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Tagger.panel.Home,MODx.Panel);
Ext.reg('tagger-panel-home',Tagger.panel.Home);
