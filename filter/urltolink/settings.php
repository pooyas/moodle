<?php


/**
 * @package    plugintype
 * @subpackage pluginname
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_configmulticheckbox('filter_urltolink/formats',
            get_string('settingformats', 'filter_urltolink'),
            get_string('settingformats_desc', 'filter_urltolink'),
            array(FORMAT_LION => 1), format_text_menu()));

    $settings->add(new admin_setting_configcheckbox('filter_urltolink/embedimages',
            get_string('embedimages', 'filter_urltolink'),
            get_string('embedimages_desc', 'filter_urltolink'),
            1));
}
