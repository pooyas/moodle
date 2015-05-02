<?php

/**
 * This file contains tests for the {@link question_utils} class.
 *
 * @package    lioncore
 * @subpackage questionengine
 * @copyright  2010 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../lib.php');


/**
 * Unit tests for the {@link question_utils} class.
 *
 * @copyright  2010 The Open University
 * 
 */
class question_utils_test extends advanced_testcase {
    public function test_arrays_have_same_keys_and_values() {
        $this->assertTrue(question_utils::arrays_have_same_keys_and_values(
                array(),
                array()));
        $this->assertTrue(question_utils::arrays_have_same_keys_and_values(
                array('key' => 1),
                array('key' => '1')));
        $this->assertFalse(question_utils::arrays_have_same_keys_and_values(
                array(),
                array('key' => 1)));
        $this->assertFalse(question_utils::arrays_have_same_keys_and_values(
                array('key' => 2),
                array('key' => 1)));
        $this->assertFalse(question_utils::arrays_have_same_keys_and_values(
                array('key' => 1),
                array('otherkey' => 1)));
        $this->assertFalse(question_utils::arrays_have_same_keys_and_values(
                array('sub0' => '2', 'sub1' => '2', 'sub2' => '3', 'sub3' => '1'),
                array('sub0' => '1', 'sub1' => '2', 'sub2' => '3', 'sub3' => '1')));
    }

    public function test_arrays_same_at_key() {
        $this->assertTrue(question_utils::arrays_same_at_key(
                array(),
                array(),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key(
                array(),
                array('key' => 1),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key(
                array('key' => 1),
                array(),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key(
                array('key' => 1),
                array('key' => 1),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key(
                array('key' => 1),
                array('key' => 2),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key(
                array('key' => 1),
                array('key' => '1'),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key(
                array('key' => 0),
                array('key' => ''),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key(
                array(),
                array('key' => ''),
                'key'));
    }

    public function test_arrays_same_at_key_missing_is_blank() {
        $this->assertTrue(question_utils::arrays_same_at_key_missing_is_blank(
                array(),
                array(),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key_missing_is_blank(
                array(),
                array('key' => 1),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key_missing_is_blank(
                array('key' => 1),
                array(),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key_missing_is_blank(
                array('key' => 1),
                array('key' => 1),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key_missing_is_blank(
                array('key' => 1),
                array('key' => 2),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key_missing_is_blank(
                array('key' => 1),
                array('key' => '1'),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key_missing_is_blank(
                array('key' => '0'),
                array('key' => ''),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key_missing_is_blank(
                array(),
                array('key' => ''),
                'key'));
    }

    public function test_arrays_same_at_key_integer() {
        $this->assertTrue(question_utils::arrays_same_at_key_integer(
                array(),
                array(),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key_integer(
                array(),
                array('key' => 1),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key_integer(
                array('key' => 1),
                array(),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key_integer(
                array('key' => 1),
                array('key' => 1),
                'key'));
        $this->assertFalse(question_utils::arrays_same_at_key_integer(
                array('key' => 1),
                array('key' => 2),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key_integer(
                array('key' => 1),
                array('key' => '1'),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key_integer(
                array('key' => '0'),
                array('key' => ''),
                'key'));
        $this->assertTrue(question_utils::arrays_same_at_key_integer(
                array(),
                array('key' => 0),
                'key'));
    }

    public function test_int_to_roman() {
        $this->assertSame('i', question_utils::int_to_roman(1));
        $this->assertSame('iv', question_utils::int_to_roman(4));
        $this->assertSame('v', question_utils::int_to_roman(5));
        $this->assertSame('vi', question_utils::int_to_roman(6));
        $this->assertSame('ix', question_utils::int_to_roman(9));
        $this->assertSame('xi', question_utils::int_to_roman(11));
        $this->assertSame('xlviii', question_utils::int_to_roman(48));
        $this->assertSame('lxxxvii', question_utils::int_to_roman(87));
        $this->assertSame('c', question_utils::int_to_roman(100));
        $this->assertSame('mccxxxiv', question_utils::int_to_roman(1234));
        $this->assertSame('mmmcmxcix', question_utils::int_to_roman(3999));
    }

    public function test_int_to_roman_too_small() {
        $this->setExpectedException('lion_exception');
        question_utils::int_to_roman(0);
    }

    public function test_int_to_roman_too_big() {
        $this->setExpectedException('lion_exception');
        question_utils::int_to_roman(4000);
    }

    public function test_int_to_roman_not_int() {
        $this->setExpectedException('lion_exception');
        question_utils::int_to_roman(1.5);
    }

    public function test_clean_param_mark() {
        $this->assertNull(question_utils::clean_param_mark(null));
        $this->assertSame('', question_utils::clean_param_mark(''));
        $this->assertSame(0.0, question_utils::clean_param_mark('0'));
        $this->assertSame(1.5, question_utils::clean_param_mark('1.5'));
        $this->assertSame(1.5, question_utils::clean_param_mark('1,5'));
        $this->assertSame(-1.5, question_utils::clean_param_mark('-1.5'));
        $this->assertSame(-1.5, question_utils::clean_param_mark('-1,5'));
    }
}
