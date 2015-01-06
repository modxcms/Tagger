<?php
/**
 * TaggerGetTags
 *
 * DESCRIPTION
 *
 * This Snippet allows you to list tags for resource(s), group(s) and all tags
 *
 * PROPERTIES:
 *
 * &resources       string  optional    Comma separated list of resources for which will be listed Tags
 * &groups          string  optional    Comma separated list of Tagger Groups for which will be listed Tags
 * &rowTpl          string  optional    Name of a chunk that will be used for each Tag. If no chunk is given, array with available placeholders will be rendered
 * &outTpl          string  optional    Name of a chunk that will be used for wrapping all tags. If no chunk is given, tags will be rendered without a wrapper
 * &separator       string  optional    String separator, that will be used for separating Tags
 * &limit           int     optional    Limit number of returned tag Tags
 * &offset          int     optional    Offset the output by this number of Tags
 * &totalPh         string  optional    Placeholder to output the total number of Tags regardless of &limit and &offset
 * &target          int     optional    An ID of a resource that will be used for generating URI for a Tag. If no ID is given, current Resource ID will be used
 * &showUnused      int     optional    If 1 is set, Tags that are not assigned to any Resource will be included to the output as well
 * &showUnpublished int     optional    If 1 is set, Tags that are assigned only to unpublished Resources will be included to the output as well
 * &showDeleted     int     optional    If 1 is set, Tags that are assigned only to deleted Resources will be included to the output as well
 * &contexts        string  optional    If set, will display only tags for resources in given contexts. Contexts can be separated by a comma
 * &toPlaceholder   string  optional    If set, output will return in placeholder with given name
 * &sort            string  optional    Sort options in JSON. Example {"tag": "ASC"} or multiple sort options {"group_id": "ASC", "tag": "ASC"}
 * &friendlyURL     int     optional    If set, will be used instead of friendly_urls system setting to generate URL
 *
 * USAGE:
 *
 * [[!TaggerGetTags? &showUnused=`1`]]
 *
 *
 * @package tagger
 */

/** @var Tagger $tagger */
$tagger = $modx->getService('tagger','Tagger',$modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/tagger/',$scriptProperties);
if (!($tagger instanceof Tagger)) return '';

$resources = $modx->getOption('resources', $scriptProperties, '');
$groups = $modx->getOption('groups', $scriptProperties, '');
$target = (int) $modx->getOption('target', $scriptProperties, $modx->resource->id, true);
$showUnused = (int) $modx->getOption('showUnused', $scriptProperties, '0');
$showUnpublished = (int) $modx->getOption('showUnpublished', $scriptProperties, '0');
$showDeleted = (int) $modx->getOption('showDeleted', $scriptProperties, '0');
$contexts = $modx->getOption('contexts', $scriptProperties, '');
$translate = (int) $modx->getOption('translate', $scriptProperties, '0');

$defaultRowTpl = $modx->getOption('rowTpl', $scriptProperties, '');
$outTpl = $modx->getOption('outTpl', $scriptProperties, '');
$wrapIfEmpty = $modx->getOption('wrapIfEmpty', $scriptProperties, 1);
$separator = $modx->getOption('separator', $scriptProperties, '');
$limit = intval($modx->getOption('limit', $scriptProperties, 0));
$offset = intval($modx->getOption('offset', $scriptProperties, 0));
$totalPh = $modx->getOption('totalPh', $scriptProperties, 'tags_total');

$weight = (int) $modx->getOption('weight', $scriptProperties, '0');

$friendlyURL = $modx->getOption('friendlyURL', $scriptProperties, $modx->getOption('friendly_urls', null, 0));

$sort = $modx->getOption('sort', $scriptProperties, '{}');
$sort = $modx->fromJSON($sort);
if ($sort === null || $sort == '' || count($sort) == 0) {
    $sort = array(
        'tag' => 'ASC'
    );
}

$resources = $tagger->explodeAndClean($resources);
$groups = $tagger->explodeAndClean($groups);
$contexts = $tagger->explodeAndClean($contexts);
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, '');

$c = $modx->newQuery('TaggerTag');

$c->leftJoin('TaggerTagResource', 'Resources');
$c->leftJoin('TaggerGroup', 'Group');
$c->leftJoin('modResource', 'Resource', array('Resources.resource = Resource.id'));


