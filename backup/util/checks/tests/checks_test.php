<?php


/**
 * @package    core_backup
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

// Include all the needed stuff
global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');


/*
 * check tests (all)
 */
class backup_check_testcase extends advanced_testcase {

    protected $moduleid;  // course_modules id used for testing
    protected $sectionid; // course_sections id used for testing
    protected $courseid;  // course id used for testing
    protected $userid;    // user record id

    protected function setUp() {
        global $DB, $CFG;
        parent::setUp();

        $this->resetAfterTest(true);

        $course = $this->getDataGenerator()->create_course(array(), array('createsections' => true));
        $page = $this->getDataGenerator()->create_module('page', array('course'=>$course->id), array('section'=>3));
        $coursemodule = $DB->get_record('course_modules', array('id'=>$page->cmid));

        $this->moduleid  = $coursemodule->id;
        $this->sectionid = $coursemodule->section;
        $this->courseid  = $coursemodule->course;
        $this->userid = 2; // admin

        $CFG->backup_error_log_logger_level = backup::LOG_NONE;
        $CFG->backup_output_indented_logger_level = backup::LOG_NONE;
        $CFG->backup_file_logger_level = backup::LOG_NONE;
        $CFG->backup_database_logger_level = backup::LOG_NONE;
        unset($CFG->backup_file_logger_extra);
        $CFG->backup_file_logger_level_extra = backup::LOG_NONE;
    }

    /*
     * test backup_check class
     */
    public function test_backup_check() {

        // Check against existing course module/section course or fail
        $this->assertTrue(backup_check::check_id(backup::TYPE_1ACTIVITY, $this->moduleid));
        $this->assertTrue(backup_check::check_id(backup::TYPE_1SECTION, $this->sectionid));
        $this->assertTrue(backup_check::check_id(backup::TYPE_1COURSE, $this->courseid));
        $this->assertTrue(backup_check::check_user($this->userid));

        // Check against non-existing course module/section/course (0)
        try {
            backup_check::check_id(backup::TYPE_1ACTIVITY, 0);
            $this->assertTrue(false, 'backup_controller_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof backup_controller_exception);
            $this->assertEquals($e->errorcode, 'backup_check_module_not_exists');
        }
        try {
            backup_check::check_id(backup::TYPE_1SECTION, 0);
            $this->assertTrue(false, 'backup_controller_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof backup_controller_exception);
            $this->assertEquals($e->errorcode, 'backup_check_section_not_exists');
        }
        try {
            backup_check::check_id(backup::TYPE_1COURSE, 0);
            $this->assertTrue(false, 'backup_controller_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof backup_controller_exception);
            $this->assertEquals($e->errorcode, 'backup_check_course_not_exists');
        }

        // Try wrong type
        try {
            backup_check::check_id(12345678,0);
            $this->assertTrue(false, 'backup_controller_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof backup_controller_exception);
            $this->assertEquals($e->errorcode, 'backup_check_incorrect_type');
        }

        // Test non-existing user
        $userid = 0;
        try {
            backup_check::check_user($userid);
            $this->assertTrue(false, 'backup_controller_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof backup_controller_exception);
            $this->assertEquals($e->errorcode, 'backup_check_user_not_exists');
        }

        // Security check tests
        // Try to pass wrong controller
        try {
            backup_check::check_security(new stdclass(), true);
            $this->assertTrue(false, 'backup_controller_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof backup_controller_exception);
            $this->assertEquals($e->errorcode, 'backup_check_security_requires_backup_controller');
        }

        // Pass correct controller, check must return true in any case with $apply enabled
        // and $bc must continue being mock_backup_controller
        $bc = new backup_controller(backup::TYPE_1ACTIVITY, $this->moduleid, backup::FORMAT_LION,
            backup::INTERACTIVE_NO, backup::MODE_GENERAL, $this->userid);
        $this->assertTrue(backup_check::check_security($bc, true));
        $this->assertTrue($bc instanceof backup_controller);

    }
}
