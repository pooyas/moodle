<?php

/**
 * @package    qtype
 * @subpackage essay
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Short answer question type conversion handler
 */
class lion1_qtype_essay_handler extends lion1_qtype_handler {

    /**
     * @return array
     */
    public function get_question_subpaths() {
        return array();
    }

    /**
     * Appends the essay specific information to the question
     */
    public function process_question(array $data, array $raw) {
        // Data added on the upgrade step 2011031000.
        $this->write_xml('essay', array(
            'id'                     => $this->converter->get_nextid(),
            'responseformat'         => 'editor',
            'responserequired'       => 1,
            'responsefieldlines'     => 15,
            'attachments'            => 0,
            'attachmentsrequired'    => 0,
            'graderinfo'             => '',
            'graderinfoformat'       => FORMAT_HTML,
            'responsetemplate'       => '',
            'responsetemplateformat' => FORMAT_HTML
        ), array('/essay/id'));
    }
}
