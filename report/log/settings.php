<?php

/**
 * Links and settings
 *
 * Contains settings used by logs report.
 *
 * @package    report
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

// Just a link to course report.
$ADMIN->add('reports', new admin_externalpage('reportlog', get_string('log', 'admin'),
        $CFG->wwwroot . "/report/log/index.php?id=0", 'report/log:view'));

// No report settings.
$settings = null;
