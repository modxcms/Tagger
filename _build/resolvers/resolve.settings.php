<?php
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
            /** @var modX $modx */
            $modx =& $object->xpdo;

            $tagKey = $modx->getObject('modSystemSetting', array('key' => 'tagger.tag_key'));
            if ($tagKey) {
                $tagKey->remove();
            }
            break;
    }
}
return true;