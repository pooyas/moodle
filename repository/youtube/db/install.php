<?php

/**
 * Installation file for the Youtube repository.
 *
 * @package    repository
 * @subpackage youtube
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Create a default instance of the youtube repository
 *
 * @return bool A status indicating success or failure
 */
function xmldb_repository_youtube_install() {
    global $CFG;
    $result = true;
    require_once($CFG->dirroot.'/repository/lib.php');
    $youtubeplugin = new repository_type('youtube', array(), true);
    if(!$id = $youtubeplugin->create(true)) {
        $result = false;
    }
    return $result;
}
