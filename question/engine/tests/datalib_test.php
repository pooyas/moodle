<?php


/**
 * Unit tests for parts of {@link question_engine_data_mapper}.
 *
 * @category  test
 * @package    question
 * @subpackage engine
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../lib.php');
require_once(dirname(__FILE__) . '/helpers.php');


/**
 * Unit tests for parts of {@link question_engine_data_mapper}.
 *
 * Note that many of the methods used when attempting questions, like
 * load_questions_usage_by_activity, insert_question_*, delete_steps are
 * tested elsewhere, e.g. by {@link question_usage_autosave_test}. We do not
 * re-test them here.
 *
 */
class question_engine_data_mapper_testcase extends qbehaviour_walkthrough_test_base {

    /**
     * We create two usages, each with two questions, a short-answer marked
     * out of 5, and and essay marked out of 10. We just start these attempts.
     *
     * Then we change the max mark for the short-answer question in one of the
     * usages to 20, using a qubaid_list, and verify.
     *
     * Then we change the max mark for the essay question in the other
     * usage to 2, using a qubaid_join, and verify.
     */
    public function test_set_max_mark_in_attempts() {

        // Set up some things the tests will need.
        $this->resetAfterTest();
        $dm = new question_engine_data_mapper();

        // Create the questions.
        $generator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $generator->create_question_category();
        $sa = $generator->create_question('shortanswer', null,
                array('category' => $cat->id));
        $essay = $generator->create_question('essay', null,
                array('category' => $cat->id));

        // Create the first usage.
        $q = question_bank::load_question($sa->id);
        $this->start_attempt_at_question($q, 'interactive', 5);

        $q = question_bank::load_question($essay->id);
        $this->start_attempt_at_question($q, 'interactive', 10);

        $this->finish();
        $this->save_quba();
        $usage1id = $this->quba->get_id();

        // Create the second usage.
        $this->quba = question_engine::make_questions_usage_by_activity('unit_test',
                context_system::instance());

        $q = question_bank::load_question($sa->id);
        $this->start_attempt_at_question($q, 'interactive', 5);
        $this->process_submission(array('answer' => 'fish'));

        $q = question_bank::load_question($essay->id);
        $this->start_attempt_at_question($q, 'interactive', 10);

        $this->finish();
        $this->save_quba();
        $usage2id = $this->quba->get_id();

        // Test set_max_mark_in_attempts with a qubaid_list.
        $usagestoupdate = new qubaid_list(array($usage1id));
        $dm->set_max_mark_in_attempts($usagestoupdate, 1, 20.0);
        $quba1 = question_engine::load_questions_usage_by_activity($usage1id);
        $quba2 = question_engine::load_questions_usage_by_activity($usage2id);
        $this->assertEquals(20, $quba1->get_question_max_mark(1));
        $this->assertEquals(10, $quba1->get_question_max_mark(2));
        $this->assertEquals( 5, $quba2->get_question_max_mark(1));
        $this->assertEquals(10, $quba2->get_question_max_mark(2));

        // Test set_max_mark_in_attempts with a qubaid_join.
        $usagestoupdate = new qubaid_join('{question_usages} qu', 'qu.id',
                'qu.id = :usageid', array('usageid' => $usage2id));
        $dm->set_max_mark_in_attempts($usagestoupdate, 2, 2.0);
        $quba1 = question_engine::load_questions_usage_by_activity($usage1id);
        $quba2 = question_engine::load_questions_usage_by_activity($usage2id);
        $this->assertEquals(20, $quba1->get_question_max_mark(1));
        $this->assertEquals(10, $quba1->get_question_max_mark(2));
        $this->assertEquals( 5, $quba2->get_question_max_mark(1));
        $this->assertEquals( 2, $quba2->get_question_max_mark(2));

        // Test the nothing to do case.
        $usagestoupdate = new qubaid_join('{question_usages} qu', 'qu.id',
                'qu.id = :usageid', array('usageid' => -1));
        $dm->set_max_mark_in_attempts($usagestoupdate, 2, 2.0);
        $quba1 = question_engine::load_questions_usage_by_activity($usage1id);
        $quba2 = question_engine::load_questions_usage_by_activity($usage2id);
        $this->assertEquals(20, $quba1->get_question_max_mark(1));
        $this->assertEquals(10, $quba1->get_question_max_mark(2));
        $this->assertEquals( 5, $quba2->get_question_max_mark(1));
        $this->assertEquals( 2, $quba2->get_question_max_mark(2));
    }
}
