<?php


/**
 * This script fetches legacy course files in dataroot directory, it is enabled
 * only if course->legacyfiles == 2. DO not link to this file in new code.
 *
 * Syntax:      file.php/courseid/dir/dir/dir/filename.ext
 *              file.php/courseid/dir/dir/dir/filename.ext?forcedownload=1 (download instead of inline)
 *              file.php/courseid/dir (returns index.html from dir)
 * Workaround:  file.php?file=/courseid/dir/dir/dir/filename.ext
 *
 * @package    core
 * @subpackage file
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * 
 */

// disable lion specific debug messages and any errors in output
define('NO_DEBUG_DISPLAY', true);

require_once('config.php');
require_once('lib/filelib.php');

$relativepath  = get_file_argument();
$forcedownload = optional_param('forcedownload', 0, PARAM_BOOL);

// relative path must start with '/', because of backup/restore!!!
if (!$relativepath) {
    print_error('invalidargorconf');
} else if ($relativepath{0} != '/') {
    print_error('pathdoesnotstartslash');
}

// extract relative path components
$args = explode('/', ltrim($relativepath, '/'));

if (count($args) == 0) { // always at least courseid, may search for index.html in course root
    print_error('invalidarguments');
}

$courseid = (int)array_shift($args);
$relativepath = implode('/', $args);

// security: limit access to existing course subdirectories
$course = $DB->get_record('course', array('id'=>$courseid), '*', MUST_EXIST);

if ($course->legacyfiles != 2) {
    // course files disabled
    send_file_not_found();
}

if ($course->id != SITEID) {
    require_login($course, true, null, false);

} else if ($CFG->forcelogin) {
    if (!empty($CFG->sitepolicy)
        and ($CFG->sitepolicy == $CFG->wwwroot.'/file.php/'.$relativepath
             or $CFG->sitepolicy == $CFG->wwwroot.'/file.php?file=/'.$relativepath)) {
        //do not require login for policy file
    } else {
        require_login(0, true, null, false);
    }
}

$context = context_course::instance($course->id);

$fs = get_file_storage();

$fullpath = "/$context->id/course/legacy/0/$relativepath";

if (!$file = $fs->get_file_by_hash(sha1($fullpath))) {
    if (strrpos($fullpath, '/') !== strlen($fullpath) -1 ) {
        $fullpath .= '/';
    }
    // Try to fallback to the directory named as the supposed file.
    if (!$file = $fs->get_file_by_hash(sha1($fullpath.'.'))) {
        send_file_not_found();
    }
}
// do not serve dirs
if ($file->get_filename() == '.') {
    if (!$file = $fs->get_file_by_hash(sha1($fullpath.'index.html'))) {
        if (!$file = $fs->get_file_by_hash(sha1($fullpath.'index.htm'))) {
            if (!$file = $fs->get_file_by_hash(sha1($fullpath.'Default.htm'))) {
                send_file_not_found();
            }
        }
    }
}

// ========================================
// finally send the file
// ========================================
\core\session\manager::write_close(); // Unlock session during file serving.
send_stored_file($file, null, $CFG->filteruploadedfiles, $forcedownload);


