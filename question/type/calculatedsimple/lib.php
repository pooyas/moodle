<?php


/**
 * Serve question type files
 *
 * @package    question_type
 * @subpackage calculatedsimple
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Checks file access for simple calculated questions.
 *
 * @category files
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options additional options affecting the file serving
 * @return bool
 */
function qtype_calculatedsimple_pluginfile($course, $cm, $context, $filearea,
        $args, $forcedownload, array $options=array()) {
    global $CFG;
    require_once($CFG->libdir . '/questionlib.php');
    question_pluginfile($course, $context, 'qtype_calculatedsimple', $filearea,
            $args, $forcedownload, $options);
}
