<?php

/**
 * @package    qtype
 * @subpackage numerical
 * @copyright  2011 David Mudrak <david@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Multichoice question type conversion handler
 */
class lion1_qtype_numerical_handler extends lion1_qtype_handler {

    /**
     * @return array
     */
    public function get_question_subpaths() {
        return array(
            'ANSWERS/ANSWER',
            'NUMERICAL',
            'NUMERICAL/NUMERICAL_UNITS/NUMERICAL_UNIT',
        );
    }

    /**
     * Appends the numerical specific information to the question
     */
    public function process_question(array $data, array $raw) {

        // Convert and write the answers first.
        if (isset($data['answers'])) {
            $this->write_answers($data['answers'], $this->pluginname);
        }

        // Convert and write the numerical units and numerical options.
        if (isset($data['numerical'][0]['numerical_units'])) {
            $numericalunits = $data['numerical'][0]['numerical_units'];
        } else {
            $numericalunits = array();
        }
        $numericaloptions = $this->get_default_numerical_options(
                $data['oldquestiontextformat'], $numericalunits);

        $this->write_numerical_units($numericalunits);
        $this->write_numerical_options($numericaloptions);

        // And finally numerical_records.
        $this->xmlwriter->begin_tag('numerical_records');
        foreach ($data['numerical'] as $numericalrecord) {
            // We do not use write_xml() here because $numericalrecords contains more than we want.
            $this->xmlwriter->begin_tag('numerical_record', array('id' => $this->converter->get_nextid()));
            $this->xmlwriter->full_tag('answer', $numericalrecord['answer']);
            $this->xmlwriter->full_tag('tolerance', $numericalrecord['tolerance']);
            $this->xmlwriter->end_tag('numerical_record');
        }
        $this->xmlwriter->end_tag('numerical_records');
    }
}
