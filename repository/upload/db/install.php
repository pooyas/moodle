<?php




/**
 * @package    repository
 * @subpackage upload
 * @copyright  2015 Pooya Saeedi
*/

function xmldb_repository_upload_install() {
    global $CFG;
    $result = true;
    require_once($CFG->dirroot.'/repository/lib.php');
    $upload_plugin = new repository_type('upload', array(), true);
    if (!$id = $upload_plugin->create(true)) {
        $result = false;
    }
    return $result;
}
