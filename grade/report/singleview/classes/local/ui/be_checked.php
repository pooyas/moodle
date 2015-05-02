<?php

/**
 * Is this thing checked?
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Is this thing checked?
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
interface be_checked {
    /**
     * Return true if this is checked.
     * @return bool
     */
    public function is_checked();
}
