<?php


/**
 * form for bulk user multi cohort add
 *
 * @package    admin
 * @subpackage user
 * @copyright  2015 Pooya Saeedi
 */
defined('LION_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class user_bulk_cohortadd_form extends lionform {
    function definition() {
        $mform = $this->_form;
        $cohorts = $this->_customdata;

        $mform->addElement('select', 'cohort', get_string('cohort', 'core_cohort'), $cohorts);
        $mform->addRule('cohort', get_string('required'), 'required', null, 'client');

        $this->add_action_buttons(true, get_string('bulkadd', 'core_cohort'));
    }
}
