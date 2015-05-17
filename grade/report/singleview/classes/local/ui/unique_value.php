<?php


/**
 * The gradebook simple view - UI factory
 *
 * @package    grade_report
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Simple interface for an item with a value.
 *
 */
interface unique_value {
    /**
     * Get the value for this item.
     * @return string
     */
    public function get_value();
}
