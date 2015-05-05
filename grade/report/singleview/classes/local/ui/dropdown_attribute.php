<?php

/**
 * Drop down list (select list) element
 *
 * @package    gradereport
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_singleview\local\ui;

use html_writer;

defined('LION_INTERNAL') || die;

/**
 * Drop down list (select list) element
 *
 */
class dropdown_attribute extends element {

    /** @var string $selected Who is selected ? */
    private $selected;

    /** @var array $options List of options ? */
    private $options;

    /** @var bool $isdisabled Is this input disabled. */
    private $isdisabled;

    /**
     * Constructor
     *
     * @param string $name The first bit of the name of this input.
     * @param array $options The options list for this select.
     * @param string $label The form label for this input.
     * @param string $selected The name of the selected item in this input.
     * @param bool $isdisabled Are we disabled?
     */
    public function __construct($name, $options, $label, $selected = '', $isdisabled = false) {
        $this->selected = $selected;
        $this->options = $options;
        $this->isdisabled = $isdisabled;
        parent::__construct($name, $selected, $label);
    }

    /**
     * Nasty function spreading dropdown logic around.
     *
     * @return bool
     */
    public function is_dropdown() {
        return true;
    }

    /**
     * Render this element as html.
     *
     * @return string
     */
    public function html() {
        $old = array(
            'type' => 'hidden',
            'name' => 'old' . $this->name,
            'value' => $this->selected
        );

        $attributes = array();

        if (!empty($this->isdisabled)) {
            $attributes['disabled'] = 'DISABLED';
        }

        $select = html_writer::select(
            $this->options, $this->name, $this->selected, false, $attributes
        );

        return ($select . html_writer::empty_tag('input', $old));
    }
}
