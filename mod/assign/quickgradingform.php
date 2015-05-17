<?php


/**
 * This file contains the forms to create and edit an instance of this module
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');


require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

/**
 * Assignment quick grading form
 *
 */
class mod_assign_quick_grading_form extends lionform {
    /**
     * Define this form - called from the parent constructor
     */
    public function definition() {
        $mform = $this->_form;
        $instance = $this->_customdata;

        // Visible elements.
        $mform->addElement('html', $instance['gradingtable']);

        // Hidden params.
        $mform->addElement('hidden', 'id', $instance['cm']);
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'action', 'quickgrade');
        $mform->setType('action', PARAM_ALPHA);
        $mform->addElement('hidden', 'lastpage', $instance['page']);
        $mform->setType('lastpage', PARAM_INT);

        // Skip notifications option.
        $mform->addElement('selectyesno', 'sendstudentnotifications', get_string('sendstudentnotifications', 'assign'));
        $mform->setDefault('sendstudentnotifications', $instance['sendstudentnotifications']);

        // Buttons.
        $savemessage = get_string('saveallquickgradingchanges', 'assign');
        $mform->addElement('submit', 'savequickgrades', $savemessage);
    }
}

