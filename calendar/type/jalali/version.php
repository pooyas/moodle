<?php


/**
 * Version details.
 *
 * @package    calendar_type
 * @subpackage jalali
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->version    = 2013110100; // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires   = 2013110100; // Requires this Lion version.
$plugin->component  = 'calendartype_jalali'; // Full name of the plugin (used for diagnostics).
$plugin->release    = '1.0 for Lion 2.6+';

$plugin->dependencies = array('calendartype_gregorian' => ANY_VERSION);
$plugin->maturity   = MATURITY_RC;
