<?php

/**
 * Code that deals with logging stuff during the question engine upgrade.
 *
 * @package    core
 * @subpackage questionengine
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * This class serves to record all the assumptions that the code had to make
 * during the question engine database database upgrade, to facilitate reviewing
 * them.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class question_engine_assumption_logger {
    protected $handle;
    protected $attemptid;

    public function __construct() {
        global $CFG;
        make_upload_directory('upgradelogs');
        $date = date('Ymd-His');
        $this->handle = fopen($CFG->dataroot . '/upgradelogs/qe_' .
                $date . '.html', 'a');
        fwrite($this->handle, '<html><head><title>Question engine upgrade assumptions ' .
                $date . '</title></head><body><h2>Question engine upgrade assumptions ' .
                $date . "</h2>\n\n");
    }

    public function set_current_attempt_id($id) {
        $this->attemptid = $id;
    }

    public function log_assumption($description, $quizattemptid = null) {
        global $CFG;
        $message = '<p>' . $description;
        if (!$quizattemptid) {
            $quizattemptid = $this->attemptid;
        }
        if ($quizattemptid) {
            $message .= ' (<a href="' . $CFG->wwwroot . '/mod/quiz/review.php?attempt=' .
                    $quizattemptid . '">Review this attempt</a>)';
        }
        $message .= "</p>\n";
        fwrite($this->handle, $message);
    }

    public function __destruct() {
        fwrite($this->handle, '</body></html>');
        fclose($this->handle);
    }
}


/**
 * Subclass of question_engine_assumption_logger that does nothing, for testing.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class dummy_question_engine_assumption_logger extends question_engine_assumption_logger {
    protected $attemptid;

    public function __construct() {
    }

    public function log_assumption($description, $quizattemptid = null) {
    }

    public function __destruct() {
    }
}
