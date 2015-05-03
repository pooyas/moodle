<?php

/**
 * Text field class.
 *
 * @package    core_form
 * @category   test
 * @copyright  2014 2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_field.php');

/**
 * Class for test-based fields.
 *
 * @package    core_form
 * @category   test
 * @copyright  2014 2015 Pooya Saeedi
 * 
 */
class behat_form_text extends behat_form_field {

    /**
     * Sets the value to a field.
     *
     * @param string $value
     * @return void
     */
    public function set_value($value) {
        $this->field->setValue($value);
    }

    /**
     * Returns the current value of the element.
     *
     * @return string
     */
    public function get_value() {
        return $this->field->getValue();
    }

    /**
     * Matches the provided value against the current field value.
     *
     * @param string $expectedvalue
     * @return bool The provided value matches the field value?
     */
    public function matches($expectedvalue) {
        return $this->text_matches($expectedvalue);
    }

}
