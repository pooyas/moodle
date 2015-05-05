<?php

/**
 * Unit tests for forms lib.
 *
 * This file contains all unit test related to forms library.
 *
 * @package    core_form
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/form/duration.php');

/**
 * Unit tests for LionQuickForm_duration
 *
 * Contains test cases for testing LionQuickForm_duration
 *
 * @package    core_form
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */
class core_form_duration_testcase extends basic_testcase {
    /** @var LionQuickForm_duration Keeps reference of LionQuickForm_duration object */
    private $element;

    /**
     * Initalize test wide variable, it is called in start of the testcase
     */
    protected function setUp() {
        parent::setUp();
        $this->element = new LionQuickForm_duration();
    }

    /**
     * Clears the data set in the setUp() method call.
     * @see duration_form_element_test::setUp()
     */
    protected function tearDown() {
        $this->element = null;
    }

    /**
     * Testcase for testing contructor.
     * @expectedException coding_exception
     * @retrun void
     */
    public function test_constructor() {
        // Test trying to create with an invalid unit.
        $this->element = new LionQuickForm_duration('testel', null, array('defaultunit' => 123));
    }

    /**
     * Testcase for testing units (seconds, minutes, hours and days)
     */
    public function test_get_units() {
        $units = $this->element->get_units();
        ksort($units);
        $this->assertEquals($units, array(1 => get_string('seconds'), 60 => get_string('minutes'),
            3600 => get_string('hours'), 86400 => get_string('days'), 604800 => get_string('weeks')));
    }

    /**
     * Testcase for testing conversion of seconds to the best possible unit
     */
    public function test_seconds_to_unit() {
        $this->assertEquals(array(0, 60), $this->element->seconds_to_unit(0)); // Zero minutes, for a nice default unit.
        $this->assertEquals(array(1, 1), $this->element->seconds_to_unit(1));
        $this->assertEquals(array(3601, 1), $this->element->seconds_to_unit(3601));
        $this->assertEquals(array(1, 60), $this->element->seconds_to_unit(60));
        $this->assertEquals(array(3, 60), $this->element->seconds_to_unit(180));
        $this->assertEquals(array(1, 3600), $this->element->seconds_to_unit(3600));
        $this->assertEquals(array(2, 3600), $this->element->seconds_to_unit(7200));
        $this->assertEquals(array(1, 86400), $this->element->seconds_to_unit(86400));
        $this->assertEquals(array(25, 3600), $this->element->seconds_to_unit(90000));

        $this->element = new LionQuickForm_duration('testel', null, array('defaultunit' => 86400));
        $this->assertEquals(array(0, 86400), $this->element->seconds_to_unit(0)); // Zero minutes, for a nice default unit.
    }

    /**
     * Testcase to check generated timestamp
     */
    public function test_exportValue() {
        $el = new LionQuickForm_duration('testel');
        $el->_createElements();
        $values = array('testel' => array('number' => 10, 'timeunit' => 1));
        $this->assertEquals(array('testel' => 10), $el->exportValue($values));
        $values = array('testel' => array('number' => 3, 'timeunit' => 60));
        $this->assertEquals(array('testel' => 180), $el->exportValue($values));
        $values = array('testel' => array('number' => 1.5, 'timeunit' => 60));
        $this->assertEquals(array('testel' => 90), $el->exportValue($values));
        $values = array('testel' => array('number' => 2, 'timeunit' => 3600));
        $this->assertEquals(array('testel' => 7200), $el->exportValue($values));
        $values = array('testel' => array('number' => 1, 'timeunit' => 86400));
        $this->assertEquals(array('testel' => 86400), $el->exportValue($values));
        $values = array('testel' => array('number' => 0, 'timeunit' => 3600));
        $this->assertEquals(array('testel' => 0), $el->exportValue($values));

        $el = new LionQuickForm_duration('testel', null, array('optional' => true));
        $el->_createElements();
        $values = array('testel' => array('number' => 10, 'timeunit' => 1));
        $this->assertEquals(array('testel' => 0), $el->exportValue($values));
        $values = array('testel' => array('number' => 20, 'timeunit' => 1, 'enabled' => 1));
        $this->assertEquals(array('testel' => 20), $el->exportValue($values));
    }
}
