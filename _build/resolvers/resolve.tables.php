<?php
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            /** @var modX $modx */
            $modx =& $object->xpdo;

            $modelPath = $modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/';
            $modx->addPackage('tagger',$modelPath);

            $manager = $modx->getManager();
            $manager->createObjectContainer('TaggerGroup');
            $manager->createObjectContainer('TaggerTag');
            $manager->createObjectContainer('TaggerTagResource');

            break;
        case xPDOTransport::ACTION_UPGRADE:
            /** @var modX $modx */
            $modx =& $object->xpdo;

            // http://forums.modx.com/thread/88734/package-version-check#dis-post-489104
            $c = $modx->newQuery('transport.modTransportPackage');
            $c->where(array(
                'workspace' => 1,
                "(SELECT
                    `signature`
                  FROM {$modx->getTableName('modTransportPackage')} AS `latestPackage`
                  WHERE `latestPackage`.`package_name` = `modTransportPackage`.`package_name`
                  ORDER BY
                     `latestPackage`.`version_major` DESC,
                     `latestPackage`.`version_minor` DESC,
                     `latestPackage`.`version_patch` DESC,
                     IF(`release` = '' OR `release` = 'ga' OR `release` = 'pl','z',`release`) DESC,
                     `latestPackage`.`release_index` DESC
                  LIMIT 1,1) = `modTransportPackage`.`signature`",
            ));
            $c->where(array(
                'modTransportPackage.package_name' => 'tagger',
                'installed:IS NOT' => null
            ));

            /** @var modTransportPackage $oldPackage */
            $oldPackage = $modx->getObject('transport.modTransportPackage', $c);

            $modelPath = $modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/';
            $modx->addPackage('tagger',$modelPath);

            if ($oldPackage && $oldPackage->compareVersion('1.3.0-pl', '>')) {
                $manager = $modx->getManager();
                $manager->addField('TaggerGroup', 'alias');
                $manager->addField('TaggerGroup', 'hide_input');
                $manager->addField('TaggerGroup', 'tag_limit');

                $manager->addField('TaggerTag', 'alias');

                $tags = $modx->getCollection('TaggerTag', array('alias' => ''));
                foreach ($tags as $tag) {
                    $tag->save();
                }

                $groups = $modx->getCollection('TaggerGroup', array('alias' => ''));
                foreach ($groups as $group) {
                    $group->save();
                }
            }

            if ($oldPackage && $oldPackage->compareVersion('1.4.0-pl', '>')) {
                $manager = $modx->getManager();
                $manager->addField('TaggerGroup', 'description');
                $manager->addIndex('TaggerTag', 'iAlias');
            }

            if ($oldPackage && $oldPackage->compareVersion('1.5.0-pl', '>')) {
                $manager = $modx->getManager();
                $manager->addField('TaggerGroup', 'in_tvs_position');
            }

            break;
    }
}
return true;
