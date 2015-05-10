<?php

/**
 * Installation file for the wikimedia repository
 *
 * @package    repository
 * @subpackage wikimedia
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Create a default instance of the wikimedia repository
 *
 * @return bool A status indicating success or failure
 */
function xmldb_repository_wikimedia_install() {
    global $CFG;
    $result = true;
    require_once($CFG->dirroot.'/repository/lib.php');
    $wikimediaplugin = new repository_type('wikimedia', array(), true);
    if(!$id = $wikimediaplugin->create(true)) {
        $result = false;
    }
    return $result;
}
