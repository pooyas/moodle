<?php


/**
 * A form for creating and editing groupings.
 *
 * @package    core
 * @subpackage group
 * @copyright  2015 Pooya Saeedi
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Lion page
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Grouping form class
 *
 */
class grouping_form extends lionform {

    /**
     * Form definition
     */
    function definition () {
        global $USER, $CFG, $COURSE;
        $coursecontext = context_course::instance($COURSE->id);

        $mform =& $this->_form;
        $editoroptions = $this->_customdata['editoroptions'];

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text','name', get_string('groupingname', 'group'),'maxlength="254" size="50"');
        $mform->addRule('name', get_string('required'), 'required', null, 'server');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('text','idnumber', get_string('idnumbergrouping'), 'maxlength="100" size="10"');
        $mform->addHelpButton('idnumber', 'idnumbergrouping');
        $mform->setType('idnumber', PARAM_RAW);
        if (!has_capability('lion/course:changeidnumber', $coursecontext)) {
            $mform->hardFreeze('idnumber');
        }

        $mform->addElement('editor', 'description_editor', get_string('groupingdescription', 'group'), null, $editoroptions);
        $mform->setType('description_editor', PARAM_RAW);

        $mform->addElement('hidden','id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons();
    }

    /**
     * Form validation
     *
     * @param array $data
     * @param array $files
     * @return array $errors An array of validataion errors for the form.
     */
    function validation($data, $files) {
        global $COURSE, $DB;

        $errors = parent::validation($data, $files);

        $name = trim($data['name']);
        if (isset($data['idnumber'])) {
            $idnumber = trim($data['idnumber']);
        } else {
            $idnumber = '';
        }
        if ($data['id'] and $grouping = $DB->get_record('groupings', array('id'=>$data['id']))) {
            if (core_text::strtolower($grouping->name) != core_text::strtolower($name)) {
                if (groups_get_grouping_by_name($COURSE->id,  $name)) {
                    $errors['name'] = get_string('groupingnameexists', 'group', $name);
                }
            }
            if (!empty($idnumber) && $grouping->idnumber != $idnumber) {
                if (groups_get_grouping_by_idnumber($COURSE->id, $idnumber)) {
                    $errors['idnumber']= get_string('idnumbertaken');
                }
            }

        } else if (groups_get_grouping_by_name($COURSE->id, $name)) {
            $errors['name'] = get_string('groupingnameexists', 'group', $name);
        } else if (!empty($idnumber) && groups_get_grouping_by_idnumber($COURSE->id, $idnumber)) {
            $errors['idnumber']= get_string('idnumbertaken');
        }

        return $errors;
    }

}
