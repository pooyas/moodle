<?php



/**
 * This file replaces the legacy STATEMENTS section in db/install.xml,
 * lib.php/modulename_install() post installation hook and partially defaults.php
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * This is called at the beginning of the uninstallation process to give the module
 * a chance to clean-up its hacks, bits etc. where possible.
 *
 * @return bool true if success
 */
function mod_workshop_uninstall() {
    // global $DB;

    // $dbman = $DB->get_manager();

    return true;
}
