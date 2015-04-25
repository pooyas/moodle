<?php

/**
 * Defines the tab bar used on the manage/allow assign/allow overrides pages.
 *
 * @package    core_role
 * @copyright  2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

$toprow = array();
$toprow[] = new tabobject('manage', new moodle_url('/admin/roles/manage.php'), get_string('manageroles', 'core_role'));
$toprow[] = new tabobject('assign', new moodle_url('/admin/roles/allow.php', array('mode'=>'assign')), get_string('allowassign', 'core_role'));
$toprow[] = new tabobject('override', new moodle_url('/admin/roles/allow.php', array('mode'=>'override')), get_string('allowoverride', 'core_role'));
$toprow[] = new tabobject('switch', new moodle_url('/admin/roles/allow.php', array('mode'=>'switch')), get_string('allowswitch', 'core_role'));

echo $OUTPUT->tabtree($toprow, $currenttab);

