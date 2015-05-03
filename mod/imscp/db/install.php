<?php

/**
 * Post installation and migration code.
 *
 * This file replaces:
 *   - STATEMENTS section in db/install.xml
 *   - lib.php/modulename_install() post installation hook
 *   - partially defaults.php
 *
 * @package mod_imscp
 * @copyright  2009 Petr Skoda  
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Stub for database installation.
 */
function xmldb_imscp_install() {
    global $CFG;

}
