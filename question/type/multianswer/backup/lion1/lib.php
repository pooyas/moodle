<?php


/**
 * @package    question_type
 * @subpackage multianswer
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Multianswer (aka embedded, cloze) question type conversion handler
 */
class lion1_qtype_multianswer_handler extends lion1_qtype_handler {

    /**
     * @return array
     */
    public function get_question_subpaths() {
        return array(
            'ANSWERS/ANSWER',
            'MULTIANSWERS/MULTIANSWER',
        );
    }

    /**
     * Appends the multianswer specific information to the question
     *
     * Note that there is an upgrade step 2008050800 that is not replayed here as I suppose there
     * was an error on restore and the backup file contains correct data. If I'm wrong on this
     * assumption then the parent of the embedded questions could be fixed on conversion in theory
     * (by using a temporary stash that keeps multianswer's id and its sequence) but the category
     * fix would be tricky in XML.
     */
    public function process_question(array $data, array $raw) {

        // Convert and write the answers first.
        if (isset($data['answers'])) {
            $this->write_answers($data['answers'], $this->pluginname);
        }

        // Convert and write the multianswer extra fields.
        foreach ($data['multianswers'] as $multianswers) {
            foreach ($multianswers as $multianswer) {
                $this->write_xml('multianswer', $multianswer, array('/multianswer/id'));
            }
        }
    }
}
