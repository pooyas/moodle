<?php

/**
 * Form for blog preferences
 *
 * @package    core
 * @subpackage blog
 * @copyright  2015 Pooya Saeedi
 */

// Note:
// Renaming required

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once($CFG->libdir.'/formslib.php');

class blog_preferences_form extends moodleform {
    public function definition() {
        global $USER, $CFG;

        $mform    =& $this->_form;
        $strpagesize = get_string('pagesize', 'blog');

        $mform->addElement('text', 'pagesize', $strpagesize);
        $mform->setType('pagesize', PARAM_INT);
        $mform->addRule('pagesize', null, 'numeric', null, 'client');
        $mform->setDefault('pagesize', 10);

        $this->add_action_buttons();
    }
}
