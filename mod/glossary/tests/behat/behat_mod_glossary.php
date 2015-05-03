<?php

/**
 * Steps definitions related with the glossary activity.
 *
 * @package    mod_glossary
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Gherkin\Node\TableNode as TableNode;

/**
 * Glossary-related steps definitions.
 *
 * @package    mod_glossary
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class behat_mod_glossary extends behat_base {

    /**
     * Adds an entry to the current glossary with the provided data. You should be in the glossary page.
     *
     * @Given /^I add a glossary entry with the following data:$/
     * @param TableNode $data
     */
    public function i_add_a_glossary_entry_with_the_following_data(TableNode $data) {
        return array(
            new Given('I press "' . get_string('addentry', 'mod_glossary') . '"'),
            new Given('I set the following fields to these values:', $data),
            new Given('I press "' . get_string('savechanges') . '"')
        );
    }

    /**
     * Adds a category with the specified name to the current glossary. You need to be in the glossary page.
     *
     * @Given /^I add a glossary entries category named "(?P<category_name_string>(?:[^"]|\\")*)"$/
     * @param string $categoryname Category name
     */
    public function i_add_a_glossary_entries_category_named($categoryname) {

        return array(
            new Given('I follow "' . get_string('categoryview', 'mod_glossary') . '"'),
            new Given('I press "' . get_string('editcategories', 'mod_glossary') . '"'),
            new Given('I press "' . get_string('add').' '.get_string('category', 'glossary') . '"'),
            new Given('I set the field "name" to "' . $this->escape($categoryname) . '"'),
            new Given('I press "' . get_string('savechanges') . '"'),
            new Given('I press "' . get_string('back', 'mod_glossary') . '"')
        );
    }
}
