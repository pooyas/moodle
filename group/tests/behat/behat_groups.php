<?php

/**
 * Behat groups-related steps definitions.
 *
 * @package    core_group
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../lib/behat/behat_base.php');

use Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException;

/**
 * Groups-related steps definitions.
 *
 * @package    core_group
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class behat_groups extends behat_base {

    /**
     * Add the specified user to the group. You should be in the groups page when running this step. The user should be specified like "Firstname Lastname (user@email.com)".
     *
     * @Given /^I add "(?P<user_fullname_string>(?:[^"]|\\")*)" user to "(?P<group_name_string>(?:[^"]|\\")*)" group members$/
     * @throws ElementNotFoundException Thrown by behat_base::find
     * @param string $username
     * @param string $groupname
     */
    public function i_add_user_to_group_members($userfullname, $groupname) {

        $userfullname = $this->getSession()->getSelectorsHandler()->xpathLiteral($userfullname);

        // Using a xpath liternal to avoid problems with quotes and double quotes.
        $groupname = $this->getSession()->getSelectorsHandler()->xpathLiteral($groupname);

        // We don't know the option text as it contains the number of users in the group.
        $select = $this->find_field('groups');
        $xpath = "//select[@id='groups']/descendant::option[contains(., $groupname)]";
        $groupoption = $this->find('xpath', $xpath);
        $fulloption = $groupoption->getText();
        $select->selectOption($fulloption);

        // Here we don't need to wait for the AJAX response.
        $this->find_button(get_string('adduserstogroup', 'group'))->click();

        // Wait for add/remove members page to be loaded.
        $this->getSession()->wait(self::TIMEOUT * 1000, self::PAGE_READY_JS);

        // Getting the option and selecting it.
        $select = $this->find_field('addselect');
        $xpath = "//select[@id='addselect']/descendant::option[contains(., $userfullname)]";
        $memberoption = $this->find('xpath', $xpath);
        $fulloption = $memberoption->getText();
        $select->selectOption($fulloption);

        // Click add button.
        $this->find_button(get_string('add'))->click();

        // Wait for the page to load.
        $this->getSession()->wait(self::TIMEOUT * 1000, self::PAGE_READY_JS);

        // Returning to the main groups page.
        $this->find_button(get_string('backtogroups', 'group'))->click();
    }

}
