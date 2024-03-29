<?php

namespace Tagger\Processors\Tag;

use MODX\Revolution\Processors\Model\UpdateProcessor;
use Tagger\Model\TaggerTag;

/**
 * Update a Tag
 *
 * @package tagger
 * @subpackage processors
 */
class Update extends UpdateProcessor
{

    public $classKey = TaggerTag::class;

    public $languageTopics = ['tagger:default'];

    public $objectType = 'tagger.tag';

    /** @var TaggerTag $object */
    public $object;

    public function beforeSave()
    {
        $name = $this->getProperty('tag');
        $group = $this->getProperty('group');
        $alias = $this->getProperty('alias');

        if (empty($name) || empty($group)) {
            if (empty($group)) {
                $this->addFieldError('group', $this->modx->lexicon('tagger.err.group_name_ns'));
            }

            if (empty($name)) {
                $this->addFieldError('tag', $this->modx->lexicon('tagger.err.tag_name_ns'));
            }
        } else {
            if ($this->object->group != $group) {
                $this->addFieldError('group', $this->modx->lexicon('tagger.err.tag_group_changed'));
            }

            if ($this->modx->getCount(
                    $this->classKey,
                    ['tag' => $name, 'group' => $group, 'id:!=' => $this->object->id]
                ) > 0
            ) {
                $this->addFieldError('tag', $this->modx->lexicon('tagger.err.tag_name_ae'));
            }
        }

        if (!empty($alias)) {
            $alias = $this->object->cleanAlias($alias);
            if ($this->modx->getCount(
                    $this->classKey,
                    ['alias' => $alias, 'group' => $group, 'id:!=' => $this->object->id]
                ) > 0
            ) {
                $this->addFieldError('alias', $this->modx->lexicon('tagger.err.tag_alias_ae'));
            } else {
                $this->object->set('alias', $alias);
            }
        }

        return parent::beforeSave();
    }

}
