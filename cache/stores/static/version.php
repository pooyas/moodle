<?php

/**
 * Cache static store version information.
 *
 * This is used as a default cache store within the Cache API. It should never be deleted.
 *
 * @package    cachestore_static
 * @category   cache
 * @copyright  2012 Sam Hemelryk
 * 
 */

defined('LION_INTERNAL') || die;

$plugin->version   = 2014111000;    // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;    // Requires this Lion version.
$plugin->component = 'cachestore_static';  // Full name of the plugin.