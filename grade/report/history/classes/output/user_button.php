<?php

/**
 * User button. Adapted from core_select_user_button.
 *
 * @package    gradereport
 * @subpackage history
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_history\output;

defined('LION_INTERNAL') || die;

/**
 * A button that is used to select users for a form.
 *
 * 
 */
class user_button extends \single_button implements \renderable {
    /**
     * Initialises the new select_user_button.
     *
     * @param \lion_url $url
     * @param string $label The text to display in the button
     * @param string $method Either post or get
     */
    public function __construct(\lion_url $url, $label, $method = 'post') {
        parent::__construct($url, $label, $method);
        $this->class = 'singlebutton selectusersbutton gradereport_history_plugin';
        $this->formid = \html_writer::random_id('selectusersbutton');
    }
}
