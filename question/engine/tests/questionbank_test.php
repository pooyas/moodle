<?php


/**
 * This file contains tests for the question_bank class.
 *
 * @package    question
 * @subpackage engine
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../lib.php');


/**
 *Unit tests for the {@link question_bank} class.
 *
 */
class question_bank_test extends advanced_testcase {

    public function test_sort_qtype_array() {
        $config = new stdClass();
        $config->multichoice_sortorder = '1';
        $config->calculated_sortorder = '2';
        $qtypes = array(
            'frog' => 'toad',
            'calculated' => 'newt',
            'multichoice' => 'eft',
        );
        $this->assertEquals(question_bank::sort_qtype_array($qtypes, $config), array(
            'multichoice' => 'eft',
            'calculated' => 'newt',
            'frog' => 'toad',
        ));
    }

    public function test_fraction_options() {
        $fractions = question_bank::fraction_options();
        $this->assertSame(get_string('none'), reset($fractions));
        $this->assertSame('0.0', key($fractions));
        $this->assertSame('5%', end($fractions));
        $this->assertSame('0.05', key($fractions));
        array_shift($fractions);
        array_pop($fractions);
        array_pop($fractions);
        $this->assertSame('100%', reset($fractions));
        $this->assertSame('1.0', key($fractions));
        $this->assertSame('11.11111%', end($fractions));
        $this->assertSame('0.1111111', key($fractions));
    }

    public function test_fraction_options_full() {
        $fractions = question_bank::fraction_options_full();
        $this->assertSame(get_string('none'), reset($fractions));
        $this->assertSame('0.0', key($fractions));
        $this->assertSame('-100%', end($fractions));
        $this->assertSame('-1.0', key($fractions));
        array_shift($fractions);
        array_pop($fractions);
        array_pop($fractions);
        $this->assertSame('100%', reset($fractions));
        $this->assertSame('1.0', key($fractions));
        $this->assertSame('-83.33333%', end($fractions));
        $this->assertSame('-0.8333333', key($fractions));
    }
}
