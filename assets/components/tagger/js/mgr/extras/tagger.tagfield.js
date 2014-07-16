Tagger.fields.Tags = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        ignoreCase: false
        ,valueField: 'tag'
        ,displayField: 'tag'
        ,minChars: 1
        ,allowAdd: true
        ,editable: true
        ,hideTrigger: false
        ,autoTag: false
        ,hideInput: false
        ,tagLimit: 0
    });
    Tagger.fields.Tags.superclass.constructor.call(this,config);

    this.myStore = new Ext.data.ArrayStore({
        autoDestroy: true,
        idIndex: 0,
        fields: ['tag'],
        data: []
    });

    if (this.config.autoTag == true) {
        this.autoTagStore = new Ext.data.ArrayStore({
            autoDestroy: true,
            idIndex: 0,
            fields: ['tag', 'active', 'el'],
            data: []
        });
    }

    this.store.loaded = false;
    this.store.on('load', function() {
        this.store.loaded = true;
    }, this);

    this.config = config;

    this.addEvents('additem', 'removeitem');
};
Ext.extend(Tagger.fields.Tags,MODx.combo.ComboBox,{
    mode: 'remote'

    ,defaultAutoCreate : {tag: "input", type: "text", size: "24", autocomplete: "on"}

    ,myStore: null

    ,autoTagStore: null

    ,store: null

    ,initValue : function(){
        if(this.value !== undefined){
            this.setValue(this.value);
        }else if(!Ext.isEmpty(this.el.dom.value) && this.el.dom.value != this.emptyText){
            this.setValue(this.el.dom.value);
        }

        this.originalValue = this.getFieldValue();

        if (this.config.autoTag) {
            this.store.baseParams[this.store.paramNames.start] = 0;
            this.store.baseParams[this.store.paramNames.limit] = 0;
            this.store.load();
            this.store.on('load', this.loadAutoTags, this, {single: true});
        }
    }

    ,loadAutoTags: function() {
        Ext.each(this.store.data.items, function(item) {
            new Tagger.fields.Tag({
                owner: this,
                renderTo: this.insertedTagsEl,
                value: item.data.tag,
                active: false,
                listeners: {
                    remove: function(item){
                        this.fireEvent('removeitem',this,item);
                    },scope: this
                }
            });
        }, this);
    }

    ,onFocus : function(){
        this.preFocus();
        if(this.focusClass){
            this.el.addClass(this.focusClass);
        }
        if(!this.hasFocus){
            this.hasFocus = true;
            /**
             * <p>The value that the Field had at the time it was last focused. This is the value that is passed
             * to the {@link #change} event which is fired if the value has been changed when the Field is blurred.</p>
             * <p><b>This will be undefined until the Field has been visited.</b> Compare {@link #originalValue}.</p>
             * @type mixed
             * @property startValue
             */
            this.startValue = this.getFieldValue();
            this.fireEvent('focus', this);
        }
    }

    ,isDirty : function() {
        if(this.disabled || !this.rendered) {
            return false;
        }
        return String(this.getFieldValue()) !== String(this.originalValue);
    }

    ,append : function(v){
        this.setValue([this.getFieldValue(), v].join(''));
    }

    ,getValue: function(){
        var restValues = this.getFieldValue();
        if(restValues == '' || restValues == undefined) restValues = '';

        restValues = restValues.split(/\s*[,]\s*/);

        Ext.each(restValues, function(value){
            var record = new Ext.data.Record({tag: value}, value);
            this.myStore.add([record]);
        }, this);

        return this.myStore.collect('tag').join();
    }

    ,setValue: function(v){
        if (this.store.loaded == false && this.config.autoTag == true) {
            this.store.on('load', this.setValueOnLoad.createDelegate(this, [v], false), this, {single: true});
            return;
        }

        if (this.config.autoTag == false) {
            while(this.insertedTagsEl.dom.firstChild != null){
                this.insertedTagsEl.dom.firstChild.remove();
            }
        }

        this.myStore.clearData();

        if(v instanceof Array){
            v = v.join();
        }

        this.addItems(v);
    }

    ,setValueOnLoad: function(v){
        if (this.config.autoTag == false) {
            while(this.insertedTagsEl.dom.firstChild != null){
                this.insertedTagsEl.dom.firstChild.remove();
            }
        }

        this.myStore.clearData();
        if(v instanceof Array){
            v = v.join();
        }
        this.addItems(v);
    }

    ,setFieldValue : function(v){
        var text = v;
        if(this.valueField){
            var r = this.findRecord(this.valueField, v);
            if(r){
                text = r.data[this.displayField];
            }else if(Ext.isDefined(this.valueNotFoundText)){
                text = this.valueNotFoundText;
            }
        }
        this.lastSelectionText = text;
        if(this.hiddenField){
            this.hiddenField.value = Ext.value(v, this.myStore.collect('tag').join());
        }
        Ext.form.ComboBox.superclass.setValue.call(this, text);
        this.value = v;
        return this;
    }

    ,getFieldValue: function(){
        return this.value;
    }

    ,onRender : function(ct, position){
        if(this.hiddenName && !Ext.isDefined(this.submitValue)){
            this.submitValue = false;
        }
        Ext.form.ComboBox.superclass.onRender.call(this, ct, position);

        this.el.parent().wrap({
            tag: 'div'
            ,class: 'tagger-field-tags'
        });

        this.el.parent().wrap({
            tag: 'div'
            ,class: 'tagger-field-wrapper' + (this.hideInput ? ' tagger-wrapper-hidden' : '')
        });

        this.el.parentNode = this.el.parent().parent().parent();

        Ext.DomHelper.insertAfter(this.el.parent().parent(), {tag: 'ul'});
        Ext.DomHelper.insertAfter(this.el.parent(), {tag: 'button', html: _('tagger.tag.assign'), class: 'x-btn'});

        this.addButton = this.el.parentNode.child('button');
        this.insertedTagsEl = this.el.parentNode.child('ul');

        this.insertedTagsEl.wrap({tag: 'div', class: 'inserted-tags modx-tag-list x-superboxselect'});

        this.addButton.on('click', this.addItemsFromField, this);
        new Ext.KeyMap(this.getEl(), {
            key: Ext.EventObject.ENTER
            ,fn: function() {
                if (this.isExpanded() == false) {
                    this.addItemsFromField();
                }
                return true;
            }
            ,scope: this
        });


        if(this.hiddenName){
            this.hiddenField = this.el.insertSibling({tag:'input', type:'hidden', name: this.hiddenName,
                id: (this.hiddenId || Ext.id())}, 'before', true);

        }
        if(Ext.isGecko){
            this.el.dom.setAttribute('autocomplete', 'off');
        }

        if(!this.lazyInit){
            this.initList();
        }else{
            this.on('focus', this.initList, this, {single: true});
        }
    }

    ,addItemsFromField: function(){
        this.addItems(this.getFieldValue());
    }

    ,addItems: function(items){
        items = Ext.isEmpty(items) ? '' : items;
        var values = items.split(/\s*[,]\s*/);

        Ext.each(values, function (value) {
            if(this.ignoreCase){
                value = value.toLowerCase();
            }

            if(value == ''){
                return;
            }

            if (this.config.allowAdd == false) {
                this.store.clearFilter();
                if (this.store.getCount() > 0 && this.store.find('tag', value) == -1) {
                    return;
                }
            }

            if (this.config.tagLimit > 0) {
                if (this.myStore.find('tag', value) == -1) {
                    if (this.myStore.getCount() >= this.config.tagLimit) {
                        return;
                    }
                }
            }

            var valueIndex = -1;
            if (this.config.autoTag == true) {
                valueIndex = this.autoTagStore.find('tag', value);
                if (valueIndex != -1) {
                    var rec = this.autoTagStore.getAt(valueIndex);
                    if (rec.data.el.el && !rec.data.el.el.hasClass('x-superboxselect-item')) {
                        rec.data.el.click();
                    } else {
                        if (this.myStore.find('tag', value) == -1) {
                            var record = new Ext.data.Record({tag: value}, value);
                            this.myStore.add([record]);
                        }
                    }
                }
            }

            if (this.config.autoTag == false || valueIndex == -1) {
                var item = new Tagger.fields.Tag({
                    owner: this,
                    renderTo: this.insertedTagsEl,
                    value: value,
                    active: true,
                    listeners: {
                        remove: function(item){
                            this.fireEvent('removeitem',this,item);
                        },scope: this
                    }
                });
                item.render();
                this.fireEvent('additem',this,value);
            }
        }, this);


        this.setFieldValue();
    }

    ,doQuery : function(q, forceAll){
        this.value = q;

        q = Ext.isEmpty(q) ? '' : q;
        q = q.split(',');
        q = q[q.length - 1];
        q = q.replace(/^\s+|\s+$/g, '');

        var qe = {
            query: q,
            forceAll: forceAll,
            combo: this,
            cancel:false
        };
        if(this.fireEvent('beforequery', qe)===false || qe.cancel){
            return false;
        }
        q = qe.query;

        forceAll = qe.forceAll;
        if(forceAll === true || (q.length >= this.minChars)){
            if(this.lastQuery !== q){
                this.lastQuery = q;
                if(this.mode == 'local'){
                    this.selectedIndex = -1;
                    if(forceAll){
                        this.store.clearFilter();
                    }else{
                        this.store.filter(this.displayField, q, true);
                    }
                    this.onLoad();
                }else{
                    this.store.baseParams[this.queryParam] = q;
                    this.store.load({
                        params: this.getParams(q)
                    });
                    this.expand();
                }
            }else{
                this.selectedIndex = -1;
                this.onLoad();
            }
        }
    }

    ,onSelect : function(record, index){
        if(this.fireEvent('beforeselect', this, record, index) !== false){

            var values = this.getFieldValue().split(/\s*[,]\s*/);
            values.pop();
            values.push(record.data[this.valueField || this.displayField]);
            values.push('');
            this.setFieldValue(values.join(', '));
//            this.collapse();
            this.fireEvent('select', this, record, index);
        }
    }

    ,getErrors: function(value) {
        var errors = Ext.form.TextField.superclass.getErrors.apply(this, arguments);

        value = Ext.isDefined(value) ? value : this.processValue(this.getRawValue());

        if (Ext.isFunction(this.validator)) {
            var msg = this.validator(value);
            if (msg !== true) {
                errors.push(msg);
            }
        }

        if (this.myStore.collect('tag').join() == '') {
            if (this.allowBlank) {
                //if value is blank and allowBlank is true, there cannot be any additional errors
                return errors;
            } else {
                errors.push(this.blankText);
            }
        }

        if (!this.allowBlank && (this.myStore.collect('tag').join() == '')) { // if it's blank
            errors.push(this.blankText);
        }

        if (value.length < this.minLength) {
            errors.push(String.format(this.minLengthText, this.minLength));
        }

        if (value.length > this.maxLength) {
            errors.push(String.format(this.maxLengthText, this.maxLength));
        }

        if (this.vtype) {
            var vt = Ext.form.VTypes;
            if(!vt[this.vtype](value, this)){
                errors.push(this.vtypeText || vt[this.vtype +'Text']);
            }
        }

        if (this.regex && !this.regex.test(value)) {
            errors.push(this.regexText);
        }

        return errors;
    }
});

