<?php

/**
 * TaggerGetRelatedWhere
 *
 * DESCRIPTION
 *
 * This snippet generates a SQL Query that can be used in WHERE condition in getResources snippet
 * to get related resources, which have the same tags 
 *
 * PROPERTIES:
 *
 * &resources       string  optional    Comma separated list of resources for which will be listed Tags. Default: current resource
 * &groups          string  optional    Comma separated list of Tagger Groups for which will be listed Tags
 * &showUnused      int     optional    If 1 is set, Tags that are not assigned to any Resource will be included to the output as well
 * &showUnpublished int     optional    If 1 is set, Tags that are assigned only to unpublished Resources will be included to the output as well
 * &showDeleted     int     optional    If 1 is set, Tags that are assigned only to deleted Resources will be included to the output as well
 * &contexts        string  optional    If set, will display only tags for resources in given contexts. Contexts can be separated by a comma
 * 
 * TaggerGetResourcesWhere - PROPERTIES:
 * 
 * &tags            string  optional    Comma separated list of Tags for which will be generated a Resource query. By default Tags from GET param will be loaded
 * &groups          string  optional    Comma separated list of Tagger Groups. Only from those groups will Tags be allowed
 * &where           string  optional    Original getResources where property. If you used where property in your current getResources call, move it here
 * &likeComparison  int     optional    If set to 1, tags will compare using LIKE
 * &tagField        string  optional    Field that will be used to compare with given tags. Default: alias
 * &matchAll        int     optional    If set to 1, resource must have all specified tags. Default: 0 
 *
 * USAGE:
 *
 * [[!TaggerGetRelatedWhere? &groups=`1` ]]
 *
 *
 * @package tagger
 */

/**
 @var Tagger $tagger */
$tagger = $modx->getService('tagger', 'Tagger', $modx->getOption('tagger.core_path', null, $modx->getOption('core_path') . 'components/tagger/') . 'model/tagger/', $scriptProperties);
if (!($tagger instanceof Tagger))
    return '';

$resources = $modx->getOption('resources', $scriptProperties, is_object($modx->resource) ? $modx->resource->get('id') : '');
$groups = $modx->getOption('groups', $scriptProperties, '');
$showUnused = (int)$modx->getOption('showUnused', $scriptProperties, '0');
$showUnpublished = (int)$modx->getOption('showUnpublished', $scriptProperties, '0');
$showDeleted = (int)$modx->getOption('showDeleted', $scriptProperties, '0');
$contexts = $modx->getOption('contexts', $scriptProperties, '');

$totalPh = $modx->getOption('totalPh', $scriptProperties, 'tags_total');

$resources = $tagger->explodeAndClean($resources);
$groups = $tagger->explodeAndClean($groups);
$contexts = $tagger->explodeAndClean($contexts);

$c = $modx->newQuery('TaggerTag');

$c->leftJoin('TaggerTagResource', 'Resources');
$c->leftJoin('TaggerGroup', 'Group');
$c->leftJoin('modResource', 'Resource', array('Resources.resource = Resource.id'));


if (!empty($contexts)) {
    $c->where(array('Resource.context_key:IN' => $contexts, ));
}

if ($showUnpublished == 0) {
    $c->where(array(
        'Resource.published' => 1,
        'OR:Resource.published:IN' => null,
        ));
}

if ($showDeleted == 0) {
    $c->where(array(
        'Resource.deleted' => 0,
        'OR:Resource.deleted:IS' => null,
        ));
}

if ($showUnused == 0) {
    $c->having(array('cnt > 0', ));
}

if ($resources) {
    $c->where(array('Resources.resource:IN' => $resources));
}

if ($groups) {
    $c->where(array(
        'Group.id:IN' => $groups,
        'OR:Group.name:IN' => $groups,
        'OR:Group.alias:IN' => $groups,
        ));
}
$c->select($modx->getSelectColumns('TaggerTag', 'TaggerTag'));
//$c->select($modx->getSelectColumns('TaggerGroup', 'Group', 'group_'));
$c->select(array('cnt' => 'COUNT(Resources.tag)'));
$c->groupby($modx->getSelectColumns('TaggerTag', 'TaggerTag') . ',' . $modx->getSelectColumns('TaggerGroup', 'Group'));

$c->prepare();
$countQuery = new xPDOCriteria($modx, "SELECT COUNT(*) FROM ({$c->toSQL(false)}) cq", $c->bindings, $c->cacheFlag);
$stmt = $countQuery->prepare();
if ($stmt && $stmt->execute()) {
    $total = intval($stmt->fetchColumn());
} else {
    $total = 0;
}

$modx->setPlaceholder($totalPh, $total);

$tags = array();

if ($collection = $modx->getIterator('TaggerTag', $c)) {
    foreach ($collection as $tag) {
        $tags[] = $tag->get('tag');
    }
}

$wherecondition = array('id:not IN' => $resources);

$scriptProperties['where'] = $modx->toJson($wherecondition);

$output = '{"template":"99999999"}';

if (count($tags)) {
    $scriptProperties['tags'] = implode(',', $tags);
    $output = $modx->runSnippet('TaggerGetResourcesWhere', $scriptProperties);
}

return $output;
