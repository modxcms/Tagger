<?php
/**
 * Create a Group
 * 
 * @package tagger
 * @subpackage processors
 */
class TaggerGroupCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'TaggerGroup';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.group';
    /** @var TaggerGroup $object */
    public $object;

    public function beforeSet() {
        $fieldType = $this->getProperty('field_type');
        $showAutotag = (int) $this->getProperty('show_autotag', 0);

        if ($fieldType != 'tagger-field-tags') {
            $this->setProperty('show_autotag', 0);
        }

        if ($showAutotag != 1) {
            $this->setProperty('hide_input', 0);
        }

        $c = $this->modx->newQuery('TaggerGroup');
        $c->sortby('position', 'DESC');
        $c->limit(1);

        /** @var TaggerGroup $group */
        $group = $this->modx->getObject('TaggerGroup', $c);

        if ($group) {
            $this->setProperty('position', $group->position + 1);
        } else {
            $this->setProperty('position', 0);
        }

        return parent::beforeSet();
    }

    public function beforeSave() {
        $name = $this->getProperty('name');
        $alias = $this->getProperty('alias');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.err.group_name_ns'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('tagger.err.group_name_ae'));
        }

        if (!empty($alias)) {
            $alias = $this->object->cleanAlias($alias);
            if ($this->doesAlreadyExist(array('alias' => $alias))) {
                $this->addFieldError('alias',$this->modx->lexicon('tagger.err.group_alias_ae'));
            }
        }

        return parent::beforeSave();
    }
}
return 'TaggerGroupCreateProcessor';
