<?php


/**
 * be_disabled interface.
 *
 * @package    grade_report
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
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
