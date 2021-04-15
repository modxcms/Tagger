<?php

namespace Tagger;

use MODX\Revolution\modChunk;
use MODX\Revolution\modX;
use Tagger\Model\TaggerGroup;
use Tagger\Model\TaggerTag;

/**
 * The main Tagger service class.
 *
 * @package tagger
 */
class Tagger
{

    public $modx = null;

    public $namespace = 'tagger';

    public $cache = null;

    public $options = [];

    public function __construct(modX &$modx, array $options = [])
    {
        $this->modx =& $modx;

        $corePath = $this->getOption(
            'core_path',
            $options,
            $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/tagger/'
        );
        $assetsPath = $this->getOption(
            'assets_path',
            $options,
            $this->modx->getOption('assets_path', null, MODX_ASSETS_PATH) . 'components/tagger/'
        );
        $assetsUrl = $this->getOption(
            'assets_url',
            $options,
            $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/tagger/'
        );

        /* loads some default paths for easier management */
        $this->options = array_merge(
            [
                'namespace'     => $this->namespace,
                'corePath'      => $corePath,
                'modelPath'     => $corePath . 'model/',
                'chunksPath'    => $corePath . 'elements/chunks/',
                'snippetsPath'  => $corePath . 'elements/snippets/',
                'templatesPath' => $corePath . 'templates/',
                'assetsPath'    => $assetsPath,
                'assetsUrl'     => $assetsUrl,
                'jsUrl'         => $assetsUrl . 'js/',
                'cssUrl'        => $assetsUrl . 'css/',
            ],
            $options
        );

        $this->modx->lexicon->load('tagger:default');
        $this->modx->lexicon->load('tagger:custom');
    }

    /**
     * Get a local configuration option or a namespaced system setting by key.
     *
     * @param  string  $key  The option key to search for.
     * @param  array  $options  An array of options that override local options.
     * @param  mixed  $default  The default value returned if the option is not found locally or as a
     * namespaced system setting; by default this value is null.
     *
     * @return mixed The option value or the default value specified.
     */
    public function getOption($key, $options = [], $default = null)
    {
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

    public function getChunk($tpl, $phs = [])
    {
        if (strpos($tpl, '@INLINE ') !== false) {
            $content = str_replace('@INLINE', '', $tpl);
            /** @var modChunk $chunk */
            $chunk = $this->modx->newObject(modChunk::class, ['name' => 'inline-' . uniqid()]);
            $chunk->setCacheable(false);

            return $chunk->process($phs, $content);
        }

        return $this->modx->getChunk($tpl, $phs);
    }

    public function getCurrentTags()
    {
        $currentTags = [];

        /** @var TaggerGroup[] $groups */
        $groups = $this->modx->getIterator(TaggerGroup::class);
        foreach ($groups as $group) {
            if (isset($_GET[$group->alias])) {
                $groupTags = Utils::explodeAndClean($_GET[$group->alias]);
                if (!empty($groupTags)) {
                    $tags = [];
                    foreach ($groupTags as $groupTag) {
                        /** @var TaggerTag $tag */
                        $tag = $this->modx->getObject(
                            TaggerTag::class,
                            [
                                ['id' => $groupTag, 'OR:alias:=' => $groupTag],
                                'group' => $group->id,
                            ]
                        );
                        if ($tag) {
                            $tags[$tag->alias] = [
                                'tag'   => $tag->tag,
                                'label' => $tag->label,
                                'alias' => $tag->alias,
                            ];
                        } else {
                            $tags[$groupTag] = [
                                'tag'   => $groupTag,
                                'alias' => $groupTag,
                            ];
                        }
                    }

                    $currentTags[$group->alias] = [
                        'group' => $group->name,
                        'alias' => $group->alias,
                        'tags'  => $tags,
                    ];
                }
            }
        }

        return $currentTags;
    }
}
