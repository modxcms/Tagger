<?php

namespace Tagger\Processors\Tag;

use MODX\Revolution\Processors\Model\RemoveProcessor;
use Tagger\Model\TaggerTag;

/**
 * Remove a Tag.
 *
 * @package tagger
 * @subpackage processors
 */
class Remove extends RemoveProcessor
{

    public $classKey = TaggerTag::class;

    public $languageTopics = ['tagger:default'];

    public $objectType = 'tagger.tag';

}
