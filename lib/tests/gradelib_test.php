<?php


/**
 * Unit tests for /lib/gradelib.php.
 *
 * @category  phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/gradelib.php');

class core_gradelib_testcase extends advanced_testcase {

    public function test_grade_update_mod_grades() {

        $this->resetAfterTest(true);

        // Create a broken module instance.
        $modinstance = new stdClass();
        $modinstance->modname = 'doesntexist';

        $this->assertFalse(grade_update_mod_grades($modinstance));
        // A debug message should have been generated.
        $this->assertDebuggingCalled();

        // Create a course and instance of mod_assign.
        $course = $this->getDataGenerator()->create_course();

        $assigndata['course'] = $course->id;
        $assigndata['name'] = 'lightwork assignment';
        $modinstance = self::getDataGenerator()->create_module('assign', $assigndata);

        // Function grade_update_mod_grades() requires 2 additional properties, cmidnumber and modname.
        $cm = get_coursemodule_from_instance('assign', $modinstance->id, 0, false, MUST_EXIST);
        $modinstance->cmidnumber = $cm->id;
        $modinstance->modname = 'assign';

        $this->assertTrue(grade_update_mod_grades($modinstance));
    }
}
