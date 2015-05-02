<?php

/**
 * Element that just generates some text.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Element that just generates some text.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
class empty_element extends element {

    /**
     * Constructor
     *
     * @param string $msg The text
     */
    public function __construct($msg = null) {
        if (is_null($msg)) {
            $this->text = '&nbsp;';
        } else {
            $this->text = $msg;
        }
    }

    /**
     * Generate the html (simple case)
     *
     * @return string HTML
     */
    public function html() {
        return $this->text;
    }
}
