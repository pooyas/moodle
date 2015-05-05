<?php

/**
 * An override grade checkbox element
 *
 * @package    gradereport
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * An override grade checkbox element
 *
 */
class override extends grade_attribute_format implements be_checked, be_disabled {

    /** @var string $name The name for this input */
    public $name = 'override';

    /**
     * Is this input checked
     *
     * @return bool
     */
    public function is_checked() {
        return $this->grade->is_overridden();
    }

    /**
     * Is this input disabled
     *
     * @return bool
     */
    public function is_disabled() {
        $lockedgrade = $lockedgradeitem = 0;
        if (!empty($this->grade->locked)) {
            $lockedgrade = 1;
        }
        if (!empty($this->grade->grade_item->locked)) {
            $lockedgradeitem = 1;
        }
        return ($lockedgrade || $lockedgradeitem);
    }

    /**
     * Get the label for this form element.
     *
     * @return string
     */
    public function get_label() {
        if (!isset($this->grade->label)) {
            $this->grade->label = '';
        }
        return $this->grade->label;
    }

    /**
     * Generate the element for this form input.
     *
     * @return element
     */
    public function determine_format() {
        if (!$this->grade->grade_item->is_overridable_item()) {
            return new empty_element();
        }
        return new checkbox_attribute(
            $this->get_name(),
            $this->get_label(),
            $this->is_checked(),
            $this->is_disabled()
        );
    }

    /**
     * Save the modified value of this form element.
     *
     * @param string $value The new value to set
     * @return mixed string|false Any error message
     */
    public function set($value) {
        if (empty($this->grade->id)) {
            return false;
        }

        $state = $value == 0 ? false : true;

        $this->grade->set_overridden($state);
        $this->grade->grade_item->get_parent_category()->force_regrading();
        return false;
    }
}
