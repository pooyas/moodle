<?php

/**
 * Book IMSCP export plugin
 *
 * @package    booktool
 * @subpackage exportimscp
 * @copyright  2015 Pooya Saeedi                   
 * 
 */

require(dirname(__FILE__).'/../../../../config.php');
require_once(dirname(__FILE__).'/locallib.php');
require_once($CFG->dirroot.'/mod/book/locallib.php');
require_once($CFG->libdir.'/filelib.php');

$id = required_param('id', PARAM_INT);           // Course Module ID

$cm = get_coursemodule_from_id('book', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);
$book = $DB->get_record('book', array('id'=>$cm->instance), '*', MUST_EXIST);

$PAGE->set_url('/mod/book/tool/exportimscp/index.php', array('id'=>$id));

require_login($course, false, $cm);

$context = context_module::instance($cm->id);
require_capability('mod/book:read', $context);
require_capability('booktool/exportimscp:export', $context);

\booktool_exportimscp\event\book_exported::create_from_book($book, $context)->trigger();

$file = booktool_exportimscp_build_package($book, $context);

send_stored_file($file, 10, 0, true, array('filename' => clean_filename($book->name).'.zip'));