if (!empty($contexts)) {
    $c->where(array(
        'Resource.context_key:IN' => $contexts,
    ));
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
    $c->having(array(
        'cnt > 0',
    ));
}

if ($resources) {
    $c->where(array(
        'Resources.resource:IN' => $resources
    ));
}

if ($groups) {
    $c->where(array(
        'Group.id:IN' => $groups,
        'OR:Group.name:IN' => $groups,
        'OR:Group.alias:IN' => $groups,
    ));
}
$c->select($modx->getSelectColumns('TaggerTag', 'TaggerTag'));
$c->select($modx->getSelectColumns('TaggerGroup', 'Group', 'group_'));
$c->select(array('cnt' => 'COUNT(Resources.tag)'));
$c->groupby($modx->getSelectColumns('TaggerTag', 'TaggerTag') . ',' . $modx->getSelectColumns('TaggerGroup', 'Group'));

$c->prepare();

$countQuery = new xPDOCriteria($modx, "SELECT COUNT(*) as total, MAX(cnt) as max_cnt FROM ({$c->toSQL(false)}) cq", $c->bindings, $c->cacheFlag);
$stmt = $countQuery->prepare();

if ($stmt && $stmt->execute()) {
    $fetchedData = $stmt->fetch(PDO::FETCH_ASSOC);
    $total = intval($fetchedData['total']);
    $maxCnt = intval($fetchedData['max_cnt']);
} else {
    $total = 0;
    $maxCnt = 0;
}

$modx->setPlaceholder($totalPh, $total);

foreach ($sort as $field => $dir) {
    $dir = (strtolower($dir) == 'asc') ? 'asc' : 'desc';
    $c->sortby($field, $dir);
}

$c->limit($limit, $offset);

$tags = $modx->getIterator('TaggerTag', $c);

$out = array();

// prep for &tpl_N
$keys = array_keys($scriptProperties);
$nthTpls = array();
foreach($keys as $key) {
    $keyBits = $tagger->explodeAndClean($key, '_');
    if (isset($keyBits[0]) && $keyBits[0] === 'tpl') {
        if ($i = (int) $keyBits[1]) $nthTpls[$i] = $scriptProperties[$key];
    }
}
ksort($nthTpls);

$idx = 1;
foreach ($tags as $tag) {
    /** @var TaggerTag $tag */
    $phs = $tag->toArray();

    $group = $tag->Group;

    if ($friendlyURL == 1) {
        $uri = rtrim($modx->makeUrl($target, '', ''), '/') . '/' . $group->alias . '/' . $tag->alias . '/';
    } else {
        $uri = $modx->makeUrl($target, '', $group->alias . '=' . $tag->alias);
    }

    $phs['uri'] = $uri;
    $phs['idx'] = $idx;
    $phs['target'] = $target;
    $phs['max_cnt'] = $maxCnt;

    if ($weight > 0) {
        $phs['weight'] = intval(ceil($phs['cnt'] / ($maxCnt / $weight)));
    }

    if ($translate == 1) {
        $groupNameTranslated = $modx->lexicon('tagger.custom.' . $phs['group_alias']);
        $groupDescriptionTranslated = $modx->lexicon('tagger.custom.' . $phs['group_alias'] . '_desc');

        $phs['group_name_translated'] = ($groupNameTranslated == 'tagger.custom.' . $phs['group_alias']) ? $phs['group_name'] : $groupNameTranslated;
        $phs['group_description_translated'] = ($groupDescriptionTranslated == 'tagger.custom.' . $phs['group_alias'] . '_desc') ? $phs['group_description'] : $groupDescriptionTranslated;
    }

    $rowTpl = $defaultRowTpl;
    if ($rowTpl == '') {
        $out[] = '<pre>' . print_r($phs, true) . '</pre>';
    } else {
        if (isset($nthTpls[$idx])) {
            $rowTpl = $nthTpls[$idx];
        } else {
            foreach ($nthTpls as $int => $tpl) {
                if ( ($idx % $int) === 0 ) $rowTpl = $tpl;
            }
        }

        $out[] = $tagger->getChunk($rowTpl, $phs);
    }

    $idx++;
}

$out = implode($separator, $out);

if ($outTpl != '') {
    if (!empty($out) || $wrapIfEmpty) {
        $out = $tagger->getChunk($outTpl, array('tags' => $out));
    }
}

if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $out);
    return '';
}

return $out;