<?php

namespace Tagger\Model;

use MODX\Revolution\modResource;

/**
 * Class TaggerGroup
 *
 * @property string $name
 * @property string $alias
 * @property string $field_type
 * @property boolean $allow_new
 * @property boolean $remove_unused
 * @property boolean $allow_blank
 * @property boolean $allow_type
 * @property boolean $show_autotag
 * @property boolean $hide_input
 * @property integer $tag_limit
 * @property string $show_for_templates
 * @property string $place
 * @property integer $position
 * @property string $description
 * @property integer $in_tvs_position
 * @property boolean $as_radio
 * @property string $sort_field
 * @property string $sort_dir
 * @property string $show_for_contexts
 *
 * @property \Tagger\Model\TaggerTag[] $Tags
 *
 * @package Tagger\Model
 */
class TaggerGroup extends \xPDO\Om\xPDOSimpleObject
{

    public function save($cacheFlag = null)
    {
        if ($this->alias == '') {
            $this->set('alias', $this->generateUniqueAlias($this->name));
        }

        if (!in_array($this->sort_field, ['alias', 'rank'])) {
            $this->set('sort_field', 'alias');
        }

        if (!in_array($this->sort_dir, ['asc', 'desc'])) {
            $this->set('sort_dir', 'asc');
        }

        return parent:: save($cacheFlag);
    }

    public function generateUniqueAlias($name)
    {
        $alias = $this->cleanAlias($name);

        $group = $this->xpdo->getObject(TaggerGroup::class, ['alias' => $alias, 'id:!=' => $this->id]);
        $i = 1;
        $newAlias = $alias;

        while ($group) {
            $newAlias = $alias . '-' . $i;
            $group = $this->xpdo->getObject(TaggerGroup::class, ['alias' => $newAlias, 'id:!=' => $this->id]);
        }

        return $newAlias;
    }

    public function cleanAlias($name)
    {
        $name = str_replace('/', '-', $name);

        $removeAccents = (int)$this->xpdo->getOption('tagger.remove_accents_group', [], 1);
        if ($removeAccents == 1) {
            $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        }

        return modResource::filterPathSegment($this->xpdo, $name);
    }

}
