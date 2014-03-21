<?php
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;

            $modelPath = $modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/';
            $modx->addPackage('tagger',$modelPath);

            $manager = $modx->getManager();
            $manager->createObjectContainer('TaggerGroup');
            $manager->createObjectContainer('TaggerTag');
            $manager->createObjectContainer('TaggerTagResource');

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;