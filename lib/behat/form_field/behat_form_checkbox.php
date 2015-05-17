<?php


/**
 * Single checkbox form element.
 *
 * @category   test
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_field.php');

/**
 * Checkbox form field.
 *
 * @category   test
 */
class behat_form_checkbox extends behat_form_field {

    /**
     * Sets the value of a checkbox.
     *
     * Anything !empty() is considered checked.
     *
     * @param string $value
     * @return void
     */
    public function set_value($value) {

        if (!empty($value) && !$this->field->isChecked()) {

            if (!$this->running_javascript()) {
                $this->field->check();
                return;
            }

            // Check it if it should be checked and it is not.
            $this->field->click();

            // Trigger the onchange event as triggered when 'checking' the checkbox.
            $this->session->getDriver()->triggerSynScript(
                $this->field->getXPath(),
                "Syn.trigger('change', {}, {{ELEMENT}})"
            );

        } else if (empty($value) && $this->field->isChecked()) {

            if (!$this->running_javascript()) {
                $this->field->uncheck();
                return;
            }

            // Uncheck if it is checked and shouldn't.
            $this->field->click();

            // Trigger the onchange event as triggered when 'checking' the checkbox.
            $this->session->getDriver()->triggerSynScript(
                $this->field->getXPath(),
                "Syn.trigger('change', {}, {{ELEMENT}})"
            );
        }
    }

    /**
     * Returns whether the field is checked or not.
     *
     * @return bool True if it is checked and false if it's not.
     */
    public function get_value() {
        return $this->field->isChecked();
    }

    /**
     * Is it enabled?
     *
     * @param string $expectedvalue Anything !empty() is considered checked.
     * @return bool
     */
    public function matches($expectedvalue = false) {

        $ischecked = $this->field->isChecked();

        // Any non-empty value provided means that it should be checked.
        if (!empty($expectedvalue) && $ischecked) {
            return true;
        } else if (empty($expectedvalue) && !$ischecked) {
            return true;
        }

        return false;
    }

}
