<?php

/**
 * Interface for a list of selectable things.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

namespace gradereport_singleview\local\screen;

defined('LION_INTERNAL') || die;

/**
 * Interface for a list of selectable things.
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */
interface selectable_items {
    /**
     * Get the description of this list
     * @return string
     */
    public function description();

    /**
     * Get the label for the select box that chooses items for this page.
     * @return string
     */
    public function select_label();

    /**
     * Get the list of options to show.
     * @return array
     */
    public function options();

    /**
     * Get type of things in the list (gradeitem or user)
     * @return string
     */
    public function item_type();
}
