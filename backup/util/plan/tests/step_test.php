<?php


/**
 * @category   phpunit
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once(__DIR__.'/fixtures/plan_fixtures.php');


/*
 * step tests (all)
 */
class backup_step_testcase extends advanced_testcase {

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
     * test base_step class
     */
    function test_base_step() {

        $bp = new mock_base_plan('planname'); // We need one plan
        $bt = new mock_base_task('taskname', $bp); // We need one task
        // Instantiate
        $bs = new mock_base_step('stepname', $bt);
        $this->assertTrue($bs instanceof base_step);
        $this->assertEquals($bs->get_name(), 'stepname');
    }

    /**
     * test backup_step class
     */
    function test_backup_step() {

        // We need one (non interactive) controller for instatiating plan
        $bc = new backup_controller(backup::TYPE_1ACTIVITY, $this->moduleid, backup::FORMAT_LION,
            backup::INTERACTIVE_NO, backup::MODE_GENERAL, $this->userid);
        // We need one plan
        $bp = new backup_plan($bc);
        // We need one task
        $bt = new mock_backup_task('taskname', $bp);
        // Instantiate step
        $bs = new mock_backup_step('stepname', $bt);
        $this->assertTrue($bs instanceof backup_step);
        $this->assertEquals($bs->get_name(), 'stepname');

    }

    /**
     * test backup_structure_step class
     */
    function test_backup_structure_step() {
        global $CFG;

        $file = $CFG->tempdir . '/test/test_backup_structure_step.txt';
        // Remove the test dir and any content
        @remove_dir(dirname($file));
        // Recreate test dir
        if (!check_dir_exists(dirname($file), true, true)) {
            throw new lion_exception('error_creating_temp_dir', 'error', dirname($file));
        }

        // We need one (non interactive) controller for instatiating plan
        $bc = new backup_controller(backup::TYPE_1ACTIVITY, $this->moduleid, backup::FORMAT_LION,
            backup::INTERACTIVE_NO, backup::MODE_GENERAL, $this->userid);
        // We need one plan
        $bp = new backup_plan($bc);
        // We need one task with mocked basepath
        $bt = new mock_backup_task_basepath('taskname');
        $bp->add_task($bt);
        // Instantiate backup_structure_step (and add it to task)
        $bs = new mock_backup_structure_step('steptest', basename($file), $bt);
        // Execute backup_structure_step
        $bs->execute();

        // Test file has been created
        $this->assertTrue(file_exists($file));

        // Some simple tests with contents
        $contents = file_get_contents($file);
        $this->assertTrue(strpos($contents, '<?xml version="1.0"') !== false);
        $this->assertTrue(strpos($contents, '<test id="1">') !== false);
        $this->assertTrue(strpos($contents, '<field1>value1</field1>') !== false);
        $this->assertTrue(strpos($contents, '<field2>value2</field2>') !== false);
        $this->assertTrue(strpos($contents, '</test>') !== false);

        unlink($file); // delete file

        // Remove the test dir and any content
        @remove_dir(dirname($file));
    }

    /**
     * wrong base_step class tests
     */
    function test_base_step_wrong() {

        // Try to pass one wrong task
        try {
            $bt = new mock_base_step('teststep', new stdclass());
            $this->assertTrue(false, 'base_step_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof base_step_exception);
            $this->assertEquals($e->errorcode, 'wrong_base_task_specified');
        }
    }

    /**
     * wrong backup_step class tests
     */
    function test_backup_test_wrong() {

        // Try to pass one wrong task
        try {
            $bt = new mock_backup_step('teststep', new stdclass());
            $this->assertTrue(false, 'backup_step_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof backup_step_exception);
            $this->assertEquals($e->errorcode, 'wrong_backup_task_specified');
        }
    }
}
