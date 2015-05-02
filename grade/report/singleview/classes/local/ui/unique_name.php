<?php

/**
 * A form element with a name field.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * A form element with a name field.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
interface unique_name {

    /**
     * Get the name for this form element
     * @return string
     */
    public function get_name();
}
