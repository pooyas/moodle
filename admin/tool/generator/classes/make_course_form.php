<?php

/**
 * Course form.
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
class tool_generator_make_course_form extends lionform {

    /**
     * Course generation tool form definition.
     *
     * @return void
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('select', 'size', get_string('size', 'tool_generator'),
                tool_generator_course_backend::get_size_choices());
        $mform->setDefault('size', tool_generator_course_backend::DEFAULT_SIZE);

        $mform->addElement('text', 'shortname', get_string('shortnamecourse'));
        $mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
        $mform->setType('shortname', PARAM_TEXT);

        $mform->addElement('text', 'fullname', get_string('fullnamecourse'));
        $mform->setType('fullname', PARAM_TEXT);

        $mform->addElement('editor', 'summary', get_string('coursesummary'));
        $mform->setType('summary', PARAM_RAW);

        $mform->addElement('submit', 'submit', get_string('createcourse', 'tool_generator'));
    }

    /**
     * Form validation.
     *
     * @param array $data
     * @param array $files
     * @return void
     */
    public function validation($data, $files) {
        global $DB;
        $errors = array();

        // Check course doesn't already exist.
        if (!empty($data['shortname'])) {
            // Check shortname.
            $error = tool_generator_course_backend::check_shortname_available($data['shortname']);
            if ($error) {
                $errors['shortname'] = $error;
            }
        }

        return $errors;
    }
}
