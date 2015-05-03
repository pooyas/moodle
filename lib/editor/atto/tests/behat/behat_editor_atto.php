<?php

/**
 * Atto custom steps definitions.
 *
 * @package    editor_atto
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

/**
 * Steps definitions to deal with the atto text editor
 *
 * @package    editor_atto
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class behat_editor_atto extends behat_base {

    /**
     * Select the text in an Atto field.
     *
     * @Given /^I select the text in the "([^"]*)" Atto editor$/
     * @throws ElementNotFoundException Thrown by behat_base::find
     * @param string $field
     * @return void
     */
    public function select_the_text_in_the_atto_editor($fieldlocator) {
        if (!$this->running_javascript()) {
            throw new coding_exception('Selecting text requires javascript.');
        }
        // We delegate to behat_form_field class, it will
        // guess the type properly.
        $field = behat_field_manager::get_form_field_from_label($fieldlocator, $this);

        if (!method_exists($field, 'select_text')) {
            throw new coding_exception('Field does not support the select_text function.');
        }
        $field->select_text();
    }


}

