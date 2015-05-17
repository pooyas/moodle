<?php


/**
 * Implementaton of the quizaccess_safebrowser plugin.
 *
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');


/**
 * A rule representing the safe browser check.
 *
 */
class quizaccess_safebrowser extends quiz_access_rule_base {

    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {

        if ($quizobj->get_quiz()->browsersecurity !== 'safebrowser') {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    public function prevent_access() {
        if (!$this->check_safe_browser()) {
            return get_string('safebrowsererror', 'quizaccess_safebrowser');
        } else {
            return false;
        }
    }

    public function description() {
        return get_string('safebrowsernotice', 'quizaccess_safebrowser');
    }

    public function setup_attempt_page($page) {
        $page->set_title($this->quizobj->get_course()->shortname . ': ' . $page->title);
        $page->set_cacheable(false);
        $page->set_popup_notification_allowed(false); // Prevent message notifications.
        $page->set_heading($page->title);
        $page->set_pagelayout('secure');
    }

    /**
     * Checks if browser is safe browser
     *
     * @return true, if browser is safe browser else false
     */
    public function check_safe_browser() {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'SEB') !== false;
    }

    /**
     * @return array key => lang string any choices to add to the quiz Browser
     *      security settings menu.
     */
    public static function get_browser_security_choices() {
        global $CFG;

        if (empty($CFG->enablesafebrowserintegration)) {
            return array();
        }

        return array('safebrowser' =>
                get_string('requiresafeexambrowser', 'quizaccess_safebrowser'));
    }
}
