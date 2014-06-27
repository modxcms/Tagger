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
    /** @var TaggerGroup $object */
    public $object;

    public function beforeSave() {
        $name = $this->getProperty('name');
        $alias = $this->getProperty('alias');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.err.group_name_ns'));

        } else if ($this->modx->getCount($this->classKey, array('name' => $name)) && ($this->object->name != $name)) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.err.group_name_ae'));
        }

        $fieldType = $this->getProperty('field_type');
        $showAutotag = (int) $this->getProperty('show_autotag', 0);

        if ($fieldType != 'tagger-field-tags') {
            $this->object->set('show_autotag', 0);
        }

        if ($showAutotag != 1) {
            $this->object->set('hide_input', 0);
        }

        if (!empty($alias)) {
            $alias = $this->object->cleanAlias($alias);
            if ($this->modx->getCount($this->classKey, array('alias' => $alias, 'id:!=' => $this->object->id)) > 0) {
                $this->addFieldError('alias',$this->modx->lexicon('tagger.err.group_alias_ae'));
            } else {
                $this->object->set('alias', $alias);
            }
        }

        return parent::beforeSave();
    }

}
return 'TaggerGroupUpdateProcessor';