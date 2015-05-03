<?php

/**
 * Behat question-related helper code.
 *
 * @package    core_question
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Gherkin\Node\TableNode as TableNode,
    Behat\Mink\Exception\ExpectationException as ExpectationException,
    Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException;

/**
 * Steps definitions related with the question bank management.
 *
 * @package    core_question
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class behat_question_base extends behat_base {

    /**
     * Helper used by {@link i_add_a_question_filling_the_form_with()} and
     * {@link behat_mod_quiz::i_add_question_to_the_quiz_with to finish creating()}.
     *
     * @param string $questiontypename The question type name
     * @param TableNode $questiondata The data to fill the question type form
     * @return Given[] the steps.
     */
    protected function finish_adding_question($questiontypename, TableNode $questiondata) {

        return array(
            new Given('I set the field "' . $this->escape($questiontypename) . '" to "1"'),
            new Given('I click on ".submitbutton" "css_element"'),
            new Given('I set the following fields to these values:', $questiondata),
            new Given('I press "id_submitbutton"')
        );
    }
}
