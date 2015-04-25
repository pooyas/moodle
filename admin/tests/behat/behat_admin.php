<?php

/**
 * Steps definitions related with administration.
 *
 * @package   core_admin
 * @category  test
 * @copyright 2015 Pooya Saeedi
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../lib/behat/behat_base.php');
require_once(__DIR__ . '/../../../lib/behat/behat_field_manager.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Gherkin\Node\TableNode as TableNode,
    Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException;

/**
 * Site administration level steps definitions.
 *
 * @package    core_admin
 * @category   test
 * @copyright  2013 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_admin extends behat_base {

    /**
     * Sets the specified site settings. A table with | Setting label | value | is expected.
     *
     * @Given /^I set the following administration settings values:$/
     * @param TableNode $table
     */
    public function i_set_the_following_administration_settings_values(TableNode $table) {

        if (!$data = $table->getRowsHash()) {
            return;
        }

        foreach ($data as $label => $value) {

            // We expect admin block to be visible, otherwise go to homepage.
            if (!$this->getSession()->getPage()->find('css', '.block_settings')) {
                $this->getSession()->visit($this->locate_path('/'));
                $this->wait(self::TIMEOUT * 1000, self::PAGE_READY_JS);
            }

            // Search by label.
            $searchbox = $this->find_field(get_string('searchinsettings', 'admin'));
            $searchbox->setValue($label);
            $submitsearch = $this->find('css', 'form.adminsearchform input[type=submit]');
            $submitsearch->press();

            $this->wait(self::TIMEOUT * 1000, self::PAGE_READY_JS);

            // Admin settings does not use the same DOM structure than other lion forms
            // but we also need to use lib/behat/form_field/* to deal with the different lion form elements.
            $exception = new ElementNotFoundException($this->getSession(), '"' . $label . '" administration setting ');

            // The argument should be converted to an xpath literal.
            $label = $this->getSession()->getSelectorsHandler()->xpathLiteral($label);

            // Single element settings.
            try {
                $fieldxpath = "//*[self::input | self::textarea | self::select][not(./@type = 'submit' or ./@type = 'image' or ./@type = 'hidden')]" .
                    "[@id=//label[contains(normalize-space(.), $label)]/@for or " .
                    "@id=//span[contains(normalize-space(.), $label)]/preceding-sibling::label[1]/@for]";
                $fieldnode = $this->find('xpath', $fieldxpath, $exception);

                $formfieldtypenode = $this->find('xpath', $fieldxpath . "/ancestor::div[@class='form-setting']" .
                    "/child::div[contains(concat(' ', @class, ' '),  ' form-')]/child::*/parent::div");

            } catch (ElementNotFoundException $e) {

                // Multi element settings, interacting only the first one.
                $fieldxpath = "//*[label[.= $label]|span[.= $label]]/ancestor::div[contains(concat(' ', normalize-space(@class), ' '), ' form-item ')]" .
                    "/descendant::div[@class='form-group']/descendant::*[self::input | self::textarea | self::select][not(./@type = 'submit' or ./@type = 'image' or ./@type = 'hidden')]";
                $fieldnode = $this->find('xpath', $fieldxpath);

                // It is the same one that contains the type.
                $formfieldtypenode = $fieldnode;
            }

            // Getting the class which contains the field type.
            $classes = explode(' ', $formfieldtypenode->getAttribute('class'));
            foreach ($classes as $class) {
                if (substr($class, 0, 5) == 'form-') {
                    $type = substr($class, 5);
                }
            }

            // Instantiating the appropiate field type.
            $field = behat_field_manager::get_field_instance($type, $fieldnode, $this->getSession());
            $field->set_value($value);

            $this->find_button(get_string('savechanges'))->press();
        }
    }

    /**
     * Waits with the provided params if we are running a JS session.
     *
     * @param int $timeout
     * @param string $javascript
     * @return void
     */
    protected function wait($timeout, $javascript = false) {
        if ($this->running_javascript()) {
            $this->getSession()->wait($timeout, $javascript);
        }
    }
}
