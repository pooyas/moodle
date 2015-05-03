<?php

/**
 * Steps definitions for choice activity.
 *
 * @package   mod_choice
 * @category  test
 * @copyright 2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given;

/**
 * Choice activity definitions.
 *
 * @package   mod_choice
 * @category  test
 * @copyright 2015 Pooya Saeedi
 * 
 */
class behat_mod_choice extends behat_base {

    /**
     * Chooses the specified option from the choice activity named as specified. You should be located in the activity's course page.
     *
     * @Given /^I choose "(?P<option_string>(?:[^"]|\\")*)" from "(?P<choice_activity_string>(?:[^"]|\\")*)" choice activity$/
     * @param string $option
     * @param string $choiceactivity
     * @return array
     */
    public function I_choose_option_from_activity($option, $choiceactivity) {

        // Escaping again the strings as backslashes have been removed by the automatic transformation.
        return array(
            new Given('I follow "' . $this->escape($choiceactivity) . '"'),
            new Given('I set the field "' . $this->escape($option) . '" to "1"'),
            new Given('I press "' . get_string('savemychoice', 'choice') . '"')
        );
    }

    /**
     * Chooses the specified option from the choice activity named as specified and save the choice.
     * You should be located in the activity's course page.
     *
     * @Given /^I choose options (?P<option_string>"(?:[^"]|\\")*"(?:,"(?:[^"]|\\")*")*) from "(?P<choice_activity_string>(?:[^"]|\\")*)" choice activity$/
     * @param string $option
     * @param string $choiceactivity
     * @return array
     */
    public function I_choose_options_from_activity($option, $choiceactivity) {
        // Escaping again the strings as backslashes have been removed by the automatic transformation.
        $return = array(new Given('I follow "' . $this->escape($choiceactivity) . '"'));
        $options = explode('","', trim($option, '"'));
        foreach ($options as $option) {
            $return[] = new Given('I set the field "' . $this->escape($option) . '" to "1"');
        }
        $return[] = new Given('I press "' . get_string('savemychoice', 'choice') . '"');
        return $return;
    }

}
