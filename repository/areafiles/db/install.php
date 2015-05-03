<?php

/**
 * Creating a default instance of areafiles repository on install
 *
 * @package    repository_areafiles
 * @copyright  2015 Pooya Saeedi
 * 
 */

function xmldb_repository_areafiles_install() {
    global $CFG;
    $result = true;
    require_once($CFG->dirroot.'/repository/lib.php');
    $areafiles_plugin = new repository_type('areafiles', array(), true);
    if(!$id = $areafiles_plugin->create(true)) {
        $result = false;
    }
    return $result;
}
