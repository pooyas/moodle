<?php


/**
 * Puts the plugin actions into the admin settings tree.
 *
 * @package     tool_installaddon
 * @copyright   2013 David Mudrak <david@lion.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

if ($hassiteconfig and empty($CFG->disableonclickaddoninstall)) {

    $ADMIN->add('modules', new admin_externalpage('tool_installaddon_index',
        get_string('installaddons', 'tool_installaddon'),
        "$CFG->wwwroot/$CFG->admin/tool/installaddon/index.php"), 'modsettings');

    $ADMIN->add('modules', new admin_externalpage('tool_installaddon_validate',
        get_string('validation', 'tool_installaddon'),
        "$CFG->wwwroot/$CFG->admin/tool/installaddon/validate.php",
        'lion/site:config',
        true), 'modsettings');
}
