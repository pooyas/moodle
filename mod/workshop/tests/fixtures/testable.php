<?php

/**
 * mod_workshop fixtures
 *
 * @package    mod
 * @subpackage workshop
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Test subclass that makes all the protected methods we want to test public.
 */
class testable_workshop extends workshop {

    public function aggregate_submission_grades_process(array $assessments) {
        parent::aggregate_submission_grades_process($assessments);
    }

    public function aggregate_grading_grades_process(array $assessments, $timegraded = null) {
        parent::aggregate_grading_grades_process($assessments, $timegraded);
    }

}
