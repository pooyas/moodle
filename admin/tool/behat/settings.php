<?php

/**
 * Adds behat tests link in admin tree
 *
 * @package    tool_behat
 * @copyright  2012 David Monllaó
 * 
 */


defined('LION_INTERNAL') || die();

if ($hassiteconfig) {
    $url = $CFG->wwwroot . '/' . $CFG->admin . '/tool/behat/index.php';
    $ADMIN->add('development', new admin_externalpage('toolbehat', get_string('pluginname', 'tool_behat'), $url));
}
