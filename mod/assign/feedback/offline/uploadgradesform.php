<?php

/**
 * This file contains the forms to create and edit an instance of this module
 *
 * @package   assignfeedback_offline
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * 
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->libdir.'/formslib.php');

/**
 * Upload modified grading worksheet
 *
 * @package   assignfeedback_offline
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * 
 */
class assignfeedback_offline_upload_grades_form extends lionform {
    /**
     * Define this form - called by the parent constructor
     */
    public function definition() {
        global $COURSE, $USER;

        $mform = $this->_form;
        $params = $this->_customdata;

        $mform->addElement('header', 'uploadgrades', get_string('uploadgrades', 'assignfeedback_offline'));

        $fileoptions = array('subdirs'=>0,
                                'maxbytes'=>$COURSE->maxbytes,
                                'accepted_types'=>'csv',
                                'maxfiles'=>1,
                                'return_types'=>FILE_INTERNAL);

        $mform->addElement('filepicker', 'gradesfile', get_string('uploadafile'), null, $fileoptions);
        $mform->addRule('gradesfile', get_string('uploadnofilefound'), 'required', null, 'client');
        $mform->addHelpButton('gradesfile', 'gradesfile', 'assignfeedback_offline');

        $mform->addElement('checkbox', 'ignoremodified', '', get_string('ignoremodified', 'assignfeedback_offline'));
        $mform->addHelpButton('ignoremodified', 'ignoremodified', 'assignfeedback_offline');

        $mform->addElement('hidden', 'id', $params['cm']);
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'action', 'viewpluginpage');
        $mform->setType('action', PARAM_ALPHA);
        $mform->addElement('hidden', 'pluginaction', 'uploadgrades');
        $mform->setType('pluginaction', PARAM_ALPHA);
        $mform->addElement('hidden', 'plugin', 'offline');
        $mform->setType('plugin', PARAM_PLUGIN);
        $mform->addElement('hidden', 'pluginsubtype', 'assignfeedback');
        $mform->setType('pluginsubtype', PARAM_PLUGIN);
        $this->add_action_buttons(true, get_string('uploadgrades', 'assignfeedback_offline'));

    }

}

