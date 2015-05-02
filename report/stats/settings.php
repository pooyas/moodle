<?php

/**
 * Version info
 *
 * @package    report
 * @subpackage stats
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * 
 */

defined('LION_INTERNAL') || die;

// just a link to course report
$ADMIN->add('reports', new admin_externalpage('reportstats', get_string('pluginname', 'report_stats'), "$CFG->wwwroot/report/stats/index.php", 'report/stats:view', empty($CFG->enablestats)));

// no report settings
$settings = null;
