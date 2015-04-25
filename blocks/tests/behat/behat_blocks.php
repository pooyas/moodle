<?php

/**
 * Steps definitions related with blocks.
 *
 * @package   core
 * @subpackage block
 * @category  phpunit
 * @copyright 2015 Pooya Saeedi
 */

// NOTE: no INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given;

/**
 * Blocks management steps definitions.
 *
 * @package    core_block
 * @category   test
 * @copyright  2012 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_blocks extends behat_base {

    /**
     * Adds the selected block. Editing mode must be previously enabled.
     *
     * @Given /^I add the "(?P<block_name_string>(?:[^"]|\\")*)" block$/
     * @param string $blockname
     */
    public function i_add_the_block($blockname) {
        $steps = new Given('I set the field "bui_addblock" to "' . $this->escape($blockname) . '"');

        // If we are running without javascript we need to submit the form.
        if (!$this->running_javascript()) {
            $steps = array(
                $steps,
                new Given('I click on "' . get_string('go') . '" "button" in the "#add_block" "css_element"')
            );
        }
        return $steps;
    }

    /**
     * Docks a block. Editing mode should be previously enabled.
     *
     * @Given /^I dock "(?P<block_name_string>(?:[^"]|\\")*)" block$/
     * @param string $blockname
     * @return Given
     */
    public function i_dock_block($blockname) {

        // Looking for both title and alt.
        $xpath = "//input[@type='image'][@title='" . get_string('dockblock', 'block', $blockname) . "' or @alt='" . get_string('addtodock', 'block') . "']";
        return new Given('I click on " ' . $xpath . '" "xpath_element" in the "' . $this->escape($blockname) . '" "block"');
    }

    /**
     * Opens a block's actions menu if it is not already opened.
     *
     * @Given /^I open the "(?P<block_name_string>(?:[^"]|\\")*)" blocks action menu$/
     * @throws DriverException The step is not available when Javascript is disabled
     * @param string $blockname
     * @return Given
     */
    public function i_open_the_blocks_action_menu($blockname) {

        if (!$this->running_javascript()) {
            // Action menu does not need to be open if Javascript is off.
            return;
        }

        // If it is already opened we do nothing.
        $blocknode = $this->get_text_selector_node('block', $blockname);
        if ($blocknode->hasClass('action-menu-shown')) {
            return;
        }

        return new Given('I click on "a[role=\'menuitem\']" "css_element" in the "' . $this->escape($blockname) . '" "block"');
    }

    /**
     * Clicks on Configure block for specified block. Page must be in editing mode.
     *
     * Argument block_name may be either the name of the block or CSS class of the block.
     *
     * @Given /^I configure the "(?P<block_name_string>(?:[^"]|\\")*)" block$/
     * @param string $blockname
     */
    public function i_configure_the_block($blockname) {
        // Note that since $blockname may be either block name or CSS class, we can not use the exact label of "Configure" link.
        return array(
            new Given('I open the "'.$this->escape($blockname).'" blocks action menu'),
            new Given('I click on "Configure" "link" in the "'.$this->escape($blockname).'" "block"')
        );
    }
}
