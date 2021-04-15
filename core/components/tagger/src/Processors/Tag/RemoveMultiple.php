<?php

namespace Tagger\Processors\Tag;

use MODX\Revolution\Processors\ModelProcessor;
use Tagger\Model\TaggerTag;

/**
 * Remove a Tag.
 *
 * @package tagger
 * @subpackage processors
 */
class RemoveMultiple extends ModelProcessor
{

    public $classKey = TaggerTag::class;

    public $languageTopics = ['tagger:default'];

    public $objectType = 'tagger.tag';

    public function process()
    {
        $tags = $this->getProperty('tags', '');
        $tags = \Tagger\Utils::explodeAndClean($tags);

        if (empty($tags)) {
            return $this->failure($this->modx->lexicon('tagger.err.tags_ns'));
        }

        foreach ($tags as $tag) {
            /** @var TaggerTag $tag */
            $tagObject = $this->modx->getObject($this->classKey, $tag);

            if (empty($tagObject)) {
                continue;
            }

            $tagObject->remove();
        }

        return $this->success();
    }

}
