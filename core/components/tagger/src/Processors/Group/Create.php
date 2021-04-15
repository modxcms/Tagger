<?php

namespace Tagger\Processors\Group;

use MODX\Revolution\Processors\Model\CreateProcessor;
use Tagger\Model\TaggerGroup;

/**
 * Create a Group
 *
 * @package tagger
 * @subpackage processors
 */
class Create extends CreateProcessor
{

    public $classKey = TaggerGroup::class;

    public $languageTopics = ['tagger:default'];

    public $objectType = 'tagger.group';

    /** @var TaggerGroup $object */
    public $object;

    public function beforeSet()
    {
        $fieldType = $this->getProperty('field_type');
        $showAutotag = (int)$this->getProperty('show_autotag', 0);

        if ($fieldType != 'tagger-field-tags') {
            $this->setProperty('show_autotag', 0);
        }

        if ($showAutotag != 1) {
            $this->setProperty('hide_input', 0);
        }

        $c = $this->modx->newQuery(TaggerGroup::class);
        $c->sortby('position', 'DESC');
        $c->limit(1);

        /** @var TaggerGroup $group */
        $group = $this->modx->getObject(TaggerGroup::class, $c);

        if ($group) {
            $this->setProperty('position', $group->position + 1);
        } else {
            $this->setProperty('position', 0);
        }

        return parent::beforeSet();
    }

    public function beforeSave()
    {
        $name = $this->getProperty('name');
        $alias = $this->getProperty('alias');

        if (empty($name)) {
            $this->addFieldError('name', $this->modx->lexicon('tagger.err.group_name_ns'));
        } else {
            if ($this->doesAlreadyExist(['name' => $name])) {
                $this->addFieldError('name', $this->modx->lexicon('tagger.err.group_name_ae'));
            }
        }

        if (!empty($alias)) {
            $alias = $this->object->cleanAlias($alias);
            if ($this->doesAlreadyExist(['alias' => $alias])) {
                $this->addFieldError('alias', $this->modx->lexicon('tagger.err.group_alias_ae'));
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
