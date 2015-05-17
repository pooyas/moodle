<?php


/**
 * Settings and links
 *
 * @package    report
 * @subpackage performance
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('reports', new admin_externalpage('reportperformance', get_string('pluginname', 'report_performance'),
        $CFG->wwwroot."/report/performance/index.php", 'report/performance:view'));

// No report settings.
$settings = null;
