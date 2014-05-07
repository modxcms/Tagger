<?php
/**
 * Remove a Tag.
 * 
 * @package tagger
 * @subpackage processors
 */
class TaggerTagRemoveMultipleProcessor extends modObjectProcessor {
    public $classKey = 'TaggerTag';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.tag';

    public function process() {
        $tags = $this->getProperty('tags',null);

        if (empty($tags)) {
            return $this->failure($this->modx->lexicon('tagger.err.tags_ns'));
        }

        foreach ($tags as $tag) {
            /** @var TaggerTag $tag*/
            $tagObject = $this->modx->getObject($this->classKey, $tag);

            if (empty($tagObject)) {
                continue;
            }

            $tagObject->remove();
        }

        return $this->success();
    }
}
return 'TaggerTagRemoveMultipleProcessor';