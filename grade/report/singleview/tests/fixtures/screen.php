<?php

/**
 * Fixtures for single view report screen class testing.
 *
 * @package    gradereport
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

class gradereport_singleview_screen_testable extends \gradereport_singleview\local\screen\screen {

    /**
     * Wrapper to make protected method accessible during testing.
     *
     * @return array returns array of users.
     */
    public function test_load_users() {
        return $this->load_users();
    }

    /**
     * Return the HTML for the page.
     */
    public function init($selfitemisempty = false) {}

    /**
     * Get the type of items on this screen, not valid so return false.
     */
    public function item_type() {}

    /**
     * Return the HTML for the page.
     */
    public function html() {}
}
