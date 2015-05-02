<?php


/**
 * Form for blog preferences
 *
 * @package    lioncore
 * @subpackage blog
 * @copyright  2009 Nicolas Connault
 * 
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Lion page.
}

require_once($CFG->libdir.'/formslib.php');

class blog_preferences_form extends lionform {
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
