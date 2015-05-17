<?php


/**
 * Jabber configuration page
 *
 * @package    message
 * @subpackage output
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('jabberhost', get_string('jabberhost', 'message_jabber'), get_string('configjabberhost', 'message_jabber'), '', PARAM_RAW));
    $settings->add(new admin_setting_configtext('jabberserver', get_string('jabberserver', 'message_jabber'), get_string('configjabberserver', 'message_jabber'), '', PARAM_RAW));
    $settings->add(new admin_setting_configtext('jabberusername', get_string('jabberusername', 'message_jabber'), get_string('configjabberusername', 'message_jabber'), '', PARAM_RAW));
    $settings->add(new admin_setting_configpasswordunmask('jabberpassword', get_string('jabberpassword', 'message_jabber'), get_string('configjabberpassword', 'message_jabber'), ''));
    $settings->add(new admin_setting_configtext('jabberport', get_string('jabberport', 'message_jabber'), get_string('configjabberport', 'message_jabber'), 5222, PARAM_INT));
}
