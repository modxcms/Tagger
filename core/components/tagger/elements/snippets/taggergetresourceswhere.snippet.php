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
 * &tags            string  optional    Comma separated list of Tags for which will be generated a Resource query. By default Tags from GET param will be loaded
 * &groups          string  optional    Comma separated list of Tagger Groups. Only from those groups will Tags be allowed
 * &where           string  optional    Original getResources where property. If you used where property in your current getResources call, move it here
 * &likeComparison  int     optional    If set to 1, tags will compare using LIKE
 *
 * USAGE:
 *
 * [[!getResources? &where=`[[!TaggerGetResourcesWhere? &tags=`Books,Vehicles` &where=`{"isfolder": 0}`]]`]]
 *
 */

$tagger = $modx->getService('tagger','Tagger',$modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/tagger/',$scriptProperties);
if (!($tagger instanceof Tagger)) return '';

$tags = $modx->getOption('tags', $scriptProperties, '');
$where = $modx->getOption('where', $scriptProperties, '');
$likeComparison = (int) $modx->getOption('likeComparison', $scriptProperties, 0);

$where = $modx->fromJSON($where);
if ($where == false) {
    $where = array();
}

if ($tags == '') {

    if (!empty($_GET[$tagKey])) {
        $tagList = $tagger->explodeAndClean($_GET[$tagKey]);

        if (!empty($tagList)) {
            $conditions = array('AND:TaggerTag.alias:IN' => $tagList);

            if ($likeComparison == 1) {
                foreach ($tagList as $tag) {
                    $conditions[] = array('OR:TaggerTag.alias:LIKE' => '%' . $tag . '%');
                }
            }
        }

        if (!empty($conditions)) {
            $c = $modx->newQuery('TaggerTagResource');
            $c->select('TaggerTagResource.resource');
            $c->innerJoin('TaggerTag', '', array('TaggerTag.id = TaggerTagResource.tag'));
            $c->where($conditions);
            $c->groupby('TaggerTagResource.resource');
            $c->prepare();
            $where[] = 'modResource.id IN(' . $c->toSQL() . ')';
            $c = null;
        }

        // Ignore other GET parameters
        return $modx->toJSON($where);
    }

    $gc = $modx->newQuery('TaggerGroup');
    $gc->select($modx->getSelectColumns('TaggerGroup', '', '', array('alias')));
    $gc->prepare();
    $gc->stmt->execute();
    $groups = $gc->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    $conditions = array();
    foreach ($groups as $group) {
        if (isset($_GET[$group])) {
            $groupTags = $tagger->explodeAndClean($_GET[$group]);
            if (!empty($groupTags)) {
                $like = array('AND:alias:IN' => $groupTags);

                if ($likeComparison == 1) {
                    foreach ($groupTags as $tag) {
                        $like[] = array('OR:alias:LIKE' => '%' . $tag . '%');
                    }
                }

                $conditions[] = array(
                    'OR:Group.alias:=' => $group,
                    $like
                );
            }
        }
    }

    if (count($conditions) == 0) {
        return $modx->toJSON($where);
    }

    $c = $modx->newQuery('TaggerTag');
    $c->leftJoin('TaggerGroup', 'Group');

    $c->where($conditions);
} else {
    $tags = $tagger->explodeAndClean($tags);

    if (empty($tags)) {
        return $modx->toJSON($where);
    }

    $groups = $modx->getOption('groups', $scriptProperties, '');

    $groups = $tagger->explodeAndClean($groups);

    $c = $modx->newQuery('TaggerTag');
    $c->select($modx->getSelectColumns('TaggerTag', 'TaggerTag', '', array('id')));

    $compare = array(
        'alias:IN' => $tags
    );

    if ($likeComparison == 1) {
        foreach ($tags as $tag) {
            $compare[] = array('OR:alias:LIKE' => '%' . $tag . '%');
        }
    }

    $c->where($compare);

    if (count($groups) > 0) {
        $c->leftJoin('TaggerGroup', 'Group');
        $c->where(array(
            'Group.id:IN' => $groups,
            'OR:Group.name:IN' => $groups,
        ));
    }
}

$c->prepare();
$c->stmt->execute();
$tagIDs = $c->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

if (count($tagIDs) == 0) {
    $tagIDs[] = 0;
}

$where[] = "modResource.id IN(SELECT resource FROM {$modx->getTableName('TaggerTagResource')}"
    . " WHERE tag IN (" . implode(',', $tagIDs) . ") GROUP BY resource)";

return $modx->toJSON($where);
