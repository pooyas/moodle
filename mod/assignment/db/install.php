<?php

/**
 * Disable the assignment module for new installs
 *
 * @package mod_assignment
 * @copyright 2015 Pooya Saeedi {@link http://www.netspot.com.au}
 * 
 */
defined('LION_INTERNAL') || die();


/**
 * Code run after the mod_assignment module database tables have been created.
 * Disables this plugin for new installs
 * @return bool
 */
function xmldb_assignment_install() {
    global $DB;

    // do the install
    $DB->set_field('modules', 'visible', '0', array('name'=>'assignment')); // Hide main module

    // Should not need to modify course modinfo because this is a new install

    return true;
}


