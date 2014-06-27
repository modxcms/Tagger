<?php
/**
 * @property int $id
 * @property string $tag
 * @property string $alias
 * @property int $group
 *
 * @property TaggerGroup $Group
 * @property TaggerTagResource $Resources
 *
 * @package tagger
 */
class TaggerTag extends xPDOSimpleObject {

    public function cleanAlias($tag) {
        $res = new modResource($this->xpdo);
        $tag = str_replace('/', '-', $tag);
        return $res->cleanAlias($tag);
    }

    public function generateUniqueAlias($tag) {
        $alias = $this->cleanAlias($tag);

        $tag = $this->xpdo->getObject('TaggerTag', array('alias' => $alias, 'group' => $this->group, 'id:!=' => $this->id));
        $i = 1;
        $newAlias = $alias;

        while($tag) {
            $newAlias = $alias . '-' . $i;
            $tag = $this->xpdo->getObject('TaggerTag', array('alias' => $newAlias, 'group' => $this->group, 'id:!=' => $this->id));
        }

        return $newAlias;
    }

    public function save($cacheFlag= null) {
        if ($this->alias == '') {
            $this->set('alias', $this->generateUniqueAlias($this->tag));
        }

        return parent :: save($cacheFlag);
    }
}
?>