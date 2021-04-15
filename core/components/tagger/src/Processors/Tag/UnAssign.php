<?php

namespace Tagger\Processors\Tag;

use MODX\Revolution\Processors\Processor;
use Tagger\Model\TaggerTagResource;

/**
 * Remove a Tag.
 *
 * @package tagger
 * @subpackage processors
 */
class UnAssign extends Processor
{

    public $classKey = TaggerTagResource::class;

    public $languageTopics = ['tagger:default'];

    public $objectType = 'tagger.tagresource';

    public function process()
    {
        $tag = $this->getProperty('tag');
        $resource = $this->getProperty('resource');

        $resource = \Tagger\Utils::explodeAndClean($resource);

        if (empty($tag) || empty($resource)) {
            return $this->modx->lexicon($this->objectType . '_err_ns');
        }

        $this->modx->removeCollection($this->classKey, ['tag' => $tag, 'resource:IN' => $resource]);

        return $this->success();
    }

}
