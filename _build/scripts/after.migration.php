<?php

use MODX\Revolution\modX;
use MODX\Revolution\Transport\modTransportPackage;
use xPDO\Transport\xPDOTransport;

/**
 * @var xPDOTransport $transport
 * @var array $object
 * @var array $options
 */

if ($options[xPDOTransport::PACKAGE_ACTION] !== xPDOTransport::ACTION_UPGRADE) return true;

/** @var modX $modx */
$modx =& $transport->xpdo;

// http://forums.modx.com/thread/88734/package-version-check#dis-post-489104
$c = $modx->newQuery(modTransportPackage::class);
$c->where(array(
    'workspace' => 1,
    "(SELECT
        `signature`
      FROM {$modx->getTableName(modTransportPackage::class)} AS `latestPackage`
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
$oldPackage = $modx->getObject(modTransportPackage::class, $c);

//if ($oldPackage && $oldPackage->compareVersion('1.10.0-pl', '>')) {
//
//}

return true;
