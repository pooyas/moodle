<?php


/**
 * Element that just generates some text.
 *
 * @package    grade_report
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 */

namespace gradereport_singleview\local\ui;

defined('LION_INTERNAL') || die;

/**
 * Element that just generates some text.
 *
 */
class empty_element extends element {

    /**
     * Constructor
     *
     * @param string $msg The text
     */
    public function __construct($msg = null) {
        if (is_null($msg)) {
            $this->text = '&nbsp;';
        } else {
            $this->text = $msg;
        }
    }

    /**
     * Generate the html (simple case)
     *
     * @return string HTML
     */
    public function html() {
        return $this->text;
    }
}
