<?php

/**
 * Behat question-related steps definitions.
 *
 * @package    core_question
 * @category   test
 * @copyright  2013 David Monllaó
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/behat_question_base.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Gherkin\Node\TableNode as TableNode,
    Behat\Mink\Exception\ExpectationException as ExpectationException,
    Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException;

/**
 * Steps definitions related with the question bank management.
 *
 * @package    core_question
 * @category   test
 * @copyright  2013 David Monllaó
 * 
 */
class behat_question extends behat_question_base {

    /**
     * Creates a question in the current course questions bank with the provided data. This step can only be used when creating question types composed by a single form.
     *
     * @Given /^I add a "(?P<question_type_name_string>(?:[^"]|\\")*)" question filling the form with:$/
     * @param string $questiontypename The question type name
     * @param TableNode $questiondata The data to fill the question type form.
     * @return Given[] the steps.
     */
    public function i_add_a_question_filling_the_form_with($questiontypename, TableNode $questiondata) {

        return array_merge(array(
            new Given('I follow "' . get_string('questionbank', 'question') . '"'),
            new Given('I press "' . get_string('createnewquestion', 'question') . '"'),
                ), $this->finish_adding_question($questiontypename, $questiondata));
    }

    /**
     * Checks the state of the specified question.
     *
     * @Then /^the state of "(?P<question_description_string>(?:[^"]|\\")*)" question is shown as "(?P<state_string>(?:[^"]|\\")*)"$/
     * @throws ExpectationException
     * @throws ElementNotFoundException
     * @param string $questiondescription
     * @param string $state
     */
    public function the_state_of_question_is_shown_as($questiondescription, $state) {

        // Using xpath literal to avoid quotes problems.
        $questiondescriptionliteral = $this->getSession()->getSelectorsHandler()->xpathLiteral($questiondescription);
        $stateliteral = $this->getSession()->getSelectorsHandler()->xpathLiteral($state);

        // Split in two checkings to give more feedback in case of exception.
        $exception = new ElementNotFoundException($this->getSession(), 'Question "' . $questiondescription . '" ');
        $questionxpath = "//div[contains(concat(' ', normalize-space(@class), ' '), ' que ')]" .
                "[contains(div[@class='content']/div[@class='formulation'], {$questiondescriptionliteral})]";
        $this->find('xpath', $questionxpath, $exception);

        $exception = new ExpectationException('Question "' . $questiondescription . '" state is not "' . $state . '"', $this->getSession());
        $xpath = $questionxpath . "/div[@class='info']/div[@class='state' and contains(., {$stateliteral})]";
        $this->find('xpath', $xpath, $exception);
    }
}
