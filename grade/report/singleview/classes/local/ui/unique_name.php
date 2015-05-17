<?php


/**
 * A form element with a name field.
 *
 * @package    grade_report
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * A form element with a name field.
 *
 */
interface unique_name {

    /**
     * Get the name for this form element
     * @return string
     */
    public function get_name();
}
