<?php


/**
 * Installation for the URL repository
 *
 * @category   repository
 * @package    repository
 * @subpackage url
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Create a default instance of the URL repository
 *
 * @return bool A status indicating success or failure
 */
function xmldb_repository_url_install() {
    global $CFG;
    $result = true;
    require_once($CFG->dirroot.'/repository/lib.php');
    $urlplugin = new repository_type('url', array(), true);
    if(!$id = $urlplugin->create(true)) {
        $result = false;
    }
    return $result;
}
