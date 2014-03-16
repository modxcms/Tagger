var Tagger = function(config) {
    config = config || {};
Tagger.superclass.constructor.call(this,config);
};
Ext.extend(Tagger,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}, fields: {}
});
Ext.reg('tagger',Tagger);
Tagger = new Tagger();