<?php


/**
 * Defines the version of workshop
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;        // the current module version (YYYYMMDDXX)
$plugin->requires  = 2014110400;        // requires this Lion version
$plugin->component = 'mod_workshop';    // full name of the plugin (used for diagnostics)
$plugin->cron      = 60;                // give as a chance every minute
