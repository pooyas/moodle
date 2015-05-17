<?php


/**
 * Cache static store version information.
 *
 * This is used as a default cache store within the Cache API. It should never be deleted.
 *
 * @category   cache
 * @package    cache_stores
 * @subpackage static
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

$plugin->version   = 2014111000;    // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;    // Requires this Lion version.
$plugin->component = 'cachestore_static';  // Full name of the plugin.