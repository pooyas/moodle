<?php

/**
 * Unit tests for (some of) question/type/numerical/edit_numerical_form.php.
 *
 * @package    qtype
 * @subpackage numerical
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/numerical/edit_numerical_form.php');


/**
 * Test sub-class, so we can force the locale.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class test_qtype_numerical_edit_form extends qtype_numerical_edit_form {
    public function __construct() {
        // Warning, avoid running the parent constructor. That means the form is
        // not properly tested but for now that is OK, we are only testing a few
        // methods.
        $this->ap = new qtype_numerical_answer_processor(array(), false, ',', ' ');
    }
    public function is_valid_number($x) {
        return parent::is_valid_number($x);
    }
}


/**
 * Unit tests for question/type/numerical/edit_numerical_form.php.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qtype_numerical_form_test extends advanced_testcase {
    public static $includecoverage = array(
        'question/type/numerical/edit_numerical_form.php'
    );

    protected $form;

    protected function setUp() {
        $this->form = new test_qtype_numerical_edit_form();
    }

    protected function tearDown() {
        $this->form = null;
    }

    public function test_is_valid_number() {
        $this->assertTrue($this->form->is_valid_number('1,001'));
        $this->assertTrue($this->form->is_valid_number('1.001'));
        $this->assertTrue($this->form->is_valid_number('1'));
        $this->assertTrue($this->form->is_valid_number('1,e8'));
        $this->assertFalse($this->form->is_valid_number('1001 xxx'));
        $this->assertTrue($this->form->is_valid_number('1.e8'));
    }
}
