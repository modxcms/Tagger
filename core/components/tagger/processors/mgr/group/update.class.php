<?php
/**
 * Update a Group
 * 
 * @package tagger
 * @subpackage processors
 */

class TaggerGroupUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'TaggerGroup';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.group';

    public function beforeSet() {
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.err.group_name_ns'));

        } else if ($this->modx->getCount($this->classKey, array('name' => $name)) && ($this->object->name != $name)) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.err.group_name_ae'));
        }

        $fieldType = $this->getProperty('field_type');

        if ($fieldType != 'tagger-field-tags') {
            $this->setProperty('show_autotag', 0);
        }

        return parent::beforeSet();
    }

}
return 'TaggerGroupUpdateProcessor';