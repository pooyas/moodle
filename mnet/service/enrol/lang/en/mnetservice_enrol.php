<?php



/**
 * @package    mnet
 * @subpackage service
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$string['availablecourseson'] = 'Available courses on {$a}';
$string['availablecoursesonnone'] = 'Remote host <a href="{$a->hosturl}">{$a->hostname}</a> does not offer any courses for our users.';
$string['clientname'] = 'Remote enrolments client';
$string['clientname_help'] = 'This tool allows you to enrol and unenrol your local users on remote hosts that allow you to do so via the \'MNet remote enrolments\' plugin.';
$string['editenrolments'] = 'Edit enrolments';
$string['hostappname'] = 'Application';
$string['hostname'] = 'Host name';
$string['hosturl'] = 'Remote host URL';
$string['nopublishers'] = 'No remote peers available.';
$string['noroamingusers'] = 'Users require the capability \'{$a}\' in the system context to be enrolled to remote courses, however there are currently no users with this capability. Click the continue button to assign the required capability to one or more roles on your site.';
$string['otherenrolledusers'] = 'Other enrolled users';
$string['pluginname'] = 'Remote enrolment service';
$string['refetch'] = 'Re-fetch up to date state from remote hosts';
