<?php

/**
 * Implementaton of the quizaccess_password plugin.
 *
 * @package    quizaccess
 * @subpackage password
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');


/**
 * A rule implementing the password check.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class quizaccess_password extends quiz_access_rule_base {

    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {
        if (empty($quizobj->get_quiz()->password)) {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    public function description() {
        return get_string('requirepasswordmessage', 'quizaccess_password');
    }

    public function is_preflight_check_required($attemptid) {
        global $SESSION;
        return empty($SESSION->passwordcheckedquizzes[$this->quiz->id]);
    }

    public function add_preflight_check_form_fields(mod_quiz_preflight_check_form $quizform,
            LionQuickForm $mform, $attemptid) {

        $mform->addElement('header', 'passwordheader', get_string('password'));
        $mform->addElement('static', 'passwordmessage', '',
                get_string('requirepasswordmessage', 'quizaccess_password'));

        // Don't use the 'proper' field name of 'password' since that get's
        // Firefox's password auto-complete over-excited.
        $mform->addElement('password', 'quizpassword',
                get_string('quizpassword', 'quizaccess_password'), array('autofocus' => 'true'));
    }

    public function validate_preflight_check($data, $files, $errors, $attemptid) {

        $enteredpassword = $data['quizpassword'];
        if (strcmp($this->quiz->password, $enteredpassword) === 0) {
            return $errors; // Password is OK.

        } else if (isset($this->quiz->extrapasswords)) {
            // Group overrides may have additional passwords.
            foreach ($this->quiz->extrapasswords as $password) {
                if (strcmp($password, $enteredpassword) === 0) {
                    return $errors; // Password is OK.
                }
            }
        }

        $errors['quizpassword'] = get_string('passworderror', 'quizaccess_password');
        return $errors;
    }

    public function notify_preflight_check_passed($attemptid) {
        global $SESSION;
        $SESSION->passwordcheckedquizzes[$this->quiz->id] = true;
    }

    public function current_attempt_finished() {
        global $SESSION;
        // Clear the flag in the session that says that the user has already
        // entered the password for this quiz.
        if (!empty($SESSION->passwordcheckedquizzes[$this->quiz->id])) {
            unset($SESSION->passwordcheckedquizzes[$this->quiz->id]);
        }
    }
}
