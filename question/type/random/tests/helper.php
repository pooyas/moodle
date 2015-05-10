<?php

/**
 * Test helpers for the random question type.
 *
 * @package    qtype
 * @subpackage random
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Test helper class for the random question type.
 *
 */
class qtype_random_test_helper extends question_test_helper {
    public function get_test_questions() {
        return array('basic');
    }

    /**
     * Gets the question form data for a random question which selects just from
     * it's own category and not from sub categories. Category id is not set.
     * @return stdClass
     */
    public function get_random_question_form_data_basic() {
        $form = new stdClass();
        $form->questiontext = array('text' => '');
        $form->includingsubcategories = '0';
        return $form;
    }
}
