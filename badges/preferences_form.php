<?php

/**
 * Form class for editing badges preferences.
 *
 * @package    core
 * @subpackage badges
 * @copyright  2013 onwards Totara Learning Solutions Ltd {@link http://www.totaralms.com/}
 * 
 * @author     Yuliya Bozhko <yuliya.bozhko@totaralms.com>
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once($CFG->libdir . '/formslib.php');

class badges_preferences_form extends lionform {
    public function definition() {
        global $USER, $CFG;

        $mform =& $this->_form;

        $mform->addElement('header', 'badgeprivacy', get_string('badgeprivacysetting', 'badges'));
        $mform->addElement('advcheckbox', 'badgeprivacysetting', '', get_string('badgeprivacysetting_str', 'badges'));
        $mform->setType('badgeprivacysetting', PARAM_INT);
        $mform->setDefault('badgeprivacysetting', 1);
        $mform->addHelpButton('badgeprivacy', 'badgeprivacysetting', 'badges');

        $this->add_action_buttons();
    }
}
