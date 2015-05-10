<?php

/**
 * Unit tests for qtype_calculated_variable_substituter.
 *
 * @package    qtype
 * @subpackage calculated
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/calculated/question.php');
require_once($CFG->dirroot . '/question/type/calculated/questiontype.php');


/**
 * Unit tests for {@link qtype_calculated_variable_substituter}.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qtype_calculated_variable_substituter_test extends advanced_testcase {
    public function test_simple_expression() {
        $vs = new qtype_calculated_variable_substituter(array('a' => 1, 'b' => 2), '.');
        $this->assertEquals(3, $vs->calculate('{a} + {b}'));
    }

    public function test_simple_expression_negatives() {
        $vs = new qtype_calculated_variable_substituter(array('a' => -1, 'b' => -2), '.');
        $this->assertEquals(1, $vs->calculate('{a}-{b}'));
    }

    public function test_cannot_use_nonnumbers() {
        $this->setExpectedException('lion_exception');
        $vs = new qtype_calculated_variable_substituter(array('a' => 'frog', 'b' => -2), '.');
    }

    public function test_invalid_expression() {
        $this->setExpectedException('lion_exception');
        $vs = new qtype_calculated_variable_substituter(array('a' => 1, 'b' => 2), '.');
        $vs->calculate('{a} + {b}?');
    }

    public function test_tricky_invalid_expression() {
        $this->setExpectedException('lion_exception');
        $vs = new qtype_calculated_variable_substituter(array('a' => 1, 'b' => 2), '.');
        $vs->calculate('{a}{b}'); // Have to make sure this does not just evaluate to 12.
    }

    public function test_replace_expressions_in_text_simple_var() {
        $vs = new qtype_calculated_variable_substituter(array('a' => 1, 'b' => 2), '.');
        $this->assertEquals('1 + 2', $vs->replace_expressions_in_text('{a} + {b}'));
    }

    public function test_replace_expressions_in_confusing_text() {
        $vs = new qtype_calculated_variable_substituter(array('a' => 1, 'b' => 2), '.');
        $this->assertEquals("(1) 1\n(2) 2", $vs->replace_expressions_in_text("(1) {a}\n(2) {b}"));
    }

    public function test_replace_expressions_in_text_formula() {
        $vs = new qtype_calculated_variable_substituter(array('a' => 1, 'b' => 2), '.');
        $this->assertEquals('= 3', $vs->replace_expressions_in_text('= {={a} + {b}}'));
    }

    public function test_replace_expressions_in_text_negative() {
        $vs = new qtype_calculated_variable_substituter(array('a' => -1, 'b' => 2), '.');
        $this->assertEquals('temperatures -1 and 2',
                $vs->replace_expressions_in_text('temperatures {a} and {b}'));
    }

    public function test_replace_expressions_in_text_commas_for_decimals() {
        $vs = new qtype_calculated_variable_substituter(
                array('phi' => 1.61803399, 'pi' => 3.14159265), ',');
        $this->assertEquals('phi (1,61803399) + pi (3,14159265) = 4,75962664',
                $vs->replace_expressions_in_text('phi ({phi}) + pi ({pi}) = {={phi} + {pi}}'));
    }

    public function test_format_float_dot() {
        $vs = new qtype_calculated_variable_substituter(array('a' => -1, 'b' => 2), '.');
        $this->assertSame('0.12345', $vs->format_float(0.12345));

        $this->assertSame('0', $vs->format_float(0.12345, 0, 1));
        $this->assertSame('0.12', $vs->format_float(0.12345, 2, 1));
        $this->assertSame('0.1235', $vs->format_float(0.12345, 4, 1));

        $this->assertSame('0.12', $vs->format_float(0.12345, 2, 2));
        $this->assertSame('0.0012', $vs->format_float(0.0012345, 4, 1));
    }

    public function test_format_float_comma() {
        $vs = new qtype_calculated_variable_substituter(array('a' => -1, 'b' => 2), ',');
        $this->assertSame('0,12345', $vs->format_float(0.12345));

        $this->assertSame('0', $vs->format_float(0.12345, 0, 1));
        $this->assertSame('0,12', $vs->format_float(0.12345, 2, 1));
        $this->assertSame('0,1235', $vs->format_float(0.12345, 4, 1));

        $this->assertSame('0,12', $vs->format_float(0.12345, 2, 2));
        $this->assertSame('0,0012', $vs->format_float(0.0012345, 4, 1));
    }
}
