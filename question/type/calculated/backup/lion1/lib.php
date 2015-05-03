<?php

/**
 * @package    qtype
 * @subpackage calculated
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Calculated question type conversion handler
 */
class lion1_qtype_calculated_handler extends lion1_qtype_handler {

    /**
     * @return array
     */
    public function get_question_subpaths() {
        return array(
            'ANSWERS/ANSWER',
            'CALCULATED',
            'CALCULATED/NUMERICAL_UNITS/NUMERICAL_UNIT',
            'CALCULATED/DATASET_DEFINITIONS/DATASET_DEFINITION',
            'CALCULATED/DATASET_DEFINITIONS/DATASET_DEFINITION/DATASET_ITEMS/DATASET_ITEM'
        );
    }

    /**
     * Appends the calculated specific information to the question
     */
    public function process_question(array $data, array $raw) {

        // Convert and write the answers first.
        if (isset($data['answers'])) {
            $this->write_answers($data['answers'], $this->pluginname);
        }

        // Convert and write the numerical units and numerical options.
        if (isset($data['calculated'][0]['numerical_units'])) {
            $numericalunits = $data['calculated'][0]['numerical_units'];
        } else {
            $numericalunits = array();
        }
        $numericaloptions = $this->get_default_numerical_options(
                $data['oldquestiontextformat'], $numericalunits);

        $this->write_numerical_units($numericalunits);
        $this->write_numerical_options($numericaloptions);

        // Write dataset_definitions.
        if (isset($data['calculated'][0]['dataset_definitions']['dataset_definition'])) {
            $datasetdefinitions = $data['calculated'][0]['dataset_definitions']['dataset_definition'];
        } else {
            $datasetdefinitions = array();
        }
        $this->write_dataset_definitions($datasetdefinitions);

        // Write calculated_records.
        $this->xmlwriter->begin_tag('calculated_records');
        foreach ($data['calculated'] as $calculatedrecord) {
            $record = array(
                'id'                  => $this->converter->get_nextid(),
                'answer'              => $calculatedrecord['answer'],
                'tolerance'           => $calculatedrecord['tolerance'],
                'tolerancetype'       => $calculatedrecord['tolerancetype'],
                'correctanswerlength' => $calculatedrecord['correctanswerlength'],
                'correctanswerformat' => $calculatedrecord['correctanswerformat']
            );
            $this->write_xml('calculated_record', $record, array('/calculated_record/id'));
        }
        $this->xmlwriter->end_tag('calculated_records');

        // Write calculated_options.
        $options = array(
            'calculate_option' => array(
                'id'                             => $this->converter->get_nextid(),
                'synchronize'                    => 0,
                'single'                         => 0,
                'shuffleanswers'                 => 0,
                'correctfeedback'                => null,
                'correctfeedbackformat'          => FORMAT_HTML,
                'partiallycorrectfeedback'       => null,
                'partiallycorrectfeedbackformat' => FORMAT_HTML,
                'incorrectfeedback'              => null,
                'incorrectfeedbackformat'        => FORMAT_HTML,
                'answernumbering'                => 'abc'
            )
        );
        $this->write_xml('calculated_options', $options, array('/calculated_options/calculate_option/id'));
    }
}
