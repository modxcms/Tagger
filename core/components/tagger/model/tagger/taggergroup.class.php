<?php
/**
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $field_type
 * @property boolean $allow_new
 * @property boolean $remove_unused
 * @property boolean $allow_blank
 * @property boolean $allow_type
 * @property boolean $show_autotag
 * @property boolean $hide_input
 * @property int $tag_limit
 * @property int $in_tvs_position
 * @property string $show_for_templates
 * @property string $show_for_contexts
 * @property string $place
 * @property int $position
 * @property string $sort_field
 * @property string $sort_dir
 *
 * @property TaggerTag $Tags
 *
 * @package tagger
 */
class TaggerGroup extends xPDOSimpleObject {

    public function cleanAlias($name) {
        $res = new modResource($this->xpdo);
        $name = str_replace('/', '-', $name);
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        
        return $res->cleanAlias($name);
    }

    public function generateUniqueAlias($name) {
        $alias = $this->cleanAlias($name);

        $group = $this->xpdo->getObject('TaggerGroup', array('alias' => $alias, 'id:!=' => $this->id));
        $i = 1;
        $newAlias = $alias;

        while($group) {
            $newAlias = $alias . '-' . $i;
            $group = $this->xpdo->getObject('TaggerGroup', array('alias' => $newAlias, 'id:!=' => $this->id));
        }

        return $newAlias;
    }

    public function save($cacheFlag= null) {
        if ($this->alias == '') {
            $this->set('alias', $this->generateUniqueAlias($this->name));
        }
        
        if (!in_array($this->sort_field, array('alias', 'rank'))) {
            $this->set('sort_field','alias');
        }
        
        if (!in_array($this->sort_dir, array('asc', 'desc'))) {
            $this->set('sort_dir','asc');
        }

        return parent :: save($cacheFlag);
    }
}
?>