<?php

/**
 * Self enrol plugin implementation.
 *
 * @package    enrol_self
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class enrol_self_enrol_form extends lionform {
    protected $instance;
    protected $toomany = false;

    /**
     * Overriding this function to get unique form id for multiple self enrolments.
     *
     * @return string form identifier
     */
    protected function get_form_identifier() {
        $formid = $this->_customdata->id.'_'.get_class($this);
        return $formid;
    }

    public function definition() {
        global $USER, $OUTPUT, $CFG;
        $mform = $this->_form;
        $instance = $this->_customdata;
        $this->instance = $instance;
        $plugin = enrol_get_plugin('self');

        $heading = $plugin->get_instance_name($instance);
        $mform->addElement('header', 'selfheader', $heading);

        if ($instance->password) {
            // Change the id of self enrolment key input as there can be multiple self enrolment methods.
            $mform->addElement('passwordunmask', 'enrolpassword', get_string('password', 'enrol_self'),
                    array('id' => 'enrolpassword_'.$instance->id));
            $context = context_course::instance($this->instance->courseid);
            $keyholders = get_users_by_capability($context, 'enrol/self:holdkey', user_picture::fields('u'));
            $keyholdercount = 0;
            foreach ($keyholders as $keyholder) {
                $keyholdercount++;
                if ($keyholdercount === 1) {
                    $mform->addElement('static', 'keyholder', '', get_string('keyholder', 'enrol_self'));
                }
                $keyholdercontext = context_user::instance($keyholder->id);
                if ($USER->id == $keyholder->id || has_capability('lion/user:viewdetails', context_system::instance()) ||
                        has_coursecontact_role($keyholder->id)) {
                    $profilelink = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $keyholder->id . '&amp;course=' .
                    $this->instance->courseid . '">' . fullname($keyholder) . '</a>';
                } else {
                    $profilelink = fullname($keyholder);
                }
                $profilepic = $OUTPUT->user_picture($keyholder, array('size' => 35, 'courseid' => $this->instance->courseid));
                $mform->addElement('static', 'keyholder'.$keyholdercount, '', $profilepic . $profilelink);
            }

        } else {
            $mform->addElement('static', 'nokey', '', get_string('nopassword', 'enrol_self'));
        }

        $this->add_action_buttons(false, get_string('enrolme', 'enrol_self'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $instance->courseid);

        $mform->addElement('hidden', 'instance');
        $mform->setType('instance', PARAM_INT);
        $mform->setDefault('instance', $instance->id);
    }

    public function validation($data, $files) {
        global $DB, $CFG;

        $errors = parent::validation($data, $files);
        $instance = $this->instance;

        if ($this->toomany) {
            $errors['notice'] = get_string('error');
            return $errors;
        }

        if ($instance->password) {
            if ($data['enrolpassword'] !== $instance->password) {
                if ($instance->customint1) {
                    $groups = $DB->get_records('groups', array('courseid'=>$instance->courseid), 'id ASC', 'id, enrolmentkey');
                    $found = false;
                    foreach ($groups as $group) {
                        if (empty($group->enrolmentkey)) {
                            continue;
                        }
                        if ($group->enrolmentkey === $data['enrolpassword']) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        // We can not hint because there are probably multiple passwords.
                        $errors['enrolpassword'] = get_string('passwordinvalid', 'enrol_self');
                    }

                } else {
                    $plugin = enrol_get_plugin('self');
                    if ($plugin->get_config('showhint')) {
                        $hint = core_text::substr($instance->password, 0, 1);
                        $errors['enrolpassword'] = get_string('passwordinvalidhint', 'enrol_self', $hint);
                    } else {
                        $errors['enrolpassword'] = get_string('passwordinvalid', 'enrol_self');
                    }
                }
            }
        }

        return $errors;
    }
}
