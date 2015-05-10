<?php

/**
 * Behat message-related steps definitions.
 *
 * @package    core
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException;

/**
 * Messaging system steps definitions.
 *
 */
class behat_message extends behat_base {

    /**
     * Sends a message to the specified user from the logged user. The user full name should contain the first and last names.
     *
     * @Given /^I send "(?P<message_contents_string>(?:[^"]|\\")*)" message to "(?P<user_full_name_string>(?:[^"]|\\")*)" user$/
     * @param string $messagecontent
     * @param string $userfullname
     */
    public function i_send_message_to_user($messagecontent, $userfullname) {

        $steps = array();
        $steps[] = new Given('I am on homepage');

        $steps[] = new Given('I navigate to "' . get_string('messages', 'message') . '" node in "' . get_string('myprofile') . '"');
        $steps[] = new Given('I set the field "' . get_string('searchcombined', 'message') .
            '" to "' . $this->escape($userfullname) . '"');
        $steps[] = new Given('I press "' . get_string('searchcombined', 'message') . '"');
        $steps[] = new Given('I follow "' . $this->escape(get_string('sendmessageto', 'message', $userfullname)) . '"');
        $steps[] = new Given('I set the field "id_message" to "' . $this->escape($messagecontent) . '"');
        $steps[] = new Given('I press "' . get_string('sendmessage', 'message') . '"');

        return $steps;
    }

}
