<?php

/**
 * IMS CP module admin settings and defaults
 *
 * @package mod
 * @subpackage imscp
 * @copyright  2015 Pooya Saeedi  
 * 
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // General settings.
    $settings->add(new admin_setting_configcheckbox('imscp/requiremodintro', get_string('requiremodintro', 'admin'),
                                        get_string('configrequiremodintro', 'admin'), 0));

    // Modedit defaults.
    $settings->add(new admin_setting_heading('imscpmodeditdefaults',
                                             get_string('modeditdefaults', 'admin'),
                                             get_string('condifmodeditdefaults', 'admin')));
    $options = array('-1' => get_string('all'), '0' => get_string('no'),
                     '1' => '1', '2' => '2', '5' => '5', '10' => '10', '20' => '20');
    $settings->add(new admin_setting_configselect_with_advanced('imscp/keepold',
        get_string('keepold', 'imscp'), get_string('keepoldexplain', 'imscp'),
        array('value' => 1, 'adv' => false), $options));
}
