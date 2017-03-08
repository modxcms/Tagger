<?php
/**
 * @property int $id
 * @property string $tag
 * @property string $alias
 * @property int $rank
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
        $tag = iconv('UTF-8', 'ASCII//TRANSLIT', $tag);
        
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
        
        if ($this->rank == '') {
            $c = $this->xpdo->newQuery('TaggerTag');
            $c->sortby('rank', 'desc');
            $c->where(array(
                'group' => $this->group
            ));
            $last = $this->xpdo->getObject('TaggerTag', $c);

            $this->set('rank', $last->rank + 1);
        }

        return parent :: save($cacheFlag);
    }
}
?>