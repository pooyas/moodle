<?php

/**
 * This file contains a renderer for the assignment class
 *
 * @package   assignfeedback
 * @subpackage file
 * @copyright 2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * A renderable summary of the zip import
 *
 */
class assignfeedback_file_import_summary implements renderable {
    /** @var int $cmid Course module id for constructing navigation links */
    public $cmid = 0;
    /** @var int $userswithnewfeedback The number of users who have received new feedback */
    public $userswithnewfeedback = 0;
    /** @var int $feedbackfilesadded The number of new feedback files */
    public $feedbackfilesadded = 0;
    /** @var int $feedbackfilesupdated The number of updated feedback files */
    public $feedbackfilesupdated = 0;

    /**
     * Constructor for this renderable class
     *
     * @param int $cmid - The course module id for navigation
     * @param int $userswithnewfeedback - The number of users with new feedback
     * @param int $feedbackfilesadded - The number of feedback files added
     * @param int $feedbackfilesupdated - The number of feedback files updated
     */
    public function __construct($cmid, $userswithnewfeedback, $feedbackfilesadded, $feedbackfilesupdated) {
        $this->cmid = $cmid;
        $this->userswithnewfeedback = $userswithnewfeedback;
        $this->feedbackfilesadded = $feedbackfilesadded;
        $this->feedbackfilesupdated = $feedbackfilesupdated;
    }
}
