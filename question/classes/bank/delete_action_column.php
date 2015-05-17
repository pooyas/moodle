<?php



/**
 * @package    question
 * @subpackage classes
 * @copyright  2015 Pooya Saeedi
*/

namespace core_question\bank;

/**
 * action to delete (or hide) a question, or restore a previously hidden question.
 *
 */

class delete_action_column extends action_column_base {
    protected $strdelete;
    protected $strrestore;

    public function init() {
        parent::init();
        $this->strdelete = get_string('delete');
        $this->strrestore = get_string('restore');
    }

    public function get_name() {
        return 'deleteaction';
    }

    protected function display_content($question, $rowclasses) {
        if (question_has_capability_on($question, 'edit')) {
            if ($question->hidden) {
                $url = new \lion_url($this->qbank->base_url(), array('unhide' => $question->id, 'sesskey' => sesskey()));
                $this->print_icon('t/restore', $this->strrestore, $url);
            } else {
                $url = new \lion_url($this->qbank->base_url(), array('deleteselected' => $question->id, 'q' . $question->id => 1,
                                              'sesskey' => sesskey()));
                $this->print_icon('t/delete', $this->strdelete, $url);
            }
        }
    }

    public function get_required_fields() {
        return array('q.id', 'q.hidden');
    }
}
