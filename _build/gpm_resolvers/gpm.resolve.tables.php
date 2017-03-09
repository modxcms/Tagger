<?php
/**
 * Resolve creating db tables
 *
 * THIS RESOLVER IS AUTOMATICALLY GENERATED, NO CHANGES WILL APPLY
 *
 * @package tagger
 * @subpackage build
 *
 * @var mixed $object
 * @var modX $modx
 * @var array $options
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('tagger.core_path', null, $modx->getOption('core_path') . 'components/tagger/') . 'model/';
            
            $modx->addPackage('tagger', $modelPath, null);


            $manager = $modx->getManager();

            $manager->createObjectContainer('TaggerGroup');
            $manager->createObjectContainer('TaggerTag');
            $manager->createObjectContainer('TaggerTagResource');

            break;
    }
}

return true;