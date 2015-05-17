<?php


/**
 * Adds instance form
 *
 * @package    enrol
 * @subpackage meta
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class enrol_meta_addinstance_form extends lionform {
    protected $course;

    function definition() {
        global $CFG, $DB;

        $mform  = $this->_form;
        $course = $this->_customdata;
        $this->course = $course;

        $existing = $DB->get_records('enrol', array('enrol'=>'meta', 'courseid'=>$course->id), '', 'customint1, id');

        // TODO: this has to be done via ajax or else it will fail very badly on large sites!
        $courses = array('' => get_string('choosedots'));
        $select = ', ' . context_helper::get_preload_record_columns_sql('ctx');
        $join = "LEFT JOIN {context} ctx ON (ctx.instanceid = c.id AND ctx.contextlevel = :contextlevel)";

        $plugin = enrol_get_plugin('meta');
        $sortorder = 'c.' . $plugin->get_config('coursesort', 'sortorder') . ' ASC';

        $sql = "SELECT c.id, c.fullname, c.shortname, c.visible $select FROM {course} c $join ORDER BY " . $sortorder;
        $rs = $DB->get_recordset_sql($sql, array('contextlevel' => CONTEXT_COURSE));
        foreach ($rs as $c) {
            if ($c->id == SITEID or $c->id == $course->id or isset($existing[$c->id])) {
                continue;
            }
            context_helper::preload_from_record($c);
            $coursecontext = context_course::instance($c->id);
            if (!$c->visible and !has_capability('lion/course:viewhiddencourses', $coursecontext)) {
                continue;
            }
            if (!has_capability('enrol/meta:selectaslinked', $coursecontext)) {
                continue;
            }
            $courses[$c->id] = $coursecontext->get_context_name(false);
        }
        $rs->close();

        $mform->addElement('header','general', get_string('pluginname', 'enrol_meta'));

        $mform->addElement('select', 'link', get_string('linkedcourse', 'enrol_meta'), $courses);
        $mform->addRule('link', get_string('required'), 'required', null, 'client');

        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

        $this->add_add_buttons();

        $this->set_data(array('id'=>$course->id));
    }

    /**
     * Adds buttons on create new method form
     */
    protected function add_add_buttons() {
        $mform = $this->_form;
        $buttonarray = array();
        $buttonarray[0] = $mform->createElement('submit', 'submitbutton', get_string('addinstance', 'enrol'));
        $buttonarray[1] = $mform->createElement('submit', 'submitbuttonnext', get_string('addinstanceanother', 'enrol'));
        $buttonarray[2] = $mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');
    }

    function validation($data, $files) {
        global $DB, $CFG;

        // TODO: this is duplicated here because it may be necessary once we implement ajax course selection element

        $errors = parent::validation($data, $files);
        if (!$c = $DB->get_record('course', array('id'=>$data['link']))) {
            $errors['link'] = get_string('required');
        } else {
            $coursecontext = context_course::instance($c->id);
            $existing = $DB->get_records('enrol', array('enrol'=>'meta', 'courseid'=>$this->course->id), '', 'customint1, id');
            if (!$c->visible and !has_capability('lion/course:viewhiddencourses', $coursecontext)) {
                $errors['link'] = get_string('error');
            } else if (!has_capability('enrol/meta:selectaslinked', $coursecontext)) {
                $errors['link'] = get_string('error');
            } else if ($c->id == SITEID or $c->id == $this->course->id or isset($existing[$c->id])) {
                $errors['link'] = get_string('error');
            }
        }

        return $errors;
    }
}

