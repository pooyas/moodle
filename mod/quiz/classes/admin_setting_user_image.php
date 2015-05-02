<?php

/**
 * Admin settings class for the choices for how to display the user's image
 *
 * @package   mod_quiz
 * @copyright 2008 Tim Hunt
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Admin settings class for the choices for how to display the user's image.
 *
 * Just so we can lazy-load the choices.
 *
 * @copyright  2011 The Open University
 * 
 */
class mod_quiz_admin_setting_user_image extends admin_setting_configselect_with_advanced {
    public function load_choices() {
        global $CFG;

        if (is_array($this->choices)) {
            return true;
        }

        require_once($CFG->dirroot . '/mod/quiz/locallib.php');
        $this->choices = quiz_get_user_image_options();

        return true;
    }
}
