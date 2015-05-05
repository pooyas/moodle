<?php


/**
 * @package    core
 * @subpackage backup-factories
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Non instantiable factory class providing different restore object instances
 *
 * This class contains various methods available in order to easily
 * create different parts of the restore architecture in an easy way
 *
 * TODO: Finish phpdocs
 */
abstract class restore_factory {

    public static function get_restore_activity_task($info) {

        $classname = 'restore_' . $info->modulename . '_activity_task';
        if (class_exists($classname)) {
            return new $classname($info->title, $info);
        }
    }

    public static function get_restore_block_task($blockname, $basepath) {

        $classname = 'restore_default_block_task';
        $testname  = 'restore_' . $blockname . '_block_task';
        // If the block has custom backup/restore task class (testname), use it
        if (class_exists($testname)) {
            $classname = $testname;
        }
        return new $classname($blockname, $basepath);
    }

    public static function get_restore_section_task($info) {

        return new restore_section_task($info->title, $info);
    }

    public static function get_restore_course_task($info, $courseid) {
        global $DB;

        // Check course exists
        if (!$course = $DB->get_record('course', array('id' => $courseid))) {
            throw new restore_task_exception('course_task_course_not_found', $courseid);
        }

        return new restore_course_task($info->title, $info);
    }
}
