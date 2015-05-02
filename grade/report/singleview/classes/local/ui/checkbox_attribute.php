<?php

/**
 * A checkbox ui element.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
namespace gradereport_singleview\local\ui;

use html_writer;

defined('LION_INTERNAL') || die;

/**
 * A checkbox ui element.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
class checkbox_attribute extends element {

    /** @var bool $ischecked Is it checked? */
    private $ischecked;

    /**
     * Constructor
     *
     * @param string $name The element name
     * @param string $label The label for the form element
     * @param bool $ischecked Is this thing on?
     * @param int $locked Is this element locked either 0 or a time.
     */
    public function __construct($name, $label, $ischecked = false, $locked=0) {
        $this->ischecked = $ischecked;
        $this->locked = $locked;
        parent::__construct($name, 1, $label);
    }

    /**
     * Nasty function allowing checkbox logic to escape the class.
     * @return bool
     */
    public function is_checkbox() {
        return true;
    }

    /**
     * Generate the HTML
     *
     * @return string
     */
    public function html() {

        $attributes = array(
            'type' => 'checkbox',
            'name' => $this->name,
            'value' => 1,
            'id' => $this->name
        );

        // UCSB fixed user should not be able to override locked grade.
        if ( $this->locked) {
            $attributes['disabled'] = 'DISABLED';
        }

        $hidden = array(
            'type' => 'hidden',
            'name' => 'old' . $this->name
        );

        if ($this->ischecked) {
            $attributes['checked'] = 'CHECKED';
            $hidden['value'] = 1;
        }

        $type = "override";
        if (preg_match("/^exclude/", $this->name)) {
            $type = "exclude";
        }

        return (
            html_writer::tag('label',
                             get_string($type . 'for', 'gradereport_singleview', $this->label),
                             array('for' => $this->name, 'class' => 'accesshide')) .
            html_writer::empty_tag('input', $attributes) .
            html_writer::empty_tag('input', $hidden)
        );
    }
}
