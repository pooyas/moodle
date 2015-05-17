<?php


/**
 * Cache memcache store version information.
 *
 * Not to be confused with the memcached plugin.
 *
 * @package    cache_stores
 * @subpackage memcache
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

$plugin->version = 2014111000;    // The current module version (Date: YYYYMMDDXX)
$plugin->requires = 2014110400;    // Requires this Lion version.
$plugin->component = 'cachestore_memcache';  // Full name of the plugin.
