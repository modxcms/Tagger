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
        $limit = $this->getProperty('limit', 20);
        $start = $this->getProperty('start', 0);
        $sortField = $this->getProperty('sort_field', 'alias');
        $sortDir = $this->getProperty('sort_dir', 'asc');

        $c = $this->modx->newQuery('TaggerTag');
        $c->where(array('group' => $group));

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $c->where(array(
                'tag:LIKE' => '%'.$query.'%'
            ));
        }

        $cnt = $this->modx->getCount('TaggerTag', $c);

        $c->select($this->modx->getSelectColumns('TaggerTag', 'TaggerTag', '', array('tag')));
        $c->limit($limit, $start);
        $c->sortby($sortField,$sortDir);

        $c->prepare();
        $c->stmt->execute();

        $returnArray = array();

        while ($tag = $c->stmt->fetch(PDO::FETCH_ASSOC)) {
            $returnArray[] = array('tag' => $tag['tag']);
        }

        return $this->outputArray($returnArray, $cnt);
    }

}
return 'TaggerGetTagsProcessor';
