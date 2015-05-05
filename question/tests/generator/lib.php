<?php

defined('LION_INTERNAL') || die();

/**
 * Quiz module test data generator class
 *
 * @package    core
 * @subpackage question
 * @copyright  2015 Pooya Saeedi
 * 
 */
class core_question_generator extends component_generator_base {

    /**
     * @var number of created instances
     */
    protected $categorycount = 0;

    public function reset() {
        $this->categorycount = 0;
    }

    /**
     * Create a new question category.
     * @param array|stdClass $record
     * @return stdClass question_categories record.
     */
    public function create_question_category($record = null) {
        global $DB;

        $this->categorycount++;

        $defaults = array(
            'name'       => 'Test question category ' . $this->categorycount,
            'contextid'  => context_system::instance()->id,
            'info'       => '',
            'infoformat' => FORMAT_HTML,
            'stamp'      => '',
            'parent'     => 0,
            'sortorder'  => 999,
        );

        $record = $this->datagenerator->combine_defaults_and_record($defaults, $record);
        $record['id'] = $DB->insert_record('question_categories', $record);
        return (object) $record;
    }

    /**
     * Create a new question. The question is initialised using one of the
     * examples from the appropriate {@link question_test_helper} subclass.
     * Then, any files you want to change from the value in the base example you
     * can override using $overrides.
     * @param string $qtype the question type to create an example of.
     * @param string $which as for the corresponding argument of
     *      {@link question_test_helper::get_question_form_data}. null for the default one.
     * @param array|stdClass $overrides any fields that should be different from the base example.
     */
    public function create_question($qtype, $which = null, $overrides = null) {
        global $CFG;
        require_once($CFG->dirroot . '/question/engine/tests/helpers.php');

        $fromform = test_question_maker::get_question_form_data($qtype, $which);
        $fromform = (object) $this->datagenerator->combine_defaults_and_record(
                (array) $fromform, $overrides);

        $question = new stdClass();
        $question->category  = $fromform->category;
        $question->qtype     = $qtype;
        $question->createdby = 0;
        return question_bank::get_qtype($qtype)->save_question($question, $fromform);
    }
}
