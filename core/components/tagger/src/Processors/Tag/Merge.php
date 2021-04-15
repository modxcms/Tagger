<?php

namespace Tagger\Processors\Tag;

use MODX\Revolution\Processors\ModelProcessor;
use Tagger\Model\TaggerTag;
use Tagger\Model\TaggerTagResource;

/**
 * Remove a Tag.
 *
 * @package tagger
 * @subpackage processors
 */
class Merge extends ModelProcessor
{

    public $classKey = TaggerTag::class;

    public $languageTopics = ['tagger:default'];

    public $objectType = 'tagger.tag';

    public $tags;

    public function process()
    {
        $validate = $this->validate();
        if ($validate !== true) {
            return $this->failure($validate);
        }

        $toUpdate = array_shift($this->tags);
        $name = $this->getProperty('name', '');

        foreach ($this->tags as $tag) {
            $tagResources = $this->modx->getCollection(TaggerTagResource::class, ['tag' => $tag]);

            /** @var TaggerTagResource $tagResource */
            foreach ($tagResources as $tagResource) {
                $newRelation = $this->modx->newObject(TaggerTagResource::class);
                $newRelation->set('tag', $toUpdate);
                $newRelation->set('resource', $tagResource->resource);

                $tagResource->remove();
                $newRelation->save();
            }

            $tagObject = $this->modx->getObject($this->classKey, $tag);
            $tagObject->remove();
        }

        /** @var TaggerTag $toUpdate */
        $toUpdate = $this->modx->getObject($this->classKey, $toUpdate);
        $toUpdate->set('tag', $name);
        $toUpdate->save();

        return $this->success();
    }

    public function validate()
    {
        $tags = $this->getProperty('tags', null);
        $tags = \Tagger\Utils::explodeAndClean($tags);

        if (empty($tags)) {
            return $this->modx->lexicon('tagger.err.tags_ns');
        }

        $name = $this->getProperty('name', '');
        if (empty($name)) {
            $this->addFieldError('name', $this->modx->lexicon('tagger.err.tag_name_ns'));
            return false;
        }

        $exists = $this->modx->getCount($this->classKey, ['tag' => $name, 'id:NOT IN' => $tags]);
        if ($exists > 0) {
            $this->addFieldError('name', $this->modx->lexicon('tagger.err.tag_name_ae'));
            return false;
        }

        $this->tags = $tags;

        return true;
    }

}
