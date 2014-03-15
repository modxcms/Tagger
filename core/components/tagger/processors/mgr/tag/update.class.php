<?php
/**
 * Update a Tag
 * 
 * @package tagger
 * @subpackage processors
 */

class TaggerTagUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'TaggerTag';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.tag';

    public function beforeSet() {
        $name = $this->getProperty('name');
        $group = $this->getProperty('group');

        if (empty($name) || empty($group)) {
            if (empty($group)) {
                $this->addFieldError('group',$this->modx->lexicon('tagger.err.group_name_ns'));
            }

            if (empty($name)) {
                $this->addFieldError('name',$this->modx->lexicon('tagger.err.tag_name_ns'));
            }
        } else {
            if ($this->object->group != $group) {
                $this->addFieldError('group',$this->modx->lexicon('tagger.err.tag_group_changed'));
            }

            if ($this->modx->getCount($this->classKey, array('name' => $name, 'group' => $group)) && ($this->object->name != $name)) {
                $this->addFieldError('name',$this->modx->lexicon('tagger.err.tag_name_ae'));
            }
        }

        return parent::beforeSet();
    }

}
return 'TaggerTagUpdateProcessor';