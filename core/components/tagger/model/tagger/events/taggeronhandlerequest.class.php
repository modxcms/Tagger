<?php
class TaggerOnHandleRequest extends TaggerPlugin
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

        $this->modx->loadClass('TaggerGateway', $this->tagger->getOption('modelPath') . 'tagger/', true, true);

        $gateway = new TaggerGateway($this->modx);
        $gateway->init($this->scriptProperties);
        $gateway->handleRequest();
    }
}