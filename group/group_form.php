<?php


/**
 * A form for the creation and editing of groups.
 *
 * @package    core
 * @subpackage group
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Group form class
 *
 */
class group_form extends lionform {

    /**
     * Definition of the form
     */
    function definition () {
        global $USER, $CFG, $COURSE;
        $coursecontext = context_course::instance($COURSE->id);

        $mform =& $this->_form;
        $editoroptions = $this->_customdata['editoroptions'];

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text','name', get_string('groupname', 'group'),'maxlength="254" size="50"');
        $mform->addRule('name', get_string('required'), 'required', null, 'client');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('text','idnumber', get_string('idnumbergroup'), 'maxlength="100" size="10"');
        $mform->addHelpButton('idnumber', 'idnumbergroup');
        $mform->setType('idnumber', PARAM_RAW);
        if (!has_capability('lion/course:changeidnumber', $coursecontext)) {
            $mform->hardFreeze('idnumber');
        }

        $mform->addElement('editor', 'description_editor', get_string('groupdescription', 'group'), null, $editoroptions);
        $mform->setType('description_editor', PARAM_RAW);

        $mform->addElement('passwordunmask', 'enrolmentkey', get_string('enrolmentkey', 'group'), 'maxlength="254" size="24"', get_string('enrolmentkey', 'group'));
        $mform->addHelpButton('enrolmentkey', 'enrolmentkey', 'group');
        $mform->setType('enrolmentkey', PARAM_RAW);

        $mform->addElement('static', 'currentpicture', get_string('currentpicture'));

        $mform->addElement('checkbox', 'deletepicture', get_string('delete'));
        $mform->setDefault('deletepicture', 0);

        $options = array(get_string('no'), get_string('yes'));
        $mform->addElement('select', 'hidepicture', get_string('hidepicture'), $options);

        $mform->addElement('filepicker', 'imagefile', get_string('newpicture', 'group'));
        $mform->addHelpButton('imagefile', 'newpicture', 'group');

        $mform->addElement('hidden','id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden','courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons();
    }

    /**
     * Extend the form definition after the data has been parsed.
     */
    public function definition_after_data() {
        global $COURSE, $DB;

        $mform = $this->_form;
        $groupid = $mform->getElementValue('id');

        if ($group = $DB->get_record('groups', array('id' => $groupid))) {

            // Print picture.
            if (!($pic = print_group_picture($group, $COURSE->id, true, true, false))) {
                $pic = get_string('none');
                if ($mform->elementExists('deletepicture')) {
                    $mform->removeElement('deletepicture');
                }
            }
            $imageelement = $mform->getElement('currentpicture');
            $imageelement->setValue($pic);
        } else {
            if ($mform->elementExists('currentpicture')) {
                $mform->removeElement('currentpicture');
            }
            if ($mform->elementExists('deletepicture')) {
                $mform->removeElement('deletepicture');
            }
        }

    }

    /**
     * Form validation
     *
     * @param array $data
     * @param array $files
     * @return array $errors An array of errors
     */
    function validation($data, $files) {
        global $COURSE, $DB, $CFG;

        $errors = parent::validation($data, $files);

        $name = trim($data['name']);
        if (isset($data['idnumber'])) {
            $idnumber = trim($data['idnumber']);
        } else {
            $idnumber = '';
        }
        if ($data['id'] and $group = $DB->get_record('groups', array('id'=>$data['id']))) {
            if (core_text::strtolower($group->name) != core_text::strtolower($name)) {
                if (groups_get_group_by_name($COURSE->id,  $name)) {
                    $errors['name'] = get_string('groupnameexists', 'group', $name);
                }
            }
            if (!empty($idnumber) && $group->idnumber != $idnumber) {
                if (groups_get_group_by_idnumber($COURSE->id, $idnumber)) {
                    $errors['idnumber']= get_string('idnumbertaken');
                }
            }

            if ($data['enrolmentkey'] != '') {
                $errmsg = '';
                if (!empty($CFG->groupenrolmentkeypolicy) && $group->enrolmentkey !== $data['enrolmentkey']
                        && !check_password_policy($data['enrolmentkey'], $errmsg)) {
                    // Enforce password policy when the password is changed.
                    $errors['enrolmentkey'] = $errmsg;
                } else {
                    // Prevent twice the same enrolment key in course groups.
                    $sql = "SELECT id FROM {groups} WHERE id <> :groupid AND courseid = :courseid AND enrolmentkey = :key";
                    $params = array('groupid' => $data['id'], 'courseid' => $COURSE->id, 'key' => $data['enrolmentkey']);
                    if ($DB->record_exists_sql($sql, $params)) {
                        $errors['enrolmentkey'] = get_string('enrolmentkeyalreadyinuse', 'group');
                    }
                }
            }

        } else if (groups_get_group_by_name($COURSE->id, $name)) {
            $errors['name'] = get_string('groupnameexists', 'group', $name);
        } else if (!empty($idnumber) && groups_get_group_by_idnumber($COURSE->id, $idnumber)) {
            $errors['idnumber']= get_string('idnumbertaken');
        } else if ($data['enrolmentkey'] != '') {
            $errmsg = '';
            if (!empty($CFG->groupenrolmentkeypolicy) && !check_password_policy($data['enrolmentkey'], $errmsg)) {
                // Enforce password policy.
                $errors['enrolmentkey'] = $errmsg;
            } else if ($DB->record_exists('groups', array('courseid' => $COURSE->id, 'enrolmentkey' => $data['enrolmentkey']))) {
                // Prevent the same enrolment key from being used multiple times in course groups.
                $errors['enrolmentkey'] = get_string('enrolmentkeyalreadyinuse', 'group');
            }
        }

        return $errors;
    }

    /**
     * Get editor options for this form
     *
     * @return array An array of options
     */
    function get_editor_options() {
        return $this->_customdata['editoroptions'];
    }
}
