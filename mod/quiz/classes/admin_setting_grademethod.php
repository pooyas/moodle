<?php

/**
 * Admin settings class for the quiz grading method.
 *
 * @package   mod_quiz
 * @copyright 2008 Tim Hunt
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Admin settings class for the quiz grading method.
 *
 * Just so we can lazy-load the choices.
 *
 * @copyright  2011 The Open University
 * 
 */
class mod_quiz_admin_setting_grademethod extends admin_setting_configselect_with_advanced {
    public function load_choices() {
        global $CFG;

        if (is_array($this->choices)) {
            return true;
        }

        require_once($CFG->dirroot . '/mod/quiz/locallib.php');
        $this->choices = quiz_get_grading_options();

        return true;
    }
}
