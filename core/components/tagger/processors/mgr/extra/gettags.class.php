<?php
/**
 * Get list Tags
 *
 * @package tagger
 * @subpackage processors
 */
class TaggerGetTagsProcessor extends modObjectGetListProcessor {
    public $checkListPermission = true;


    public function process() {
        $group = $this->getProperty('group');


        $c = $this->modx->newQuery('TaggerTag');
        $c->select($this->modx->getSelectColumns('TaggerTag', 'TaggerTag', '', array('tag')));
        $c->where(array('group' => $group));

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $c->where(array(
                'tag:LIKE' => '%'.$query.'%'
            ));
        }

        $c->limit(20);

        $c->prepare();
        $c->stmt->execute();

        $returnArray = [];

        while ($tag = $c->stmt->fetch(PDO::FETCH_ASSOC)) {
            $returnArray[] = ['tag' => $tag['tag']];
        }

        return $this->outputArray($returnArray, count($returnArray));
    }

}
return 'TaggerGetTagsProcessor';