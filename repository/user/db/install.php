<?php




/**
 * @package    repository
 * @subpackage user
 * @copyright  2015 Pooya Saeedi
*/

function xmldb_repository_user_install() {
    global $CFG;
    $result = true;
    require_once($CFG->dirroot.'/repository/lib.php');
    $user_plugin = new repository_type('user', array(), true);
    if(!$id = $user_plugin->create(true)) {
        $result = false;
    }
    return $result;
}
