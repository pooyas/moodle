<?php

/**
 * Radio input form element.
 *
 * @package    core_form
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_checkbox.php');

/**
 * Radio input form field.
 *
 * Extends behat_form_checkbox as the set_value() behaviour
 * is the same and it behaves closer to a checkbox than to
 * a text field.
 *
 * This form field type can be added to forms as any other
 * lion form element, but it does not make sense without
 * a group of radio inputs, so is hard to find it alone and
 * detect it by behat_field_manager::get_form_field(), where is useful
 * is when the default behat_form_field class is being used, it
 * finds a input[type=radio] and it delegates set_value() and
 * get_value() to behat_form_radio.
 *
 * @package    core_form
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class behat_form_radio extends behat_form_checkbox {

    /**
     * Returns the radio input value attribute.
     *
     * Here we can not extend behat_form_checkbox because
     * isChecked() does internally a (bool)getValue() and
     * it is not good for radio buttons.
     *
     * @return string The value attribute
     */
    public function get_value() {
        return (bool)$this->field->getAttribute('checked');
    }

    /**
     * Sets the value of a radio
     *
     * Partially overwriting behat_form_checkbox
     * implementation as when JS is disabled we
     * can not check() and we should use setValue()
     *
     * @param string $value
     * @return void
     */
    public function set_value($value) {

        if ($this->running_javascript()) {
            parent::set_value($value);
        } else {
            // Goutte does not accept a check nor a click in an input[type=radio].
            $this->field->setValue($this->field->getAttribute('value'));
        }
    }

    /**
     * Returns whether the provided value matches the current value or not.
     *
     * @param string $expectedvalue
     * @return bool
     */
    public function matches($expectedvalue = false) {
        return $this->text_matches($expectedvalue);
    }
}
