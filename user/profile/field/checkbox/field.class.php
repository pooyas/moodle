<?php

/**
 * Strings for component 'profilefield_checkbox', language 'en', branch 'LION_20_STABLE'
 *
 * @package   profilefield_checkbox
 * @copyright  2008 onwards Shane Elliot {@link http://pukunui.com}
 * 
 */

/**
 * Class profile_field_checkbox
 *
 * @copyright  2008 onwards Shane Elliot {@link http://pukunui.com}
 * 
 */
class profile_field_checkbox extends profile_field_base {

    /**
     * Constructor method.
     * Pulls out the options for the checkbox from the database and sets the
     * the corresponding key for the data if it exists
     *
     * @param int $fieldid
     * @param int $userid
     */
    public function profile_field_checkbox($fieldid=0, $userid=0) {
        global $DB;
        // First call parent constructor.
        $this->profile_field_base($fieldid, $userid);

        if (!empty($this->field)) {
            $datafield = $DB->get_field('user_info_data', 'data', array('userid' => $this->userid, 'fieldid' => $this->fieldid));
            if ($datafield !== false) {
                $this->data = $datafield;
            } else {
                $this->data = $this->field->defaultdata;
            }
        }
    }

    /**
     * Add elements for editing the profile field value.
     * @param lionform $mform
     */
    public function edit_field_add($mform) {
        // Create the form field.
        $checkbox = $mform->addElement('advcheckbox', $this->inputname, format_string($this->field->name));
        if ($this->data == '1') {
            $checkbox->setChecked(true);
        }
        $mform->setType($this->inputname, PARAM_BOOL);
        if ($this->is_required() and !has_capability('lion/user:update', context_system::instance())) {
            $mform->addRule($this->inputname, get_string('required'), 'nonzero', null, 'client');
        }
    }

    /**
     * Display the data for this field
     *
     * @return string HTML.
     */
    public function display_data() {
        $options = new stdClass();
        $options->para = false;
        $checked = intval($this->data) === 1 ? 'checked="checked"' : '';
        return '<input disabled="disabled" type="checkbox" name="'.$this->inputname.'" '.$checked.' />';
    }

}


