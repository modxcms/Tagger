<?php

namespace Tagger\Model;

use MODX\Revolution\modResource;

/**
 * Class TaggerTag
 *
 * @property string $tag
 * @property string $label
 * @property string $alias
 * @property int $group
 * @property int $rank
 *
 * @property \Tagger\Model\TaggerTagResource[] $Resources
 *
 * @package Tagger\Model
 */
class TaggerTag extends \xPDO\Om\xPDOSimpleObject
{

    public function save($cacheFlag = null)
    {
        if ($this->alias == '') {
            $this->set('alias', $this->generateUniqueAlias($this->tag));
        }

        if ($this->rank == '') {
            $c = $this->xpdo->newQuery(TaggerTag::class);
            $c->sortby('rank', 'desc');
            $c->where(
                [
                    'group' => $this->group,
                ]
            );

            /** @var TaggerTag $last */
            $last = $this->xpdo->getObject(TaggerTag::class, $c);

            $this->set('rank', $last->rank + 1);
        }

        if (empty($this->label)) {
            $this->label = $this->tag;
        }

        return parent:: save($cacheFlag);
    }

    public function generateUniqueAlias($tag)
    {
        $alias = $this->cleanAlias($tag);

        $tag = $this->xpdo->getObject(TaggerTag::class, ['alias' => $alias, 'group' => $this->group, 'id:!=' => $this->id]);
        $i = 1;
        $newAlias = $alias;

        while ($tag) {
            $newAlias = $alias . '-' . $i;
            $tag = $this->xpdo->getObject(
                TaggerTag::class,
                ['alias' => $newAlias, 'group' => $this->group, 'id:!=' => $this->id]
            );
        }

        return $newAlias;
    }

    public function cleanAlias($tag)
    {
        $tag = str_replace('/', '-', $tag);

        $removeAccents = (int)$this->xpdo->getOption('tagger.remove_accents_tag', [], 1);
        if ($removeAccents == 1) {
            $tag = iconv('UTF-8', 'ASCII//TRANSLIT', $tag);
        }

        return modResource::filterPathSegment($this->xpdo, $tag);
    }

}
