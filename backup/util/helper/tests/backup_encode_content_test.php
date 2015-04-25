<?php

/**
 * @package     core
 * @subpackage backup
 * @category phpunit
 * @copyright   2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();


global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/moodle2/backup_course_task.class.php');



/**
 * Tests for encoding content links in backup_course_task.
 *
 * The code that this tests is acutally in backup/moodle2/backup_course_task.class.php,
 * but there is no place for unit tests near there, and perhaps one day it will
 * be refactored so it becomes more generic.
 */
class backup_course_task_testcase extends basic_testcase {

    /**
     * Test the encode_content_links method for course.
     */
    public function test_course_encode_content_links() {
        global $CFG;
        $encoded = backup_course_task::encode_content_links(
                $CFG->wwwroot . '/course/view.php?id=123, ' .
                $CFG->wwwroot . '/grade/index.php?id=123, ' .
                $CFG->wwwroot . '/grade/report/index.php?id=123, ' .
                $CFG->wwwroot . '/badges/view.php?type=2&id=123 and ' .
                $CFG->wwwroot . '/user/index.php?id=123.');
        $this->assertEquals('$@COURSEVIEWBYID*123@$, $@GRADEINDEXBYID*123@$, ' .
                '$@GRADEREPORTINDEXBYID*123@$, $@BADGESVIEWBYID*123@$ and $@USERINDEXVIEWBYID*123@$.', $encoded);
    }
}
