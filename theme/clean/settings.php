<?php


/**
 * Lion's Clean theme, an example of how to make a Bootstrap theme
 *
 * DO NOT MODIFY THIS THEME!
 * COPY IT FIRST, THEN RENAME THE COPY AND MODIFY IT INSTEAD.
 *
 * For full information about creating Lion themes, see:
 * http://docs.lion.org/dev/Themes_2.0
 *
 * @package    theme
 * @subpackage clean
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Invert Navbar to dark background.
    $name = 'theme_clean/invert';
    $title = get_string('invert', 'theme_clean');
    $description = get_string('invertdesc', 'theme_clean');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Logo file setting.
    $name = 'theme_clean/logo';
    $title = get_string('logo','theme_clean');
    $description = get_string('logodesc', 'theme_clean');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Custom CSS file.
    $name = 'theme_clean/customcss';
    $title = get_string('customcss', 'theme_clean');
    $description = get_string('customcssdesc', 'theme_clean');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Footnote setting.
    $name = 'theme_clean/footnote';
    $title = get_string('footnote', 'theme_clean');
    $description = get_string('footnotedesc', 'theme_clean');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
}
