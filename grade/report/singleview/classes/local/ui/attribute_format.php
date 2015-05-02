<?php

/**
 * Class that builds an element tree that can be converted to a string
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Class that builds an element tree that can be converted to a string
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
abstract class attribute_format {

    /**
     * Used to convert this class to an "element" which can be converted to a string.
     * @return element
     */
    abstract public function determine_format();

    /**
     * Convert this to an element and then to a string
     * @return string
     */
    public function __toString() {
        return $this->determine_format()->html();
    }
}

