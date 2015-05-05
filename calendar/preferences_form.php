<?php


/**
 * The mform for settings user preferences
 *
 * @package    calendartype
 * @subpackage gregorian
 * @copyright  2015 Pooya Saeedi
 */

 /**
  * Always include formslib
  */
if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Lion page
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * The mform class for setting user preferences
 *
 * @copyright 2015 Pooya Saeedi
 * 
 */
class calendar_preferences_form extends lionform {

    function definition() {
        $mform = $this->_form;

        $options = array(
            '0'  =>             get_string('default', 'calendar'),
            CALENDAR_TF_12 =>   get_string('timeformat_12', 'calendar'),
            CALENDAR_TF_24 =>   get_string('timeformat_24', 'calendar')
        );
        $mform->addElement('select', 'timeformat', get_string('pref_timeformat', 'calendar'), $options);
        $mform->addHelpButton('timeformat', 'pref_timeformat', 'calendar');

        $options = array(
            0 => get_string('sunday', 'calendar'),
            1 => get_string('monday', 'calendar'),
            2 => get_string('tuesday', 'calendar'),
            3 => get_string('wednesday', 'calendar'),
            4 => get_string('thursday', 'calendar'),
            5 => get_string('friday', 'calendar'),
            6 => get_string('saturday', 'calendar')
        );
        $mform->addElement('select', 'startwday', get_string('pref_startwday', 'calendar'), $options);
        $mform->addHelpButton('startwday', 'pref_startwday', 'calendar');

        $options = array();
        for ($i=1; $i<=20; $i++) {
            $options[$i] = $i;
        }
        $mform->addElement('select', 'maxevents', get_string('pref_maxevents', 'calendar'), $options);
        $mform->addHelpButton('maxevents', 'pref_maxevents', 'calendar');

        $options = array();
        for ($i=1; $i<=99; $i++) {
            $options[$i] = $i;
        }
        $mform->addElement('select', 'lookahead', get_string('pref_lookahead', 'calendar'), $options);
        $mform->addHelpButton('lookahead', 'pref_lookahead', 'calendar');

        $options = array(
            0 => get_string('no'),
            1 => get_string('yes')
        );
        $mform->addElement('select', 'persistflt', get_string('pref_persistflt', 'calendar'), $options);
        $mform->addHelpButton('persistflt', 'pref_persistflt', 'calendar');

        $this->add_action_buttons(false, get_string('savechanges'));
    }

}