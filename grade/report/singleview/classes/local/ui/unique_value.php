<?php

/**
 * The gradebook simple view - UI factory
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Simple interface for an item with a value.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
interface unique_value {
    /**
     * Get the value for this item.
     * @return string
     */
    public function get_value();
}
