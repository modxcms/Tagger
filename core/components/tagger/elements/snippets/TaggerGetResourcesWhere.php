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
 * &tags            string  optional    Comma separated list of Tags for which will be generated a Resource query. By
 * default Tags from GET param will be loaded
 * &groups          string  optional    Comma separated list of Tagger Groups. Only from those groups will Tags be
 * allowed
 * &where           string  optional    Original getResources where property. If you used where property in your
 * current getResources call, move it here
 * &likeComparison  int     optional    If set to 1, tags will compare using LIKE
 * &tagField        string  optional    Field that will be used to compare with given tags. Default: alias
 * &matchAll        int     optional    If set to 1, resource must have all specified tags. Default: 0 | If set to 2, an AND condition is used between different groups, an OR condition is used for tags in the same group
 * &errorOnInvalidTags bool optional    If set to true, will 404 on an invalid tag name request. Default: false
 * &field           string  optional    modResource field that will be used to compare with assigned resource ID
 *
 * USAGE:
 *
 * [[!getResources? &where=`[[!TaggerGetResourcesWhere? &tags=`Books,Vehicles` &where=`{"isfolder": 0}`]]`]]
 *
 * @var \MODX\Revolution\modX $modx
 * @var array $scriptProperties
 */

use Tagger\Model\TaggerGroup;
use Tagger\Model\TaggerTag;
use Tagger\Model\TaggerTagResource;

$tags = $modx->getOption('tags', $scriptProperties, '');
$where = $modx->getOption('where', $scriptProperties, '');
$tagField = $modx->getOption('tagField', $scriptProperties, 'alias');
$likeComparison = (int)$modx->getOption('likeComparison', $scriptProperties, 0);
$matchAll = (int)$modx->getOption('matchAll', $scriptProperties, 0);
$errorOnInvalidTags = (int)$modx->getOption('errorOnInvalidTags', $scriptProperties, 0);
$field = $modx->getOption('field', $scriptProperties, 'id');
$where = $modx->fromJSON($where);
if ($where == false) {
    $where = [];
}

$tagsCount = 0;

if ($tags == '') {
    $gc = $modx->newQuery(TaggerGroup::class);
    $gc->select($modx->getSelectColumns(TaggerGroup::class, '', '', ['alias']));

    $groups = $modx->getOption('groups', $scriptProperties, '');
    $groups = \Tagger\Utils::explodeAndClean($groups);
    if (!empty($groups)) {
        $gc->where(
            [
                'name:IN'     => $groups,
                'OR:alias:IN' => $groups,
                'OR:id:IN'    => $groups,
            ]
        );
    }

    $gc->prepare();
    $gc->stmt->execute();
    $groups = $gc->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    $conditions = [];
    foreach ($groups as $group) {
        if (isset($_GET[$group])) {
            $groupTags = \Tagger\Utils::explodeAndClean($_GET[$group]);
            if (!empty($groupTags)) {
                $like = ['AND:alias:IN' => $groupTags];

                if ($likeComparison == 1) {
                    foreach ($groupTags as $tag) {
                        $like[] = ['OR:alias:LIKE' => '%' . $tag . '%'];
                    }
                }

                $conditions[] = [
                    'OR:Group.alias:=' => $group,
                    $like,
                ];
                $tagsCount += count($groupTags);
            }
        }
    }

    if (count($conditions) == 0) {
        return $modx->toJSON($where);
    }

    $c = $modx->newQuery(TaggerTag::class);
    $c->leftJoin(TaggerGroup::class, 'Group');
    $c->select($modx->getSelectColumns(TaggerTag::class, 'TaggerTag', '', ['id', 'group']));

    $c->where($conditions);
} else {
    $tags = \Tagger\Utils::explodeAndClean($tags);

    if (empty($tags)) {
        return $modx->toJSON($where);
    }

    $tagsCount = count($tags);

    $groups = $modx->getOption('groups', $scriptProperties, '');

    $groups = \Tagger\Utils::explodeAndClean($groups);

    $c = $modx->newQuery(TaggerTag::class);
    $c->select($modx->getSelectColumns(TaggerTag::class, 'TaggerTag', '', ['id', 'group']));

    $compare = [
        $tagField . ':IN' => $tags,
    ];

    if ($likeComparison == 1) {
        foreach ($tags as $tag) {
            $compare[] = ['OR:' . $tagField . ':LIKE' => '%' . $tag . '%'];
        }
    }

    $c->where($compare);

    if (!empty($groups)) {
        $c->leftJoin(TaggerGroup::class, 'Group');
        $c->where(
            [
                'Group.id:IN'       => $groups,
                'OR:Group.name:IN'  => $groups,
                'OR:Group.alias:IN' => $groups,
            ]
        );
    }
}

$c->prepare();
$c->stmt->execute();

$tagGroups = [];
$tagIDs = [];
if ($matchAll === 2) {
    // Group the tags
    $taggerTags = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($taggerTags as $tag) {
        if (!array_key_exists($tag['group'], $tagGroups)) {
            $tagGroups[$tag['group']] = [];
        }
        $tagGroups[$tag['group']][] = $tag['id'];
        $tagIDs[] = $tag['id'];
    }
} else {
    $tagIDs = $c->stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

if (count($tagIDs) == 0) {
    $tagIDs[] = 0;
    if ($errorOnInvalidTags == 1) {
        $modx->sendForward($modx->getOption('error_page'), ['response_code' => 'HTTP/1.1 404 Not Found']);
    }
}

if ($matchAll == 0) {
    $where[] = "EXISTS (SELECT 1 FROM {$modx->getTableName(TaggerTagResource::class)} r WHERE r.tag IN (" . implode(
            ',',
            $tagIDs
        ) . ") AND r.resource = modResource." . $field . ")";
} elseif ($matchAll === 2) {
    foreach ($tagGroups as $tagGroupIDs) {
        $where[] = "EXISTS (SELECT 1 FROM {$modx->getTableName(TaggerTagResource::class)} r WHERE r.tag IN (" . implode(
            ',',
            $tagGroupIDs
        ) . ") AND r.resource = modResource." . $field . ")";
    }
} else {
    $where[] = "EXISTS (SELECT 1 as found FROM {$modx->getTableName(TaggerTagResource::class)} r WHERE r.tag IN ("
        . implode(',', $tagIDs) . ") AND r.resource = modResource." . $field . " GROUP BY found HAVING count(found) = "
        . $tagsCount . ")";
}

return $modx->toJSON($where);