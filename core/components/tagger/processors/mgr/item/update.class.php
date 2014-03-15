<?php
/**
 * Update an Item
 * 
 * @package tagger
 * @subpackage processors
 */

class TaggerItemUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'BxrExtraItem';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.item';

    public function beforeSet() {
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.item_err_ns_name'));

        } else if ($this->modx->getCount($this->classKey, array('name' => $name)) && ($this->object->name != $name)) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.item_err_ae'));
        }
        return parent::beforeSet();
    }

}
return 'TaggerItemUpdateProcessor';