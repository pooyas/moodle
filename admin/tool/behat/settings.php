<?php


/**
 * Adds behat tests link in admin tree
 *
 * @package    admin_tool
 * @subpackage behat
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

if ($hassiteconfig) {
    $url = $CFG->wwwroot . '/' . $CFG->admin . '/tool/behat/index.php';
    $ADMIN->add('development', new admin_externalpage('toolbehat', get_string('pluginname', 'tool_behat'), $url));
}
