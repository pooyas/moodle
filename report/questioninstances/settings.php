<?php

/**
 * Settings and links
 *
 * @package    report
 * @subpackage questioninstances
 * @copyright  2008 Tim Hunt
 * 
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('reports', new admin_externalpage('reportquestioninstances', get_string('pluginname', 'report_questioninstances'), "$CFG->wwwroot/report/questioninstances/index.php", 'report/questioninstances:view'));

// no report settings
$settings = null;
