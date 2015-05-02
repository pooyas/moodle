<?php

/**
 * Behat grade related steps definitions.
 *
 * @package    core_grades
 * @category   test
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Gherkin\Node\TableNode as TableNode;

class behat_grade extends behat_base {

    /**
     * Enters a grade via the gradebook for a specific grade item and user when viewing the 'Grader report' with editing mode turned on.
     *
     * @Given /^I give the grade "(?P<grade_number>(?:[^"]|\\")*)" to the user "(?P<username_string>(?:[^"]|\\")*)" for the grade item "(?P<grade_activity_string>(?:[^"]|\\")*)"$/
     * @param int $grade
     * @param string $userfullname the user's fullname as returned by fullname()
     * @param string $itemname
     * @return Given
     */
    public function i_give_the_grade($grade, $userfullname, $itemname) {
        $gradelabel = $userfullname . ' ' . $itemname;
        $fieldstr = get_string('useractivitygrade', 'gradereport_grader', $gradelabel);

        return new Given('I set the field "' . $this->escape($fieldstr) . '" to "' . $grade . '"');
    }

    /**
     * Changes the settings of a grade item or category or the course.
     *
     * Teacher must be either on the grade setup page or on the Grader report page with editing mode turned on.
     *
     * @Given /^I set the following settings for grade item "(?P<grade_item_string>(?:[^"]|\\")*)":$/
     * @param string $gradeitem
     * @param TableNode $data
     * @return Given[]
     */
    public function i_set_the_following_settings_for_grade_item($gradeitem, TableNode $data) {

        $steps = array();
        $gradeitem = $this->getSession()->getSelectorsHandler()->xpathLiteral($gradeitem);

        if ($this->running_javascript()) {
            $xpath = "//tr[contains(.,$gradeitem)]//*[contains(@class,'lion-actionmenu')]//a[contains(@class,'toggle-display')]";
            if ($this->getSession()->getPage()->findAll('xpath', $xpath)) {
                $steps[] = new Given('I click on "' . $this->escape($xpath) . '" "xpath_element"');
            }
        }

        $savechanges = get_string('savechanges', 'grades');
        $edit = $this->getSession()->getSelectorsHandler()->xpathLiteral(get_string('edit') . '  ');
        $linkxpath = "//a[./img[starts-with(@title,$edit) and contains(@title,$gradeitem)]]";
        $steps[] = new Given('I click on "' . $this->escape($linkxpath) . '" "xpath_element"');
        $steps[] = new Given('I set the following fields to these values:', $data);
        $steps[] = new Given('I press "' . $this->escape($savechanges) . '"');
        return $steps;
    }

    /**
     * Resets the weights for the grade category
     *
     * Teacher must be on the grade setup page.
     *
     * @Given /^I reset weights for grade category "(?P<grade_item_string>(?:[^"]|\\")*)"$/
     * @param $gradeitem
     * @return array
     */
    public function i_reset_weights_for_grade_category($gradeitem) {

        $steps = array();

        if ($this->running_javascript()) {
            $gradeitemliteral = $this->getSession()->getSelectorsHandler()->xpathLiteral($gradeitem);
            $xpath = "//tr[contains(.,$gradeitemliteral)]//*[contains(@class,'lion-actionmenu')]//a[contains(@class,'toggle-display')]";
            if ($this->getSession()->getPage()->findAll('xpath', $xpath)) {
                $steps[] = new Given('I click on "' . $this->escape($xpath) . '" "xpath_element"');
            }
        }

        $linktext = get_string('resetweights', 'grades', (object)array('itemname' => $gradeitem));
        $steps[] = new Given('I click on "' . $this->escape($linktext) . '" "link"');
        return $steps;
    }
}
