<?php

/**
 * Report settings
 *
 * @package    report
 * @subpackage courseoverview
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('reports', new admin_externalpage('reportcourseoverview', get_string('pluginname', 'report_courseoverview'), "$CFG->wwwroot/report/courseoverview/index.php",'report/courseoverview:view', empty($CFG->enablestats)));

// no report settings
$settings = null;
