<?php

namespace Tagger\Processors\Group;

use MODX\Revolution\modTemplateVar;
use MODX\Revolution\modTemplateVarResource;
use MODX\Revolution\Processors\Processor;
use Tagger\Model\TaggerTag;
use Tagger\Model\TaggerTagResource;

/**
 * Import tags from TV
 *
 * @package tagger
 * @subpackage processors
 */
class Import extends Processor
{

    private $tags = [];

    private $resources = [];

    private $tv;

    private $group;

    private $supportedTypes = [];

    private $separator;

    public function process()
    {
        $this->setSupportedTypes();

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

    public function setSupportedTypes()
    {
        $this->supportedTypes = [
            'listbox-multiple' => '||',
            'autotag'          => ',',
        ];
    }

    public function checkRequired()
    {
        $this->tv = $this->getProperty('tv');
        $this->group = $this->getProperty('group');

        if (empty($this->tv)) {
            $this->addFieldError('tv', $this->modx->lexicon('tagger.err.import_tv_ns'));
        }

        if (empty($this->group)) {
            $this->addFieldError('group', $this->modx->lexicon('tagger.err.import_group_ns'));
        }

        /** @var modTemplateVar $tv */
        $tv = $this->modx->getObject(modTemplateVar::class, $this->tv);
        if ($tv) {
            if (isset($this->supportedTypes[$tv->type])) {
                $this->separator = $this->supportedTypes[$tv->type];
            } else {
                $this->addFieldError(
                    'tv',
                    $this->modx->lexicon(
                        'tagger.err.import_tv_nsp',
                        ['supported' => implode(', ', array_keys($this->supportedTypes))]
                    )
                );
            }
        } else {
            $this->addFieldError('tv', $this->modx->lexicon('tagger.err.import_tv_ne'));
        }

        return !$this->hasErrors();
    }

    public function loadTags()
    {
        $c = $this->modx->newQuery(modTemplateVarResource::class);
        $c->where(
            [
                'tmplvarid' => $this->tv,
            ]
        );

        $c->prepare();
        $c->stmt->execute();

        while ($row = $c->stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->tags[] = $row['modTemplateVarResource_value'];
            $this->resources[$row['modTemplateVarResource_contentid']] = \Tagger\Utils::explodeAndClean(
                $row['modTemplateVarResource_value'],
                $this->separator
            );
        }
    }

    public function processTags()
    {
        $this->tags = implode($this->separator, $this->tags);
        $this->tags = \Tagger\Utils::explodeAndClean($this->tags, $this->separator);
    }

    public function saveTags()
    {
        $tags = $this->tags;
        $this->tags = [];

        foreach ($tags as $tag) {
            /** @var TaggerTag $tagObject */
            $tagObject = $this->modx->getObject(
                TaggerTag::class,
                [
                    'tag' => $tag,
                    'group' => $this->group,
                ]
            );

            if (!$tagObject) {
                $tagObject = $this->modx->newObject(TaggerTag::class);
                $tagObject->set('tag', $tag);
                $tagObject->set('group', $this->group);
                $tagObject->save();
            }

            $this->tags[$tag] = $tagObject->id;
        }
    }

    public function assignTagsToResources()
    {
        foreach ($this->resources as $resource => $tags) {
            foreach ($tags as $tag) {
                $relationExists = $this->modx->getObject(
                    TaggerTagResource::class,
                    ['tag' => (int)$this->tags[$tag], 'resource' => $resource]
                );
                if ($relationExists) {
                    continue;
                }

                $tagResource = $this->modx->newObject(TaggerTagResource::class);
                $tagResource->set('tag', (int)$this->tags[$tag]);
                $tagResource->set('resource', $resource);
                $tagResource->save();
            }
        }
    }

}
