<?php
class TaggerOnDocFormSave extends TaggerPlugin
{
    public function run()
    {
        $resource = $this->modx->getOption('resource', $this->scriptProperties, '');

        /** @var TaggerGroup[] $groups */
        $groups = $this->modx->getIterator('TaggerGroup');

        foreach ($groups as $group) {
            $showForTemplates = $group->show_for_templates;
            $showForTemplates = $this->tagger->explodeAndClean($showForTemplates);
            $showForTemplates = array_flip($showForTemplates);

            if (!isset($showForTemplates[$resource->template])) {
                continue;
            }

            $oldTagsQuery = $this->modx->newQuery('TaggerTagResource');
            $oldTagsQuery->leftJoin('TaggerTag', 'Tag');
            $oldTagsQuery->where(array('resource' => $resource->id, 'Tag.group' => $group->id));
            $oldTagsQuery->select($this->modx->getSelectColumns('TaggerTagResource', 'TaggerTagResource', '', array('tag')));

            $oldTagsQuery->prepare();
            $oldTagsQuery->stmt->execute();
            $oldTags = $oldTagsQuery->stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $oldTags = array_flip($oldTags);

            $tags = $resource->get('tagger-' . $group->id);
            if ($tags === null) {
                continue;
            }

            if (isset($tags)) {
                $tags = $this->tagger->explodeAndClean($tags);

                foreach ($tags as $tag) {
                    /** @var TaggerTag $tagObject */
                    $tagObject = $this->modx->getObject('TaggerTag', array('tag' => $tag, 'group' => $group->id));
                    if ($tagObject) {
                        $existsRelation = $this->modx->getObject('TaggerTagResource', array('tag' => $tagObject->id, 'resource' => $resource->id));
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

                        $tagObject = $this->modx->newObject('TaggerTag');
                        $tagObject->set('tag', $tag);
                        $tagObject->addOne($group, 'Group');
                        $tagObject->save();
                    }

                    /** @var TaggerTagResource $relationObject */
                    $relationObject = $this->modx->newObject('TaggerTagResource');
                    $relationObject->set('tag', $tagObject->id);
                    $relationObject->set('resource', $resource->id);
                    $relationObject->save();
                }
            }

            if (count($oldTags) > 0) {
                $oldTags = array_keys($oldTags);
                $this->modx->removeCollection('TaggerTagResource', array(
                    'tag:IN' => $oldTags,
                    'AND:resource:=' => $resource->id
                ));
            }

            if ($group->remove_unused) {
                $c = $this->modx->newQuery('TaggerTagResource');
                $c->select($this->modx->getSelectColumns('TaggerTagResource', 'TaggerTagResource', '', array('tag')));
                $c->prepare();
                $c->stmt->execute();
                $IDs = $c->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

                $IDs = array_keys(array_flip($IDs));

                if (count($IDs) > 0) {
                    $this->modx->removeCollection('TaggerTag', array('id:NOT IN' => $IDs, 'group' => $group->id));
                }

            }
        }
    }

}