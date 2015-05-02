<?php

/**
 * The gradebook interface for a filterable class.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\screen;

defined('LION_INTERNAL') || die;

/**
 * The gradebook interface for a filterable class.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
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
