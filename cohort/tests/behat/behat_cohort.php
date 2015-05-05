<?php

/**
 * Cohorts steps definitions.
 *
 * @package    core
 * @subpackage cohort
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given;

/**
 * Steps definitions for cohort actions.
 *
 */
class behat_cohort extends behat_base {

    /**
     * Adds the user to the specified cohort. The user should be specified like "Firstname Lastname (user@email.com)".
     *
     * @Given /^I add "(?P<user_fullname_string>(?:[^"]|\\")*)" user to "(?P<cohort_idnumber_string>(?:[^"]|\\")*)" cohort members$/
     * @param string $user
     * @param string $cohortidnumber
     */
    public function i_add_user_to_cohort_members($user, $cohortidnumber) {

        $steps = array(
            new Given('I click on "' . get_string('assign', 'cohort') . '" "link" in the "' . $this->escape($cohortidnumber) . '" "table_row"'),
            new Given('I set the field "' . get_string('potusers', 'cohort') . '" to "' . $this->escape($user) . '"'),
            new Given('I press "' . get_string('add') . '"'),
            new Given('I press "' . get_string('backtocohorts', 'cohort') . '"')
        );

        // If we are not in the cohorts management we should move there before anything else.
        if (!$this->getSession()->getPage()->find('css', 'input#cohort_search_q')) {

            // With JS enabled we should expand a few tree nodes.
            if ($this->running_javascript()) {
                $parentnodes = get_string('administrationsite') . ' > ' .
                    get_string('users', 'admin') . ' > ' .
                    get_string('accounts', 'admin');
                $steps = array_merge(
                    array(
                        new Given('I am on homepage'),
                        new Given('I navigate to "' . get_string('cohorts', 'cohort') . '" node in "' . $parentnodes . '"')
                    ),
                    $steps
                );

            } else {
                // JS disabled.
                $steps = array_merge(
                    array(
                        new Given('I am on homepage'),
                        new Given('I follow "' . get_string('administrationsite') . '" node'),
                        new Given('I follow "' . get_string('cohorts', 'cohort') . '"')
                    ),
                    $steps
                );
            }
        }

        return $steps;
    }
}
