<?php

namespace Tagger\Processors\Group;

use MODX\Revolution\Processors\Model\RemoveProcessor;
use Tagger\Model\TaggerGroup;

/**
 * Remove a Group.
 *
 * @package tagger
 * @subpackage processors
 */
class Remove extends RemoveProcessor
{

    public $classKey = TaggerGroup::class;

    public $languageTopics = ['tagger:default'];

    public $objectType = 'tagger.group';

}
