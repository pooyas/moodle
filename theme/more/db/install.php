<?php

/**
 * Theme More install.
 *
 * @package    theme_more
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Theme_more install function.
 *
 * @return void
 */
function xmldb_theme_more_install() {
    global $CFG;

    // Set the default background.
    $fs = get_file_storage();

    $filerecord = new stdClass();
    $filerecord->component = 'theme_more';
    $filerecord->contextid = context_system::instance()->id;
    $filerecord->userid    = get_admin()->id;
    $filerecord->filearea  = 'backgroundimage';
    $filerecord->filepath  = '/';
    $filerecord->itemid    = 0;
    $filerecord->filename  = 'background.jpg';
    $fs->create_file_from_pathname($filerecord, $CFG->dirroot . '/theme/more/pix/background.jpg');
}
