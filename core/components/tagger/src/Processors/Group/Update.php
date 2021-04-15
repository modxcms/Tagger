<?php

namespace Tagger\Processors\Group;

use MODX\Revolution\Processors\Model\UpdateProcessor;
use Tagger\Model\TaggerGroup;

/**
 * Update a Group
 *
 * @package tagger
 * @subpackage processors
 */
class Update extends UpdateProcessor
{

    public $classKey = TaggerGroup::class;

    public $languageTopics = ['tagger:default'];

    public $objectType = 'tagger.group';

    /** @var TaggerGroup $object */
    public $object;

    public function beforeSave()
    {
        $name = $this->getProperty('name');
        $alias = $this->getProperty('alias');

        if (empty($name)) {
            $this->addFieldError('name', $this->modx->lexicon('tagger.err.group_name_ns'));
        } else {
            if ($this->modx->getCount($this->classKey, ['name' => $name]) && ($this->object->name != $name)) {
                $this->addFieldError('name', $this->modx->lexicon('tagger.err.group_name_ae'));
            }
        }

        $fieldType = $this->getProperty('field_type');
        $showAutotag = (int)$this->getProperty('show_autotag', 0);

        if ($fieldType != 'tagger-field-tags') {
            $this->object->set('show_autotag', 0);
        }

        if ($showAutotag != 1) {
            $this->object->set('hide_input', 0);
        }

        if (!empty($alias)) {
            $alias = $this->object->cleanAlias($alias);
            if ($this->modx->getCount($this->classKey, ['alias' => $alias, 'id:!=' => $this->object->id]) > 0) {
                $this->addFieldError('alias', $this->modx->lexicon('tagger.err.group_alias_ae'));
            } else {
                $this->object->set('alias', $alias);
            }
        }

        if (!(($this->object->show_autotag == 1) && ($this->object->hide_input == 1)
            && ($this->object->tag_limit == 1))
        ) {
            $this->object->set('as_radio', 0);
        }

        return parent::beforeSave();
    }

}
