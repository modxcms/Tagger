<?php

namespace Tagger\Processors\Tag;

use MODX\Revolution\Processors\Model\CreateProcessor;
use Tagger\Model\TaggerTag;

/**
 * Create a Tag
 *
 * @package tagger
 * @subpackage processors
 */
class Create extends CreateProcessor
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
            if ($this->doesAlreadyExist(['tag' => $name, 'group' => $group])) {
                $this->addFieldError('tag', $this->modx->lexicon('tagger.err.tag_name_ae'));
            }
        }

        if (!empty($alias)) {
            $alias = $this->object->cleanAlias($alias);
            if ($this->doesAlreadyExist(['alias' => $alias, 'group' => $group])) {
                $this->addFieldError('alias', $this->modx->lexicon('tagger.err.tag_alias_ae'));
            }
        }

        return parent::beforeSave();
    }

}
