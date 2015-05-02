<?php

/**
 * Implementaton of the quizaccess_securewindow plugin.
 *
 * @package    quizaccess
 * @subpackage securewindow
 * @copyright  2011 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');


/**
 * A rule for ensuring that the quiz is opened in a popup, with some JavaScript
 * to prevent copying and pasting, etc.
 *
 * @copyright  2009 Tim Hunt
 * 
 */
class quizaccess_securewindow extends quiz_access_rule_base {
    /** @var array options that should be used for opening the secure popup. */
    protected static $popupoptions = array(
        'left' => 0,
        'top' => 0,
        'fullscreen' => true,
        'scrollbars' => true,
        'resizeable' => false,
        'directories' => false,
        'toolbar' => false,
        'titlebar' => false,
        'location' => false,
        'status' => false,
        'menubar' => false,
    );

    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {

        if ($quizobj->get_quiz()->browsersecurity !== 'securewindow') {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    public function attempt_must_be_in_popup() {
        return !$this->quizobj->is_preview_user();
    }

    public function get_popup_options() {
        return self::$popupoptions;
    }

    public function setup_attempt_page($page) {
        $page->set_popup_notification_allowed(false); // Prevent message notifications.
        $page->set_title($this->quizobj->get_course()->shortname . ': ' . $page->title);
        $page->set_cacheable(false);
        $page->set_pagelayout('secure');

        if ($this->quizobj->is_preview_user()) {
            return;
        }

        $page->add_body_class('quiz-secure-window');
        $page->requires->js_init_call('M.mod_quiz.secure_window.init',
                null, false, quiz_get_js_module());
    }

    /**
     * @return array key => lang string any choices to add to the quiz Browser
     *      security settings menu.
     */
    public static function get_browser_security_choices() {
        return array('securewindow' =>
                get_string('popupwithjavascriptsupport', 'quizaccess_securewindow'));
    }
}
