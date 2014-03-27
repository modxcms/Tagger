<?php
/**
 * TaggerGetResourcesWhere
 *
 * DESCRIPTION
 *
 * This snippet generate SQL Query that can be used in WHERE condition in getResources snippet
 *
 * PROPERTIES:
 *
 * &tags string optional
 * &groups string optional
 * &where string optional
 *
 * USAGE:
 *
 * [[!getResources? &where=`[[!TaggerGetResourcesWhere? &tags=`Books,Vehicles` &where=`{"isfolder": 0}`]]`]]
 *
 */

$tagger = $modx->getService('tagger','Tagger',$modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/tagger/',$scriptProperties);
if (!($tagger instanceof Tagger)) return '';

$tagKey = $modx->getOption('tagger.tag_key', null, 'tags');
$tags = $modx->getOption('tags', $scriptProperties, '');
$where = $modx->getOption('where', $scriptProperties, '');

$where = $modx->fromJSON($where);
if ($where == false) {
    $where = array();
}

if ($tags == '') {
    if (isset($_GET[$tagKey])) {
        $tags = $_GET[$tagKey];
    } else {
        return $modx->toJSON($where);
    }
}

$groups = $modx->getOption('groups', $scriptProperties, '');

$tags = $tagger->explodeAndClean($tags);
$groups = $tagger->explodeAndClean($groups);

$c = $modx->newQuery('TaggerTag');
$c->select($modx->getSelectColumns('TaggerTag', 'TaggerTag', '', array('id')));
$c->where(array(
    'tag:IN' => $tags
));

if (count($groups) > 0) {
    $c->leftJoin('TaggerGroup', 'Group');
    $c->where(array(
        'Group.id:IN' => $groups,
        'OR:Group.name:IN' => $groups,
    ));
}

$c->prepare();
$c->stmt->execute();
$tagIDs = $c->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

if (count($tagIDs) == 0) {
    $tagIDs[] = 0;
}

$where[] = "EXISTS (SELECT 1 FROM {$modx->getTableName('TaggerTagResource')} r WHERE r.tag IN (" . implode(',', $tagIDs) . ") AND r.resource = modResource.id)";

return $modx->toJSON($where);