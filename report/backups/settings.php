<?php

/**
 * Settings for the backups report
 *
 * @package    report
 * @subpackage backups
 * @copyright  2007 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('reports', new admin_externalpage('reportbackups', get_string('backups', 'admin'), "$CFG->wwwroot/report/backups/index.php",'lion/backup:backupcourse'));

// no report settings
$settings = null;