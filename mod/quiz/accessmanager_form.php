<?php


/**
 * Defines the form that limits student's access to attempt a quiz.
 *
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');


/**
 * A form that limits student's access to attempt a quiz.
 *
 */
class mod_quiz_preflight_check_form extends lionform {

    protected function definition() {
        $mform = $this->_form;

        foreach ($this->_customdata['hidden'] as $name => $value) {
            if ($name === 'sesskey') {
                continue;
            }
            $mform->addElement('hidden', $name, $value);
            $mform->setType($name, PARAM_INT);
        }

        foreach ($this->_customdata['rules'] as $rule) {
            if ($rule->is_preflight_check_required($this->_customdata['attemptid'])) {
                $rule->add_preflight_check_form_fields($this, $mform,
                        $this->_customdata['attemptid']);
            }
        }

        $this->add_action_buttons(true, get_string('continue'));
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        foreach ($this->_customdata['rules'] as $rule) {
            if ($rule->is_preflight_check_required($this->_customdata['attemptid'])) {
                $errors = $rule->validate_preflight_check($data, $files, $errors,
                        $this->_customdata['attemptid']);
            }
        }

        return $errors;
    }
}
