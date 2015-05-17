<?php


/**
 * Interface for a list of selectable things.
 *
 * @package    grade_report
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 */

namespace gradereport_singleview\local\screen;

defined('LION_INTERNAL') || die;

/**
 * Interface for a list of selectable things.
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
