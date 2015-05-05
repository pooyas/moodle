<?php

/**
 * Is this thing checked?
 *
 * @package    gradereport
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Is this thing checked?
 *
 */
interface be_checked {
    /**
     * Return true if this is checked.
     * @return bool
     */
    public function is_checked();
}
