<?php

/**
 * Textarea profile field define.
 *
 * @package   profilefield_textarea
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * 
 */

/**
 * Class profile_field_textarea.
 *
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * 
 */
class profile_field_textarea extends profile_field_base {

    /**
     * Adds elements for this field type to the edit form.
     * @param lionform $mform
     */
    public function edit_field_add($mform) {
        // Create the form field.
        $mform->addElement('editor', $this->inputname, format_string($this->field->name), null, null);
        $mform->setType($this->inputname, PARAM_RAW); // We MUST clean this before display!
    }

    /**
     * Overwrite base class method, data in this field type is potentially too large to be included in the user object.
     * @return bool
     */
    public function is_user_object_data() {
        return false;
    }

    /**
     * Process incoming data for the field.
     * @param stdClass $data
     * @param stdClass $datarecord
     * @return mixed|stdClass
     */
    public function edit_save_data_preprocess($data, $datarecord) {
        if (is_array($data)) {
            $datarecord->dataformat = $data['format'];
            $data = $data['text'];
        }
        return $data;
    }

    /**
     * Load user data for this profile field, ready for editing.
     * @param stdClass $user
     */
    public function edit_load_user_data($user) {
        if ($this->data !== null) {
            $this->data = clean_text($this->data, $this->dataformat);
            $user->{$this->inputname} = array('text' => $this->data, 'format' => $this->dataformat);
        }
    }

    /**
     * Display the data for this field
     * @return string
     */
    public function display_data() {
        return format_text($this->data, $this->dataformat, array('overflowdiv' => true));
    }

}


