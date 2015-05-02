<?php

/**
 * Steps definitions related with the database activity.
 *
 * @package    mod_data
 * @category   test
 * @copyright  2014 David Monllaó
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Behat\Context\Step\When as When,
    Behat\Gherkin\Node\TableNode as TableNode;
/**
 * Database-related steps definitions.
 *
 * @package    mod_data
 * @category   test
 * @copyright  2014 David Monllaó
 * 
 */
class behat_mod_data extends behat_base {

    /**
     * Adds a new field to a database
     *
     * @Given /^I add a "(?P<fieldtype_string>(?:[^"]|\\")*)" field to "(?P<activityname_string>(?:[^"]|\\")*)" database and I fill the form with:$/
     *
     * @param string $fieldtype
     * @param string $activityname
     * @param TableNode $fielddata
     * @return Given[]
     */
    public function i_add_a_field_to_database_and_i_fill_the_form_with($fieldtype, $activityname, TableNode $fielddata) {

        $steps = array(
            new Given('I follow "' . $this->escape($activityname) . '"'),
            new Given('I follow "' . get_string('fields', 'mod_data') . '"'),
            new Given('I set the field "newtype" to "' . $this->escape($fieldtype) . '"')
        );

        if (!$this->running_javascript()) {
            $steps[] = new Given('I click on "' . get_string('go') . '" "button" in the ".fieldadd" "css_element"');
        }

        array_push(
            $steps,
            new Given('I set the following fields to these values:', $fielddata),
            new Given('I press "' . get_string('add') . '"')
        );

        return $steps;
    }

    /**
     * Adds an entry to a database.
     *
     * @Given /^I add an entry to "(?P<activityname_string>(?:[^"]|\\")*)" database with:$/
     *
     * @param string $activityname
     * @param TableNode $entrydata
     * @return When[]
     */
    public function i_add_an_entry_to_database_with($activityname, TableNode $entrydata) {

        return array(
            new When('I follow "' . $this->escape($activityname) . '"'),
            new When('I follow "' . get_string('add', 'mod_data') . '"'),
            new When('I set the following fields to these values:', $entrydata),
        );
    }
}
