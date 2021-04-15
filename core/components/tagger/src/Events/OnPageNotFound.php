<?php
namespace Tagger\Events;

use Tagger\TaggerGateway;

class OnPageNotFound extends Event
{
    public function run()
    {
        if ($this->modx->context->get('key') == 'mgr') {
            return;
        }

        $friendlyURL = $this->modx->getOption('friendly_urls', null, 0);
        if ($friendlyURL == 0) {
            return;
        }

        $gateway = new TaggerGateway($this->modx);
        $gateway->init($this->scriptProperties);
        $gateway->handleRequest();
    }
}
