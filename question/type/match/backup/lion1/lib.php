<?php

/**
 * @package    qtype_match
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Matching question type conversion handler.
 */
class lion1_qtype_match_handler extends lion1_qtype_handler {

    /**
     * @return array
     */
    public function get_question_subpaths() {
        return array(
            'MATCHOPTIONS',
            'MATCHS/MATCH',
        );
    }

    /**
     * Appends the match specific information to the question.
     */
    public function process_question(array $data, array $raw) {
        global $CFG;

        // Populate the list of matches first to get their ids.
        // Note that the field is re-populated on restore anyway but let us
        // do our best to produce valid backup files.
        $matchids = array();
        if (isset($data['matchs']['match'])) {
            foreach ($data['matchs']['match'] as $match) {
                $matchids[] = $match['id'];
            }
        }

        // Convert match options.
        if (isset($data['matchoptions'])) {
            $matchoptions = $data['matchoptions'][0];
        } else {
            $matchoptions = array('shuffleanswers' => 1);
        }
        $matchoptions['id'] = $this->converter->get_nextid();
        $matchoptions['subquestions'] = implode(',', $matchids);
        $this->write_xml('matchoptions', $matchoptions, array('/matchoptions/id'));

        // Convert matches.
        $this->xmlwriter->begin_tag('matches');
        if (isset($data['matchs']['match'])) {
            foreach ($data['matchs']['match'] as $match) {
                // Replay the upgrade step 2009072100.
                $match['questiontextformat'] = 0;
                if ($CFG->texteditors !== 'textarea' and $data['oldquestiontextformat'] == FORMAT_LION) {
                    $match['questiontext'] = text_to_html($match['questiontext'], false, false, true);
                    $match['questiontextformat'] = FORMAT_HTML;
                } else {
                    $match['questiontextformat'] = $data['oldquestiontextformat'];
                }

                $match['questiontext'] = $this->migrate_files(
                        $match['questiontext'], 'qtype_match', 'subquestion', $match['id']);
                $this->write_xml('match', $match, array('/match/id'));
            }
        }
        $this->xmlwriter->end_tag('matches');
    }
}