Tagger.fields.Tag = function(config){
    Ext.apply(this,config);
    Ext.ux.form.SuperBoxSelectItem.superclass.constructor.call(this);
    this.addEvents('remove');
};
Ext.extend(Tagger.fields.Tag,Ext.Component, {
    renderCurrentItem: true
    ,initComponent : function(){
        Tagger.fields.Tag.superclass.initComponent.call(this);
        this.renderCurrentItem = true;

        var itemsCount,record;

        if (this.owner.config.autoTag == false) {
            itemsCount = this.owner.myStore.getCount();
            record = new Ext.data.Record({tag: this.value}, this.value);
            this.owner.myStore.add([record]);

            if(itemsCount == this.owner.myStore.getCount()) this.renderCurrentItem = false;
        } else {
            itemsCount = this.owner.autoTagStore.getCount();

            record = new Ext.data.Record({tag: this.value, active: this.active, el: this}, this.value);
            this.owner.autoTagStore.add([record]);

            if(itemsCount == this.owner.autoTagStore.getCount()) this.renderCurrentItem = false;
        }
    },

    click: function() {
        if (this.el.hasClass('x-superboxselect-item')) {
//            var record = new Ext.data.Record({tag: this.value}, this.value);
            this.el.removeClass('x-superboxselect-item');
            this.el.removeClass('modx-tag-checked');
            this.owner.myStore.remove(this.owner.myStore.getById(this.value));
            if(this.owner.hiddenField){
                this.owner.hiddenField.value = this.owner.myStore.collect('tag').join();
            }

            this.fireEvent('remove',this,this.value);
        } else {
            if (this.owner.config.tagLimit > 0) {
                if (this.owner.myStore.find('tag', this.value) == -1) {
                    if (this.owner.myStore.getCount() >= this.owner.config.tagLimit) {
                        return;
                    }
                }
            }
            var record = new Ext.data.Record({tag: this.value}, this.value);
            this.owner.myStore.add([record]);

            this.el.addClass('x-superboxselect-item');
            this.el.addClass('modx-tag-checked');
        }
    },

    onRender : function(ct, position){
        if(!this.renderCurrentItem) return true;
        Tagger.fields.Tag.superclass.onRender.call(this, ct, position);

        var el = this.el;
        if(el){
            el.remove();
        }

        this.el = el = ct.createChild({ tag: 'li' }, ct.last());

        if (this.owner.config.autoTag == true) {
            el.on('click', this.click, this);
        }

        if (this.active == true) {
            this.el.dom.click();
        }

        var btnEl = this.owner.navigateItemsWithTab ? ( Ext.isSafari ? 'button' : 'a') : 'span';

        Ext.apply(el, {
            focus: function(){
                var c = this.down(btnEl +'.x-superboxselect-item-close');
                if(c){
                    c.focus();
                }
            },
            preDestroy: function(){
                this.preDestroy();
            }.createDelegate(this)
        });

        el.update(this.value);

        if (this.owner.config.autoTag == false) {
            el.addClass('x-superboxselect-item');

            var cfg = {
                tag: btnEl,
                'class': 'x-superboxselect-item-close',
                tabIndex : this.owner.navigateItemsWithTab ? '0' : '-1'
            };
            if(btnEl === 'a'){
                cfg.href = '#';
            }

            this.lnk = el.createChild(cfg);
            this.lnk.on('click', function(){
                var record = new Ext.data.Record({tag: this.value}, this.value);
                this.el.remove();
                this.owner.myStore.remove(this.owner.myStore.getById(this.value));
                if(this.owner.hiddenField){
                    this.owner.hiddenField.value = this.owner.myStore.collect('tag').join();
                }

                this.fireEvent('remove',this,this.value);
            }, this);
        } else {
            el.addClass('tagger-autotag-item');
            el.addClass('modx-tag-opt');
        }

        return true;
    },
    onDestroy : function() {
        Ext.destroy(
            this.lnk,
            this.el
        );

        Tagger.fields.Tag.superclass.onDestroy.call(this);
    }
});

Ext.reg('tagger-field-tags',Tagger.fields.Tags);
