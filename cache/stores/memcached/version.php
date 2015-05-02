<?php

/**
 * Cache memcached store version information.
 *
 * Not to be confused with the memcache plugin.
 *
 * @package    cachestore_memcached
 * @copyright  2012 Sam Hemelryk
 * 
 */

defined('LION_INTERNAL') || die;

$plugin->version   = 2014111000;    // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;    // Requires this Lion version.
$plugin->component = 'cachestore_memcached';  // Full name of the plugin.