<?php

/**
 * Self enrolment plugin version specification.
 *
 * @package    enrol
 * @subpackage self
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111001;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'enrol_self';      // Full name of the plugin (used for diagnostics)
$plugin->cron      = 600;
