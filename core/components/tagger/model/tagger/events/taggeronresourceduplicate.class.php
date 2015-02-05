<?php
class TaggerOnResourceDuplicate extends TaggerPlugin
{
    public function run()
    {
        /** @var modResource $oldResource */
        $oldResource = $this->scriptProperties['oldResource'];

        /** @var modResource $newResource */
        $newResource = $this->scriptProperties['newResource'];

        /** @var TaggerTagResource[] $oldRelations */
        $oldRelations = $this->modx->getIterator('TaggerTagResource', array('resource' => $oldResource->id));

        foreach ($oldRelations as $oldRelation) {
            /** @var TaggerTagResource $newRelation */
            $newRelation = $this->modx->newObject('TaggerTagResource');
            $newRelation->set('resource', $newResource->id);
            $newRelation->set('tag', $oldRelation->tag);
            $newRelation->save();
        }

        $this->duplicateChildren($oldResource->Children, $newResource->Children);
    }

    private function duplicateChildren($oldChildren, $newChildren)
    {
        if (empty($oldChildren) || empty($newChildren)) return;

        if (count($oldChildren) != count($newChildren)) return;

        $oldNew = array_combine(array_keys($oldChildren), array_keys($newChildren));

        foreach ($oldChildren as $key => $oldChild) {
            /** @var TaggerTagResource[] $oldRelations */
            $oldRelations = $this->modx->getIterator('TaggerTagResource', array('resource' => $oldChild->id));

            foreach ($oldRelations as $oldRelation) {
                $newRelation = $this->modx->newObject('TaggerTagResource');
                $newRelation->set('resource', $newChildren[$oldNew[$key]]->id);
                $newRelation->set('tag', $oldRelation->tag);
                $newRelation->save();
            }

            $this->duplicateChildren($oldChild->Children, $newChildren[$oldNew[$key]]->Children);
        }
    }
}