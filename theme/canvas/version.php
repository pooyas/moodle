<?php

/**
 * Theme version info
 *
 * @package    theme
 * @subpackage canvas
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

$plugin->version   = 2014111000; // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400; // Requires this Lion version
$plugin->component = 'theme_canvas'; // Full name of the plugin (used for diagnostics)
$plugin->dependencies = array(
    'theme_base'  => 2014110400,
);
