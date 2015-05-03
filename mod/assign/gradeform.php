<?php

/**
 * This file contains the forms to create and edit an instance of this module
 *
 * @package   mod_assign
 * @copyright 2015 Pooya Saeedi {@link http://www.netspot.com.au}
 * 
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');


require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');
require_once('HTML/QuickForm/input.php');

/**
 * Assignment grade form
 *
 * @package   mod_assign
 * @copyright 2015 Pooya Saeedi {@link http://www.netspot.com.au}
 * 
 */
class mod_assign_grade_form extends lionform {
    /** @var assignment $assignment */
    private $assignment;

    /**
     * Define the form - called by parent constructor.
     */
    public function definition() {
        $mform = $this->_form;

        list($assignment, $data, $params) = $this->_customdata;
        // Visible elements.
        $this->assignment = $assignment;
        $assignment->add_grade_form_elements($mform, $data, $params);

        if ($data) {
            $this->set_data($data);
        }
    }

    /**
     * This is required so when using "Save and next", each form is not defaulted to the previous form.
     * Giving each form a unique identitifer is enough to prevent this
     * (include the rownum in the form name).
     *
     * @return string - The unique identifier for this form.
     */
    protected function get_form_identifier() {
        $params = $this->_customdata[2];
        return get_class($this) . '_' . $params['rownum'];
    }

    /**
     * Perform minimal validation on the grade form
     * @param array $data
     * @param array $files
     */
    public function validation($data, $files) {
        global $DB;
        $errors = parent::validation($data, $files);
        $instance = $this->assignment->get_instance();

        if ($instance->markingworkflow && !empty($data['sendstudentnotifications']) &&
                $data['workflowstate'] != ASSIGN_MARKING_WORKFLOW_STATE_RELEASED) {
            $errors['sendstudentnotifications'] = get_string('studentnotificationworkflowstateerror', 'assign');
        }

        // Advanced grading.
        if (!array_key_exists('grade', $data)) {
            return $errors;
        }

        if ($instance->grade > 0) {
            if (unformat_float($data['grade']) === null && (!empty($data['grade']))) {
                $errors['grade'] = get_string('invalidfloatforgrade', 'assign', $data['grade']);
            } else if (unformat_float($data['grade']) > $instance->grade) {
                $errors['grade'] = get_string('gradeabovemaximum', 'assign', $instance->grade);
            } else if (unformat_float($data['grade']) < 0) {
                $errors['grade'] = get_string('gradebelowzero', 'assign');
            }
        } else {
            // This is a scale.
            if ($scale = $DB->get_record('scale', array('id'=>-($instance->grade)))) {
                $scaleoptions = make_menu_from_list($scale->scale);
                if ((int)$data['grade'] !== -1 && !array_key_exists((int)$data['grade'], $scaleoptions)) {
                    $errors['grade'] = get_string('invalidgradeforscale', 'assign');
                }
            }
        }
        return $errors;
    }
}
