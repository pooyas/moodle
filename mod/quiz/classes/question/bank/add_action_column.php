<?php


/**
 * A column type for the add this question to the quiz action.
 *
 * @category  question
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_quiz\question\bank;
defined('LION_INTERNAL') || die();


/**
 * A column type for the add this question to the quiz action.
 *
 */
class add_action_column extends \core_question\bank\action_column_base {
    /** @var string caches a lang string used repeatedly. */
    protected $stradd;

    public function init() {
        parent::init();
        $this->stradd = get_string('addtoquiz', 'quiz');
    }

    public function get_name() {
        return 'addtoquizaction';
    }

    protected function display_content($question, $rowclasses) {
        if (!question_has_capability_on($question, 'use')) {
            return;
        }
        $this->print_icon('t/add', $this->stradd, $this->qbank->add_to_quiz_url($question->id));
    }

    public function get_required_fields() {
        return array('q.id');
    }
}
