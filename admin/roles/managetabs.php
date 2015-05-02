<?php

/**
 * Defines the tab bar used on the manage/allow assign/allow overrides pages.
 *
 * @package    core_role
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * 
 */

defined('LION_INTERNAL') || die();

$toprow = array();
$toprow[] = new tabobject('manage', new lion_url('/admin/roles/manage.php'), get_string('manageroles', 'core_role'));
$toprow[] = new tabobject('assign', new lion_url('/admin/roles/allow.php', array('mode'=>'assign')), get_string('allowassign', 'core_role'));
$toprow[] = new tabobject('override', new lion_url('/admin/roles/allow.php', array('mode'=>'override')), get_string('allowoverride', 'core_role'));
$toprow[] = new tabobject('switch', new lion_url('/admin/roles/allow.php', array('mode'=>'switch')), get_string('allowswitch', 'core_role'));

echo $OUTPUT->tabtree($toprow, $currenttab);

