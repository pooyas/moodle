<?php

/**
 * Unit tests for Rubric grading strategy logic
 *
 * @package    workshopform_rubric
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

// Include the code to test
global $CFG;
require_once($CFG->dirroot . '/mod/workshop/locallib.php');
require_once($CFG->dirroot . '/mod/workshop/form/rubric/lib.php');


class workshopform_rubric_strategy_test extends advanced_testcase {

    /** workshop instance emulation */
    protected $workshop;

    /** instance of the strategy logic class being tested */
    protected $strategy;

    /**
     * Setup testing environment
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest();
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course();
        $workshop = $this->getDataGenerator()->create_module('workshop', array('strategy' => 'rubric', 'course' => $course));
        $cm = get_fast_modinfo($course)->instances['workshop'][$workshop->id];
        $this->workshop = new workshop($workshop, $cm, $course);
        $this->strategy = new testable_workshop_rubric_strategy($this->workshop);

        // prepare dimensions definition
        $dim = new stdclass();
        $dim->id = 6;
        $dim->levels[10] = (object)array('id' => 10, 'grade' => 0);
        $dim->levels[13] = (object)array('id' => 13, 'grade' => 2);
        $dim->levels[14] = (object)array('id' => 14, 'grade' => 6);
        $dim->levels[16] = (object)array('id' => 16, 'grade' => 8);
        $this->strategy->dimensions[$dim->id] = $dim;

        $dim = new stdclass();
        $dim->id = 8;
        $dim->levels[17] = (object)array('id' => 17, 'grade' => 0);
        $dim->levels[18] = (object)array('id' => 18, 'grade' => 1);
        $dim->levels[19] = (object)array('id' => 19, 'grade' => 2);
        $dim->levels[20] = (object)array('id' => 20, 'grade' => 3);
        $this->strategy->dimensions[$dim->id] = $dim;

        $dim = new stdclass();
        $dim->id = 10;
        $dim->levels[27] = (object)array('id' => 27, 'grade' => 10);
        $dim->levels[28] = (object)array('id' => 28, 'grade' => 20);
        $dim->levels[29] = (object)array('id' => 29, 'grade' => 30);
        $dim->levels[30] = (object)array('id' => 30, 'grade' => 40);
        $this->strategy->dimensions[$dim->id] = $dim;

    }

    protected function tearDown() {
        $this->strategy = null;
        $this->workshop = null;
        parent::tearDown();
    }

    public function test_calculate_peer_grade_null_grade() {
        // fixture set-up
        $grades = array();
        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);
        // validate
        $this->assertNull($suggested);
    }

    public function test_calculate_peer_grade_worst_possible() {
        // fixture set-up
        $grades[6] = (object)array('dimensionid' => 6, 'grade' => 0);
        $grades[8] = (object)array('dimensionid' => 8, 'grade' => 0);
        $grades[10] = (object)array('dimensionid' => 10, 'grade' => 10);
        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);
        // validate
        $this->assertEquals(grade_floatval($suggested), 0.00000);
    }

    public function test_calculate_peer_grade_best_possible() {
        // fixture set-up
        $grades[6] = (object)array('dimensionid' => 6, 'grade' => 8);
        $grades[8] = (object)array('dimensionid' => 8, 'grade' => 3);
        $grades[10] = (object)array('dimensionid' => 10, 'grade' => 40);
        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);
        // validate
        $this->assertEquals(grade_floatval($suggested), 100.00000);
    }

    public function test_calculate_peer_grade_something() {
        // fixture set-up
        $grades[6] = (object)array('dimensionid' => 6, 'grade' => 2);
        $grades[8] = (object)array('dimensionid' => 8, 'grade' => 2);
        $grades[10] = (object)array('dimensionid' => 10, 'grade' => 30);
        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);
        // validate
        // minimal rubric score is 10, maximal is 51. We have 34 here
        $this->assertEquals(grade_floatval($suggested), grade_floatval(100 * 24 / 41));
    }
}


/**
 * Test subclass that makes all the protected methods we want to test public
 */
class testable_workshop_rubric_strategy extends workshop_rubric_strategy {

    /** allows to set dimensions manually */
    public $dimensions = array();

    /**
     * This is where the calculation of suggested grade for submission is done
     */
    public function calculate_peer_grade(array $grades) {
        return parent::calculate_peer_grade($grades);
    }
}
