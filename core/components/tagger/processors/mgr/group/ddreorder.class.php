<?php
/**
 * Reorder items after drag and drop in grid
 *
 * @package tagger
 * @subpackage processors
 */
class TaggerReorderGroupUpdateProcessor extends modObjectProcessor {
    public $classKey = 'TaggerGroup';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.group';

    public function process(){
        $idGroup = $this->getProperty('idGroup');
        $oldIndex = $this->getProperty('oldIndex');
        $newIndex = $this->getProperty('newIndex');

        $groups = $this->modx->newQuery($this->classKey);
        $groups->where(array(
            'id:!=' => $idGroup,
            'position:>=' => min($oldIndex, $newIndex),
            'position:<=' => max($oldIndex, $newIndex),
        ));

        $groups->sortby('position', 'ASC');

        $groupsCollection = $this->modx->getCollection($this->classKey, $groups);

        if(min($oldIndex, $newIndex) == $newIndex){
            foreach ($groupsCollection as $group) {
                $groupObject = $this->modx->getObject($this->classKey, $group->get('id'));
                $groupObject->set('position', $groupObject->get('position') + 1);
                $groupObject->save();
            }
        }else{
            foreach ($groupsCollection as $group) {
                $groupObject = $this->modx->getObject($this->classKey, $group->get('id'));
                $groupObject->set('position', $groupObject->get('position') - 1);
                $groupObject->save();
            }
        }

        $groupObject = $this->modx->getObject($this->classKey, $idGroup);
        $groupObject->set('position', $newIndex);
        $groupObject->save();


        return $this->success('', $groupObject);
    }

}
return 'TaggerReorderGroupUpdateProcessor';