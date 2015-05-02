<?php

/**
 * Serve question type files
 *
 * @since      Lion 2.0
 * @package    qtype_multichoice
 * @copyright  Dongsheng Cai <dongsheng@lion.com>
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Checks file access for multiple choice questions.
 *
 * @package  qtype_multichoice
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool
 */
function qtype_multichoice_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG;
    require_once($CFG->libdir . '/questionlib.php');
    question_pluginfile($course, $context, 'qtype_multichoice', $filearea, $args, $forcedownload, $options);
}
