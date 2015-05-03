<?php

/**
 * Settings and links
 *
 * @package    report
 * @subpackage security
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('reports', new admin_externalpage('reportsecurity', get_string('pluginname', 'report_security'), "$CFG->wwwroot/report/security/index.php",'report/security:view'));

// no report settings
$settings = null;
