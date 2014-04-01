<?php
/**
 * Import tags from TV
 * 
 * @package tagger
 * @subpackage processors
 */
class TaggerImportProcessor extends modProcessor {

    private $tags = [];
    private $resources = [];
    private $tv;
    private $group;

    public function process() {
        $requiredOK = $this->checkRequired();
        if ($requiredOK !== true) {
            return $this->failure($requiredOK);
        }

        $this->loadTags();
        $this->processTags();
        $this->saveTags();
        $this->assignTagsToResources();


        return $this->success();
    }

    public function checkRequired() {
        $this->tv = $this->getProperty('tv');
        $this->group = $this->getProperty('group');

        if (empty($this->tv)) {
            $this->addFieldError('tv', $this->modx->lexicon('tagger.err.import_tv_ns'));
        }

        if (empty($this->group)) {
            $this->addFieldError('group', $this->modx->lexicon('tagger.err.import_group_ns'));
        }

        return !$this->hasErrors();
    }

    public function loadTags() {
        $c = $this->modx->newQuery('modTemplateVarResource');
        $c->where([
            'tmplvarid' => $this->tv
        ]);

        $c->prepare();
        $c->stmt->execute();

        while ($row = $c->stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->tags[] = $row['modTemplateVarResource_value'];
            $this->resources[$row['modTemplateVarResource_contentid']] = $this->modx->tagger->explodeAndClean($row['modTemplateVarResource_value'], '||');
        }
    }

    public function processTags() {
        $this->tags = implode('||', $this->tags);
        $this->tags = $this->modx->tagger->explodeAndClean($this->tags, '||');
    }

    public function saveTags() {
        $tags = $this->tags;
        $this->tags = [];

        foreach ($tags as $tag) {
            /** @var TaggerTag $tagObject */
            $tagObject = $this->modx->getObject('TaggerTag', [
                'tag' => $tag,
                'group' => $this->group
            ]);

            if (!$tagObject) {
                $tagObject = $this->modx->newObject('TaggerTag');
                $tagObject->set('tag', $tag);
                $tagObject->set('group', $this->group);
                $tagObject->save();
            }

            $this->tags[$tag] = $tagObject->id;
        }
    }

    public function assignTagsToResources() {
        foreach ($this->resources as $resource => $tags) {
            foreach ($tags as $tag) {
                $relationExists = $this->modx->getObject('TaggerTagResource', ['tag' => (int)$this->tags[$tag], 'resource' => $resource]);
                if ($relationExists) {
                    continue;
                }

                $tagResource = $this->modx->newObject('TaggerTagResource');
                $tagResource->set('tag', (int)$this->tags[$tag]);
                $tagResource->set('resource', $resource);
                $tagResource->save();
            }
        }
    }
}

return 'TaggerImportProcessor';
