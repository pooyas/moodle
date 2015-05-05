<?php

/**
 * The gradebook interface for a filterable class.
 *
 * @package    gradereport
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_singleview\local\screen;

defined('LION_INTERNAL') || die;

/**
 * The gradebook interface for a filterable class.
 *
 */
interface filterable_items {

    /**
     * Return true/false if this item should be filtered.
     * @param mixed $item (user or grade_item)
     * @return bool
     */
    public static function filter($item);
}
