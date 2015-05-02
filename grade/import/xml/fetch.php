<?php


define('NO_LION_COOKIES', true); // session not used here
require_once '../../../config.php';

$id = required_param('id', PARAM_INT); // course id
if (!$course = $DB->get_record('course', array('id'=>$id))) {
    print_error('nocourseid');
}

require_user_key_login('grade/import', $id); // we want different keys for each course

if (empty($CFG->gradepublishing)) {
    print_error('gradepubdisable');
}

$context = context_course::instance($id);
require_capability('gradeimport/xml:publish', $context);

// use the same page parameters as import.php and append &key=sdhakjsahdksahdkjsahksadjksahdkjsadhksa
require 'import.php';


