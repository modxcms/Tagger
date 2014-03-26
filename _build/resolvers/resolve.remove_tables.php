<?php
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UNINSTALL:
            /** @var modX $modx */
            $modx =& $object->xpdo;

            $modelPath = $modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/';
            $modx->addPackage('tagger',$modelPath);

            $manager = $modx->getManager();

            $manager->removeObjectContainer('TaggerGroup');
            $manager->removeObjectContainer('TaggerTag');
            $manager->removeObjectContainer('TaggerTagResource');
            break;
    }
}
return true;