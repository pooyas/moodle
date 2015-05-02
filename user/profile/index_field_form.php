<?php

/**
 * This file contains the Field Form used for profile fields.
 *
 * @package core_user
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Lion page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Class field_form
 *
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class field_form extends lionform {

    /** @var profile_define_base $field */
    public $field;

    /**
     * Define the form
     */
    public function definition () {
        global $CFG;

        $mform = $this->_form;

        // Everything else is dependant on the data type.
        $datatype = $this->_customdata;
        require_once($CFG->dirroot.'/user/profile/field/'.$datatype.'/define.class.php');
        $newfield = 'profile_define_'.$datatype;
        $this->field = new $newfield();

        $strrequired = get_string('required');

        // Add some extra hidden fields.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'action', 'editfield');
        $mform->setType('action', PARAM_ALPHANUMEXT);
        $mform->addElement('hidden', 'datatype', $datatype);
        $mform->setType('datatype', PARAM_ALPHA);

        $this->field->define_form($mform);

        $this->add_action_buttons(true);
    }


    /**
     * Alter definition based on existing or submitted data
     */
    public function definition_after_data () {
        $mform = $this->_form;
        $this->field->define_after_data($mform);
    }


    /**
     * Perform some lion validation.
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        return $this->field->define_validate($data, $files);
    }

    /**
     * Returns the defined editors for the field.
     * @return mixed
     */
    public function editors() {
        return $this->field->define_editors();
    }
}


