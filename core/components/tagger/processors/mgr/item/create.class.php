<?php
/**
 * Create an Item
 * 
 * @package tagger
 * @subpackage processors
 */
class TaggerItemCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'TaggerItem';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.item';

    public function beforeSet(){
        $items = $this->modx->getCollection($this->classKey);

        $this->setProperty('position', count($items));

        return parent::beforeSet();
    }

    public function beforeSave() {
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.item_err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.item_err_ae'));
        }
        return parent::beforeSave();
    }
}
return 'TaggerItemCreateProcessor';
