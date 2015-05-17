<?php


/**
 * Transfer form
 *
 * @package    admin_tool
 * @subpackage dbtransfer
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');


/**
 * Definition of db export settings form.
 *
 */
class database_export_form extends lionform {
    /**
     * Define the export form.
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('header', 'database', get_string('dbexport', 'tool_dbtransfer'));
        $mform->addElement('textarea', 'description', get_string('description'), array('rows'=>5, 'cols'=>60));
        $mform->setType('description', PARAM_TEXT);

        $this->add_action_buttons(false, get_string('exportdata', 'tool_dbtransfer'));
    }
}
