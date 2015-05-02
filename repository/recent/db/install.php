<?php


function xmldb_repository_recent_install() {
    global $CFG;
    $result = true;
    require_once($CFG->dirroot.'/repository/lib.php');
    $recent_plugin = new repository_type('recent', array(), true);
    if(!$id = $recent_plugin->create(true)) {
        $result = false;
    }
    return $result;
}
