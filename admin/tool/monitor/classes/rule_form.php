<?php


/**
 * The mform for creating and editing a rule.
 *
 * @package    admin_tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi
 */

namespace tool_monitor;

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * The mform for creating and editing a rule.
 *
 */
class rule_form extends \lionform {

    /**
     * Mform class definition
     *
     */
    public function definition () {
        $mform = $this->_form;
        $eventlist = $this->_customdata['eventlist'];
        $pluginlist = $this->_customdata['pluginlist'];
        $rule = $this->_customdata['rule'];
        $courseid = $this->_customdata['courseid'];
        $subscriptioncount = $this->_customdata['subscriptioncount'];

        // General section header.
        $mform->addElement('header', 'general', get_string('general'));

        // Hidden course ID.
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        // We are editing a existing rule.
        if (!empty($rule->id)) {
            // Hidden rule id.
            $mform->addElement('hidden', 'ruleid');
            $mform->setType('ruleid', PARAM_INT);
            $mform->setConstant('ruleid', $rule->id);

            // Force course id.
            $courseid = $rule->courseid;
        }

        // Make course id a constant.
        $mform->setConstant('courseid', $courseid);

        if (empty($courseid)) {
            $context = \context_system::instance();
        } else {
            $context = \context_course::instance($courseid);
        }

        $editoroptions = array(
            'subdirs' => 0,
            'maxbytes' => 0,
            'maxfiles' => 0,
            'changeformat' => 0,
            'context' => $context,
            'noclean' => 0,
            'trusttext' => 0
        );

        // Name field.
        $mform->addElement('text', 'name', get_string('rulename', 'tool_monitor'), 'size="50"');
        $mform->addRule('name', get_string('required'), 'required');
        $mform->setType('name', PARAM_TEXT);

        // Plugin field.
        $mform->addElement('select', 'plugin', get_string('areatomonitor', 'tool_monitor'), $pluginlist);
        $mform->addRule('plugin', get_string('required'), 'required');

        // Event field.
        $mform->addElement('select', 'eventname', get_string('event', 'tool_monitor'), $eventlist);
        $mform->addRule('eventname', get_string('required'), 'required');

        // Freeze plugin and event fields for editing if there's a subscription for this rule.
        if ($subscriptioncount > 0) {
            $mform->freeze('plugin');
            $mform->setConstant('plugin', $rule->plugin);
            $mform->freeze('eventname');
            $mform->setConstant('eventname', $rule->eventname);
        }

        // Description field.
        $mform->addElement('editor', 'description', get_string('description'), $editoroptions);

        // Filters.
        $freq = array(1 => 1, 5 => 5, 10 => 10, 20 => 20, 30 => 30, 40 => 40, 50 => 50, 60 => 60, 70 => 70, 80 => 80, 90 => 90,
                100 => 100, 1000 => 1000);
        $mform->addElement('select', 'frequency', get_string('frequency', 'tool_monitor'), $freq);
        $mform->addRule('frequency', get_string('required'), 'required');
        $mform->addHelpButton('frequency', 'frequency', 'tool_monitor');

        $mins = array(1 => 1, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 30 => 30, 35 => 35, 40 => 40, 45 => 45, 50 => 50,
                55 => 55,  60 => 60);
        $mform->addElement('select', 'minutes', get_string('inminutes', 'tool_monitor'), $mins);
        $mform->addRule('minutes', get_string('required'), 'required');

        // Message template.
        $mform->addElement('editor', 'template', get_string('messagetemplate', 'tool_monitor'), $editoroptions);
        $mform->setDefault('template', array('text' => get_string('defaultmessagetemplate', 'tool_monitor'),
                'format' => FORMAT_HTML));
        $mform->addRule('template', get_string('required'), 'required');
        $mform->addHelpButton('template', 'messagetemplate', 'tool_monitor');

        // Action buttons.
        $this->add_action_buttons(true, get_string('savechanges'));
    }

    /**
     * Form validation
     *
     * @param array $data data from the form.
     * @param array $files files uploaded.
     *
     * @return array of errors.
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (!eventlist::validate_event_plugin($data['plugin'], $data['eventname'])) {
            $errors['eventname'] = get_string('errorincorrectevent', 'tool_monitor');
        }

        return $errors;
    }
}