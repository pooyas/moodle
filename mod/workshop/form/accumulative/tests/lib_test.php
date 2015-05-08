<?php

/**
 * Unit tests for Accumulative grading strategy logic
 *
 * @package    workshopform_accumulative
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

// Include the code to test
global $CFG;
require_once($CFG->dirroot . '/mod/workshop/locallib.php');
require_once($CFG->dirroot . '/mod/workshop/form/accumulative/lib.php');


class workshop_accumulative_strategy_testcase extends advanced_testcase {
    /** workshop instance emulation */
    protected $workshop;

    /** @var testable_workshop_accumulative_strategy instance of the strategy logic class being tested */
    protected $strategy;

    /**
     * Setup testing environment
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest();
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course();
        $workshop = $this->getDataGenerator()->create_module('workshop', array('strategy' => 'accumulative', 'course' => $course));
        $cm = get_fast_modinfo($course)->instances['workshop'][$workshop->id];
        $this->workshop = new workshop($workshop, $cm, $course);
        $this->strategy = new testable_workshop_accumulative_strategy($this->workshop);
    }

    protected function tearDown() {
        $this->workshop = null;
        $this->strategy = null;
        parent::tearDown();
    }

    public function test_calculate_peer_grade_null_grade() {
        // fixture set-up
        $this->strategy->dimensions = array();
        $grades = array();
        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);
        // validate
        $this->assertNull($suggested);
    }

    public function test_calculate_peer_grade_one_numerical() {
        // fixture set-up
        $this->strategy->dimensions[1003] = (object)array('grade' => '20', 'weight' => '1');
        $grades[] = (object)array('dimensionid' => 1003, 'grade' => '5.00000');
        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);
        // validate
        $this->assertEquals(grade_floatval(5/20 * 100), $suggested);
    }

    public function test_calculate_peer_grade_negative_weight() {
        // fixture set-up
        $this->strategy->dimensions[1003] = (object)array('grade' => '20', 'weight' => '-1');
        $grades[] = (object)array('dimensionid' => 1003, 'grade' => '20');
        $this->setExpectedException('coding_exception');
        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);
    }

    public function test_calculate_peer_grade_one_numerical_weighted() {
        // fixture set-up
        $this->strategy->dimensions[1003] = (object)array('grade' => '20', 'weight' => '3');
        $grades[] = (object)array('dimensionid' => '1003', 'grade' => '5');
        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);
        // validate
        $this->assertEquals(grade_floatval(5/20 * 100), $suggested);
    }

    public function test_calculate_peer_grade_three_numericals_same_weight() {
        // fixture set-up
        $this->strategy->dimensions[1003] = (object)array('grade' => '20', 'weight' => '2');
        $this->strategy->dimensions[1004] = (object)array('grade' => '100', 'weight' => '2');
        $this->strategy->dimensions[1005] = (object)array('grade' => '10', 'weight' => '2');
        $grades[] = (object)array('dimensionid' => 1003, 'grade' => '11.00000');
        $grades[] = (object)array('dimensionid' => 1004, 'grade' => '87.00000');
        $grades[] = (object)array('dimensionid' => 1005, 'grade' => '10.00000');

        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);

        // validate
        $this->assertEquals(grade_floatval((11/20 + 87/100 + 10/10)/3 * 100), $suggested);
    }

    public function test_calculate_peer_grade_three_numericals_different_weights() {
        // fixture set-up
        $this->strategy->dimensions[1003] = (object)array('grade' => '15', 'weight' => 3);
        $this->strategy->dimensions[1004] = (object)array('grade' => '80', 'weight' => 1);
        $this->strategy->dimensions[1005] = (object)array('grade' => '5', 'weight' => 2);
        $grades[] = (object)array('dimensionid' => 1003, 'grade' => '7.00000');
        $grades[] = (object)array('dimensionid' => 1004, 'grade' => '66.00000');
        $grades[] = (object)array('dimensionid' => 1005, 'grade' => '4.00000');

        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);

        // validate
        $this->assertEquals(grade_floatval((7/15*3 + 66/80*1 + 4/5*2)/6 * 100), $suggested);
    }

    public function test_calculate_peer_grade_one_scale_max() {
        $this->resetAfterTest(true);

        // fixture set-up
        $scale11 = $this->getDataGenerator()->create_scale(array('scale'=>'E,D,C,B,A', 'id'=>11));
        $this->strategy->dimensions[1008] = (object)array('grade' => (-$scale11->id), 'weight' => 1);
        $grades[] = (object)array('dimensionid' => 1008, 'grade' => '5.00000');

        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);

        // validate
        $this->assertEquals(100.00000, $suggested);
    }

    public function test_calculate_peer_grade_one_scale_min_with_scale_caching() {
        $this->resetAfterTest(true);

        // fixture set-up
        $scale11 = $this->getDataGenerator()->create_scale(array('scale'=>'E,D,C,B,A', 'id'=>11));
        $this->strategy->dimensions[1008] = (object)array('grade' => (-$scale11->id), 'weight' => 1);
        $grades[] = (object)array('dimensionid' => 1008, 'grade' => '1.00000');

        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);

        // validate
        $this->assertEquals(0.00000, $suggested);
    }

    public function test_calculate_peer_grade_two_scales_weighted() {
        $this->resetAfterTest(true);
        // fixture set-up
        $scale13 = $this->getDataGenerator()->create_scale(array('scale'=>'Poor,Good,Excellent', 'id'=>13));
        $scale17 = $this->getDataGenerator()->create_scale(array('scale'=>'-,*,**,***,****,*****,******', 'id'=>17));
        $this->strategy->dimensions[1012] = (object)array('grade' => (-$scale13->id), 'weight' => 2);
        $this->strategy->dimensions[1019] = (object)array('grade' => (-$scale17->id), 'weight' => 3);
        $grades[] = (object)array('dimensionid' => 1012, 'grade' => '2.00000'); // "Good"
        $grades[] = (object)array('dimensionid' => 1019, 'grade' => '5.00000'); // "****"

        // exercise SUT
        $suggested = $this->strategy->calculate_peer_grade($grades);

        // validate
        $this->assertEquals(grade_floatval((1/2*2 + 4/6*3)/5 * 100), $suggested);
    }

    public function test_calculate_peer_grade_scale_exception() {
        $this->resetAfterTest(true);
        // fixture set-up
        $scale13 = $this->getDataGenerator()->create_scale(array('scale'=>'Poor,Good,Excellent', 'id'=>13));
        $this->strategy->dimensions[1012] = (object)array('grade' => (-$scale13->id), 'weight' => 1);
        $grades[] = (object)array('dimensionid' => 1012, 'grade' => '4.00000'); // exceeds the number of scale items

        // exercise SUT
        $this->setExpectedException('coding_exception');
        $suggested = $this->strategy->calculate_peer_grade($grades);
    }
}


/**
 * Test subclass that makes all the protected methods we want to test public
 */
class testable_workshop_accumulative_strategy extends workshop_accumulative_strategy {

    /** allows to set dimensions manually */
    public $dimensions = array();

    /**
     * This is where the calculation of suggested grade for submission is done
     */
    public function calculate_peer_grade(array $grades) {
        return parent::calculate_peer_grade($grades);
    }
}
