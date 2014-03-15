<?php
/**
 * @package tagger
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/taggertagresource.class.php');
class TaggerTagResource_mysql extends TaggerTagResource {}
?>