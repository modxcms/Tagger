<?php

/**
 * The main Tagger service class.
 *
 * @package tagger
 */
class Tagger {
    public $modx = null;
    public $namespace = 'tagger';
    public $cache = null;
    public $options = array();

    public function __construct(modX &$modx, array $options = array()) {
        $this->modx =& $modx;
        $this->namespace = $this->getOption('namespace', $options, 'tagger');

        $corePath = $this->getOption('core_path', $options, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/tagger/');
        $assetsPath = $this->getOption('assets_path', $options, $this->modx->getOption('assets_path', null, MODX_ASSETS_PATH) . 'components/tagger/');
        $assetsUrl = $this->getOption('assets_url', $options, $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/tagger/');

        /* loads some default paths for easier management */
        $this->options = array_merge(array(
            'namespace' => $this->namespace,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'templatesPath' => $corePath . 'templates/',
            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'jsUrl' => $assetsUrl . 'js/',
            'cssUrl' => $assetsUrl . 'css/',
            'connectorUrl' => $assetsUrl . 'connector.php'
        ), $options);

        $this->modx->addPackage('tagger', $this->getOption('modelPath'));
        $this->modx->lexicon->load('tagger:default');
    }

    /**
     * Get a local configuration option or a namespaced system setting by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override local options.
     * @param mixed $default The default value returned if the option is not found locally or as a
     * namespaced system setting; by default this value is null.
     * @return mixed The option value or the default value specified.
     */
    public function getOption($key, $options = array(), $default = null) {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->options)) {
                $option = $this->options[$key];
            } elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}.{$key}");
            }
        }
        return $option;
    }

    public function onDocFormPrerender() {
        $this->modx->controller->addLexiconTopic('tagger:default');

        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/tagger.js');

        $groups = $this->modx->getIterator('TaggerGroup');
        $groupsArray = [];
        foreach ($groups as $group) {
            $groupsArray[] = $group->toArray();
        }

        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
        //Ext.onReady(function() {
            Tagger.config = '.$this->modx->toJSON($this->options).';
            Tagger.config.connector_url = "'.$this->getOption('connectorUrl').'";
            Tagger.groups = ' . $this->modx->toJSON($groupsArray) . ';
        //});
        </script>');

        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/inject/tab.js');
    }
}