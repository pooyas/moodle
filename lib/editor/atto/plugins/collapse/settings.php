<?php


/**
 * Settings that allow configuration of the list of tex examples in the equation editor.
 *
 * @package    editor
 * @subpackage atto
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$ADMIN->add('editoratto', new admin_category('atto_collapse', new lang_string('pluginname', 'atto_collapse')));

$settings = new admin_settingpage('atto_collapse_settings', new lang_string('settings', 'atto_collapse'));
if ($ADMIN->fulltree) {
    // Number of groups to show when collapsed.
    $name = new lang_string('showgroups', 'atto_collapse');
    $desc = new lang_string('showgroups_desc', 'atto_collapse');
    $default = 5;
    $options = array_combine(range(1, 20), range(1, 20));

    $setting = new admin_setting_configselect('atto_collapse/showgroups',
                                              $name,
                                              $desc,
                                              $default,
                                              $options);
    $settings->add($setting);
}
