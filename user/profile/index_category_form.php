<?php

/**
 * This file contains the profile field category form.
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
 * Class category_form
 *
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class category_form extends lionform {

    /**
     * Define the form.
     */
    public function definition () {
        global $USER, $CFG;

        $mform = $this->_form;

        $strrequired = get_string('required');

        // Add some extra hidden fields.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'action', 'editcategory');
        $mform->setType('action', PARAM_ALPHANUMEXT);

        $mform->addElement('text', 'name', get_string('profilecategoryname', 'admin'), 'maxlength="255" size="30"');
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', $strrequired, 'required', null, 'client');

        $this->add_action_buttons(true);

    }

    /**
     * Perform some lion validation.
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        global $CFG, $DB;
        $errors = parent::validation($data, $files);

        $data  = (object)$data;

        $duplicate = $DB->get_field('user_info_category', 'id', array('name' => $data->name));

        // Check the name is unique.
        if (!empty($data->id)) { // We are editing an existing record.
            $olddata = $DB->get_record('user_info_category', array('id' => $data->id));
            // Name has changed, new name in use, new name in use by another record.
            $dupfound = (($olddata->name !== $data->name) && $duplicate && ($data->id != $duplicate));
        } else { // New profile category.
            $dupfound = $duplicate;
        }

        if ($dupfound ) {
            $errors['name'] = get_string('profilecategorynamenotunique', 'admin');
        }

        return $errors;
    }
}


