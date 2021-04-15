<?php

namespace Tagger\Events;

use Tagger\Model\TaggerGroup;
use Tagger\Model\TaggerTag;
use Tagger\Model\TaggerTagResource;

class OnDocFormSave extends Event
{

    public function run()
    {
        $resource = $this->modx->getOption('resource', $this->scriptProperties, '');

        /** @var TaggerGroup[] $groups */
        $groups = $this->modx->getIterator(TaggerGroup::class);

        foreach ($groups as $group) {
            $showForTemplates = $group->show_for_templates;
            $showForTemplates = \Tagger\Utils::explodeAndClean($showForTemplates);
            $showForTemplates = array_flip($showForTemplates);

            $showForContexts = $group->show_for_contexts;
            $showForContexts = \Tagger\Utils::explodeAndClean($showForContexts);
            $showForContexts = array_flip($showForContexts);

            if (!isset($showForTemplates[$resource->template])) {
                continue;
            }

            if (!empty($showForContexts) && !isset($showForContexts[$resource->context_key])) {
                continue;
            }

            $oldTagsQuery = $this->modx->newQuery(TaggerTagResource::class);
            $oldTagsQuery->leftJoin(TaggerTag::class, 'Tag');
            $oldTagsQuery->where(['resource' => $resource->id, 'Tag.group' => $group->id]);
            $oldTagsQuery->select(
                $this->modx->getSelectColumns(TaggerTagResource::class, 'TaggerTagResource', '', ['tag'])
            );

            $oldTagsQuery->prepare();
            $oldTagsQuery->stmt->execute();
            $oldTags = $oldTagsQuery->stmt->fetchAll(\PDO::FETCH_COLUMN, 0);
            $oldTags = array_flip($oldTags);

            $tags = $resource->get('tagger-' . $group->id);
            if ($tags === null) {
                continue;
            }

            if (isset($tags)) {
                $tags = \Tagger\Utils::explodeAndClean($tags);

                foreach ($tags as $tag) {
                    /** @var TaggerTag $tagObject */
                    $tagObject = $this->modx->getObject(TaggerTag::class, ['tag' => $tag, 'group' => $group->id]);
                    if ($tagObject) {
                        $existsRelation = $this->modx->getObject(
                            TaggerTagResource::class,
                            ['tag' => $tagObject->id, 'resource' => $resource->id]
                        );
                        if ($existsRelation) {
                            if (isset($oldTags[$existsRelation->tag])) {
                                unset($oldTags[$existsRelation->tag]);
                            }

                            continue;
                        }
                    }

                    if (!$tagObject) {
                        if (!$group->allow_new) {
                            continue;
                        }

                        $tagObject = $this->modx->newObject(TaggerTag::class);
                        $tagObject->set('tag', $tag);
                        $tagObject->addOne($group, 'Group');
                        $tagObject->save();
                    }

                    /** @var TaggerTagResource $relationObject */
                    $relationObject = $this->modx->newObject(TaggerTagResource::class);
                    $relationObject->set('tag', $tagObject->id);
                    $relationObject->set('resource', $resource->id);
                    $relationObject->save();
                }
            }

            if (count($oldTags) > 0) {
                $oldTags = array_keys($oldTags);
                $this->modx->removeCollection(
                    TaggerTagResource::class,
                    [
                        'tag:IN' => $oldTags,
                        'AND:resource:=' => $resource->id,
                    ]
                );
            }

            if ($group->remove_unused) {
                $c = $this->modx->newQuery(TaggerTagResource::class);
                $c->select($this->modx->getSelectColumns(TaggerTagResource::class, 'TaggerTagResource', '', ['tag']));
                $c->prepare();
                $c->stmt->execute();
                $IDs = $c->stmt->fetchAll(\PDO::FETCH_COLUMN, 0);

                $IDs = array_keys(array_flip($IDs));

                if (count($IDs) > 0) {
                    $this->modx->removeCollection(TaggerTag::class, ['id:NOT IN' => $IDs, 'group' => $group->id]);
                }
            }
        }
    }

}
