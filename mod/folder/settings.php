<?php


/**
 * Folder module admin settings and defaults
 *
 * @package   mod_folder
 * @copyright 2009 Petr Skoda  {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {
    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_configcheckbox('folder/requiremodintro',
        get_string('requiremodintro', 'admin'), get_string('configrequiremodintro', 'admin'), 0));

    $settings->add(new admin_setting_configcheckbox('folder/showexpanded',
            get_string('showexpanded', 'folder'),
            get_string('showexpanded_help', 'folder'), 1));
}
