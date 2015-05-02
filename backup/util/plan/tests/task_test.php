<?php

/**
 * @package    core_backup
 * @category   phpunit
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

defined('LION_INTERNAL') || die();

require_once(__DIR__.'/fixtures/plan_fixtures.php');


/**
 * task tests (all)
 */
class backup_task_testcase extends advanced_testcase {

    protected $moduleid;  // course_modules id used for testing
    protected $sectionid; // course_sections id used for testing
    protected $courseid;  // course id used for testing
    protected $userid;      // user record used for testing

    protected function setUp() {
        global $DB, $CFG;
        parent::setUp();

        $this->resetAfterTest(true);

        $course = $this->getDataGenerator()->create_course();
        $page = $this->getDataGenerator()->create_module('page', array('course'=>$course->id), array('section'=>3));
        $coursemodule = $DB->get_record('course_modules', array('id'=>$page->cmid));

        $this->moduleid  = $coursemodule->id;
        $this->sectionid = $DB->get_field("course_sections", 'id', array("section"=>$coursemodule->section, "course"=>$course->id));
        $this->courseid  = $coursemodule->course;
        $this->userid = 2; // admin

        // Disable all loggers
        $CFG->backup_error_log_logger_level = backup::LOG_NONE;
        $CFG->backup_file_logger_level = backup::LOG_NONE;
        $CFG->backup_database_logger_level = backup::LOG_NONE;
        $CFG->backup_file_logger_level_extra = backup::LOG_NONE;
    }

    /**
     * test base_task class
     */
    function test_base_task() {

        $bp = new mock_base_plan('planname'); // We need one plan
        // Instantiate
        $bt = new mock_base_task('taskname', $bp);
        $this->assertTrue($bt instanceof base_task);
        $this->assertEquals($bt->get_name(), 'taskname');
        $this->assertTrue(is_array($bt->get_settings()));
        $this->assertEquals(count($bt->get_settings()), 0);
        $this->assertTrue(is_array($bt->get_steps()));
        $this->assertEquals(count($bt->get_steps()), 0);
    }

    /**
     * test backup_task class
     */
    function test_backup_task() {

        // We need one (non interactive) controller for instatiating plan
        $bc = new backup_controller(backup::TYPE_1ACTIVITY, $this->moduleid, backup::FORMAT_LION,
            backup::INTERACTIVE_NO, backup::MODE_GENERAL, $this->userid);
        // We need one plan
        $bp = new backup_plan($bc);
        // Instantiate task
        $bt = new mock_backup_task('taskname', $bp);
        $this->assertTrue($bt instanceof backup_task);
        $this->assertEquals($bt->get_name(), 'taskname');

        // Calculate checksum and check it
        $checksum = $bt->calculate_checksum();
        $this->assertTrue($bt->is_checksum_correct($checksum));

    }

    /**
     * wrong base_task class tests
     */
    function test_base_task_wrong() {

        // Try to pass one wrong plan
        try {
            $bt = new mock_base_task('tasktest', new stdclass());
            $this->assertTrue(false, 'base_task_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof base_task_exception);
            $this->assertEquals($e->errorcode, 'wrong_base_plan_specified');
        }

        // Add wrong step to task
        $bp = new mock_base_plan('planname'); // We need one plan
        // Instantiate
        $bt = new mock_base_task('taskname', $bp);
        try {
            $bt->add_step(new stdclass());
            $this->assertTrue(false, 'base_task_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof base_task_exception);
            $this->assertEquals($e->errorcode, 'wrong_base_step_specified');
        }

    }

    /**
     * wrong backup_task class tests
     */
    function test_backup_task_wrong() {

        // Try to pass one wrong plan
        try {
            $bt = new mock_backup_task('tasktest', new stdclass());
            $this->assertTrue(false, 'backup_task_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof backup_task_exception);
            $this->assertEquals($e->errorcode, 'wrong_backup_plan_specified');
        }
    }
}
