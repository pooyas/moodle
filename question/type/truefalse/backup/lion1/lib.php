<?php

/**
 * @package    qtype
 * @subpackage truefalse
 * @copyright  2011 David Mudrak <david@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * True/false question type conversion handler
 */
class lion1_qtype_truefalse_handler extends lion1_qtype_handler {

    /**
     * @return array
     */
    public function get_question_subpaths() {
        return array(
            'ANSWERS/ANSWER',
            'TRUEFALSE',
        );
    }

    /**
     * Appends the truefalse specific information to the question
     */
    public function process_question(array $data, array $raw) {

        // Convert and write the answers first.
        if (isset($data['answers'])) {
            $this->write_answers($data['answers'], $this->pluginname);
        }

        // Convert and write the truefalse extra fields.
        foreach ($data['truefalse'] as $truefalse) {
            $truefalse['id'] = $this->converter->get_nextid();
            $this->write_xml('truefalse', $truefalse, array('/truefalse/id'));
        }
    }
}
