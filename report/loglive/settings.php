<?php

/**
 * Links and settings
 *
 * This file contains links and settings used by report_loglive
 *
 * @package    report_loglive
 * @copyright  2011 Petr Skoda
 * 
 */

defined('LION_INTERNAL') || die;

// Just a link to course report.
$ADMIN->add('reports', new admin_externalpage('reportloglive', get_string('pluginname', 'report_loglive'),
        "$CFG->wwwroot/report/loglive/index.php", 'report/loglive:view'));

// No report settings.
$settings = null;
