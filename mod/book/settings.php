<?php

/**
 * Book plugin settings
 *
 * @package    mod_book
 * @copyright  2004-2011 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once(dirname(__FILE__).'/lib.php');

    // General settings

    $settings->add(new admin_setting_configcheckbox('book/requiremodintro',
        get_string('requiremodintro', 'admin'), get_string('configrequiremodintro', 'admin'), 0));

    $options = book_get_numbering_types();

    $settings->add(new admin_setting_configmultiselect('book/numberingoptions',
        get_string('numberingoptions', 'mod_book'), get_string('numberingoptions_desc', 'mod_book'),
        array_keys($options), $options));

    $navoptions = book_get_nav_types();
    $settings->add(new admin_setting_configmultiselect('book/navoptions',
        get_string('navoptions', 'mod_book'), get_string('navoptions_desc', 'mod_book'),
        array_keys($navoptions), $navoptions));

    // Modedit defaults.

    $settings->add(new admin_setting_heading('bookmodeditdefaults',
        get_string('modeditdefaults', 'admin'), get_string('condifmodeditdefaults', 'admin')));

    $settings->add(new admin_setting_configselect('book/numbering',
        get_string('numbering', 'mod_book'), '', BOOK_NUM_NUMBERS, $options));

    $settings->add(new admin_setting_configselect('book/navstyle',
        get_string('navstyle', 'mod_book'), '', BOOK_LINK_IMAGE, $navoptions));

}
