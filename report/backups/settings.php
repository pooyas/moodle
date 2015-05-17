<?php


/**
 * Settings for the backups report
 *
 * @package    report
 * @subpackage backups
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('reports', new admin_externalpage('reportbackups', get_string('backups', 'admin'), "$CFG->wwwroot/report/backups/index.php",'lion/backup:backupcourse'));

// no report settings
$settings = null;