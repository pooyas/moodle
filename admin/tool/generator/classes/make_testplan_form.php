<?php

/**
 * Test plan form.
 *
 * @package    tool
 * @subpackage generator
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

/**
 * Form with options for creating large course.
 *
 */
class tool_generator_make_testplan_form extends lionform {

    /**
     * Test plan form definition.
     *
     * @return void
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('select', 'size', get_string('size', 'tool_generator'),
            tool_generator_testplan_backend::get_size_choices());
        $mform->setDefault('size', tool_generator_testplan_backend::DEFAULT_SIZE);

        $mform->addElement('select', 'courseid', get_string('targetcourse', 'tool_generator'),
            tool_generator_testplan_backend::get_course_options());

        $mform->addElement('advcheckbox', 'updateuserspassword', get_string('updateuserspassword', 'tool_generator'));
        $mform->addHelpButton('updateuserspassword', 'updateuserspassword', 'tool_generator');

        $mform->addElement('submit', 'submit', get_string('createtestplan', 'tool_generator'));
    }

    /**
     * Checks that the submitted data allows us to create a test plan.
     *
     * @param array $data
     * @param array $files
     * @return array An array of errors
     */
    public function validation($data, $files) {
        global $CFG;

        $errors = array();
        if (empty($CFG->tool_generator_users_password) || is_bool($CFG->tool_generator_users_password)) {
            $errors['updateuserspassword'] = get_string('error_nouserspassword', 'tool_generator');
        }

        // Better to repeat here the query than to do it afterwards and end up with an exception.
        if ($courseerrors = tool_generator_testplan_backend::has_selected_course_any_problem($data['courseid'], $data['size'])) {
            $errors = array_merge($errors, $courseerrors);
        }

        return $errors;
    }

}
