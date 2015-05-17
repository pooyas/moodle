<?php


/**
 * Form classes for editing badges criteria
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->libdir . '/badgeslib.php');

/**
 * Form to edit badge criteria.
 *
 */
class edit_criteria_form extends lionform {
    public function definition() {
        global $DB;
        $mform = $this->_form;
        $criteria = $this->_customdata['criteria'];
        $addcourse = $this->_customdata['addcourse'];
        $course = $this->_customdata['course'];

        // Get course selector first if it's a new courseset criteria.
        if (($criteria->id == 0 || $addcourse) && $criteria->criteriatype == BADGE_CRITERIA_TYPE_COURSESET) {
            $criteria->get_courses($mform);
        } else {
            if ($criteria->id == 0 && $criteria->criteriatype == BADGE_CRITERIA_TYPE_COURSE) {
                $mform->addElement('hidden', 'course', $course);
                $mform->setType('course', PARAM_INT);
            }
            list($none, $message) = $criteria->get_options($mform);

            if ($none) {
                $mform->addElement('html', html_writer::tag('div', $message));
                $mform->addElement('submit', 'cancel', get_string('continue'));
            } else {
                $mform->closeHeaderBefore('buttonar');
                $this->add_action_buttons(true, get_string('save', 'badges'));
            }
        }
    }

    /**
     * Validates form data
     */
    public function validation($data, $files) {
        global $OUTPUT;
        $errors = parent::validation($data, $files);
        $addcourse = $this->_customdata['addcourse'];

        if (!$addcourse) {
            $required = $this->_customdata['criteria']->required_param;
            $pattern1 = '/^' . $required . '_(\d+)$/';
            $pattern2 = '/^' . $required . '_(\w+)$/';

            $ok = false;
            foreach ($data as $key => $value) {
                if ((preg_match($pattern1, $key) || preg_match($pattern2, $key)) && !($value === 0 || $value == '0')) {
                    $ok = true;
                }
            }

            $warning = $this->_form->createElement('html',
                    $OUTPUT->notification(get_string('error:parameter', 'badges'), 'notifyproblem'), 'submissionerror');

            if (!$ok) {
                $errors['formerrors'] = 'Error';
                $this->_form->insertElementBefore($warning, 'first_header');
            }
        }
        return $errors;
    }
}