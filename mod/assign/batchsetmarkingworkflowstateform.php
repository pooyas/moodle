<?php

/**
 * This file contains the forms to set the marking workflow for selected submissions.
 *
 * @package   mod
 * @subpackage assign
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot . '/mod/assign/feedback/file/locallib.php');

/**
 * Set marking workflow form.
 *
 */
class mod_assign_batch_set_marking_workflow_state_form extends lionform {
    /**
     * Define this form - called by the parent constructor
     */
    public function definition() {
        $mform = $this->_form;
        $params = $this->_customdata;
        $formheader = get_string('batchsetmarkingworkflowstateforusers', 'assign', $params['userscount']);

        $mform->addElement('header', 'general', $formheader);
        $mform->addElement('static', 'userslist', get_string('selectedusers', 'assign'), $params['usershtml']);

        $options = $params['markingworkflowstates'];
        $mform->addElement('select', 'markingworkflowstate', get_string('markingworkflowstate', 'assign'), $options);

        // Don't allow notification to be sent until in "Released" state.
        $mform->addElement('selectyesno', 'sendstudentnotifications', get_string('sendstudentnotifications', 'assign'));
        $mform->setDefault('sendstudentnotifications', 0);
        $mform->disabledIf('sendstudentnotifications', 'markingworkflowstate', 'neq', ASSIGN_MARKING_WORKFLOW_STATE_RELEASED);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'action', 'setbatchmarkingworkflowstate');
        $mform->setType('action', PARAM_ALPHA);
        $mform->addElement('hidden', 'selectedusers');
        $mform->setType('selectedusers', PARAM_SEQUENCE);
        $this->add_action_buttons(true, get_string('savechanges'));

    }

    /**
     * Validate the submitted form data.
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @return array of "element_name"=>"error_description" if there are errors
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // As the implementation of this feature exists currently, no user will see a validation
        // failure from this form, but this check ensures the form won't validate if someone
        // manipulates the 'sendstudentnotifications' field's disabled attribute client-side.
        if (!empty($data['sendstudentnotifications']) && $data['markingworkflowstate'] != ASSIGN_MARKING_WORKFLOW_STATE_RELEASED) {
            $errors['sendstudentnotifications'] = get_string('studentnotificationworkflowstateerror', 'assign');
        }

        return $errors;
    }
}

