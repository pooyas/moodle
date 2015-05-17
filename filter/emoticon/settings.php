<?php



/**
 * @package    filter
 * @subpackage emoticon
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_configmulticheckbox('filter_emoticon/formats',
            get_string('settingformats', 'filter_emoticon'),
            get_string('settingformats_desc', 'filter_emoticon'),
            array(FORMAT_HTML => 1, FORMAT_MARKDOWN => 1, FORMAT_LION => 1), format_text_menu()));
}
