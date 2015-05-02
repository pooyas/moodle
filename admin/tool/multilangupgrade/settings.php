<?php

/**
 * Link to multilang upgrade script.
 *
 * @package    tool
 * @subpackage multilangupgrade
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    // Hidden multilang upgrade page - show in settings root to get more attention.
    $ADMIN->add('root', new admin_externalpage('toolmultilangupgrade', get_string('pluginname', 'tool_multilangupgrade'), $CFG->wwwroot.'/'.$CFG->admin.'/tool/multilangupgrade/index.php', 'lion/site:config', !empty($CFG->filter_multilang_converted)));
}
