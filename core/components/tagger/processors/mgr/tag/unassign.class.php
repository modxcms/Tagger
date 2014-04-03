<?php
/**
 * Remove a Tag.
 * 
 * @package tagger
 * @subpackage processors
 */
class TaggerUnassignResourceRemoveProcessor extends modProcessor {
    public $classKey = 'TaggerTagResource';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.tagresource';

    public function process() {
        $tag = $this->getProperty('tag');
        $resource = $this->getProperty('resource');

        $resource = $this->modx->tagger->explodeAndClean($resource);

        if (empty($tag) || empty($resource)) return $this->modx->lexicon($this->objectType.'_err_ns');

        $this->modx->removeCollection($this->classKey, array('tag' => $tag, 'resource:IN' => $resource));

        return $this->success();
    }

}
return 'TaggerUnassignResourceRemoveProcessor';