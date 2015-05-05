<?php

/**
 * Meta link enrolment plugin version specification.
 *
 * @package    enrol
 * @subpackage meta
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014112400;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'enrol_meta';      // Full name of the plugin (used for diagnostics)
$plugin->cron      = 60*60;             // run cron every hour by default, it is not out-of-sync often
