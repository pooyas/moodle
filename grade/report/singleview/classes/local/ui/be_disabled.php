<?php

/**
 * be_disabled interface.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Simple interface implemented to add behaviour that an element can be checked to see
 * if it should be disabled.
 */
interface be_disabled {
    /**
     * Am I disabled ?
     *
     * @return bool
     */
    public function is_disabled();
}
