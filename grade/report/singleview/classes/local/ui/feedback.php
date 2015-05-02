<?php

/**
 * Class used to render a feedback input box.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Class used to render a feedback input box.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
class feedback extends grade_attribute_format implements unique_value, be_disabled {

    /** @var string $name Name of this input */
    public $name = 'feedback';

    /**
     * Get the value for this input.
     *
     * @return string The value
     */
    public function get_value() {
        return $this->grade->feedback ? $this->grade->feedback : '';
    }

    /**
     * Get the string to use in the label for this input.
     *
     * @return string The label text
     */
    public function get_label() {
        if (!isset($this->grade->label)) {
            $this->grade->label = '';
        }
        return $this->grade->label;
    }

    /**
     * Determine if this input should be disabled based on the other settings.
     *
     * @return boolean Should this input be disabled when the page loads.
     */
    public function is_disabled() {
        $locked = 0;
        $gradeitemlocked = 0;
        $overridden = 0;
        /* Disable editing if grade item or grade score is locked
        * if any of these items are set,  then we will disable editing
        * at some point, we might want to show the reason for the lock
        * this code could be simplified, but its more readable for steve's little mind
        */
        if (!empty($this->grade->locked)) {
            $locked = 1;
        }
        if (!empty($this->grade->grade_item->locked)) {
            $gradeitemlocked = 1;
        }
        if ($this->grade->grade_item->is_overridable_item() and !$this->grade->is_overridden()) {
            $overridden = 1;
        }
        return ($locked || $gradeitemlocked || $overridden);
    }

    /**
     * Create a text_attribute for this ui element.
     *
     * @return text_attribute
     */
    public function determine_format() {
        return new text_attribute(
            $this->get_name(),
            $this->get_value(),
            $this->get_label(),
            $this->is_disabled()
        );
    }

    /**
     * Update the value for this input.
     *
     * @param string $value The new feedback value.
     * @return string Any error message
     */
    public function set($value) {
        $finalgrade = false;
        $trimmed = trim($value);
        if (empty($trimmed)) {
            $feedback = null;
        } else {
            $feedback = $value;
        }

        $this->grade->grade_item->update_final_grade(
            $this->grade->userid, $finalgrade, 'singleview',
            $feedback, FORMAT_LION
        );
    }
}
