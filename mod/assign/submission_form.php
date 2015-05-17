<?php


/**
 * This file contains the submission form used by the assign module.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');


require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

/**
 * Assign submission form
 *
 */
class mod_assign_submission_form extends lionform {

    /**
     * Define this form - called by the parent constructor
     */
    public function definition() {
        $mform = $this->_form;

        list($assign, $data) = $this->_customdata;

        $assign->add_submission_form_elements($mform, $data);

        $this->add_action_buttons(true, get_string('savechanges', 'assign'));
        if ($data) {
            $this->set_data($data);
        }
    }
}

