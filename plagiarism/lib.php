<?php


/**
 * lib.php - Contains Plagiarism base class used by plugins.
 *
 * @since Lion 2.0
 * @package    lioncore
 * @subpackage plagiarism
 * @copyright  2010 Dan Marsden http://danmarsden.com
 * 
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Lion page
}

//dummy class - all plugins should be based off this.
class plagiarism_plugin {

    /**
     * Return the list of form element names.
     *
     * @return array contains the form element names.
     */
    public function get_configs() {
        return array();
    }

    /**
     * hook to allow plagiarism specific information to be displayed beside a submission
     * @param array  $linkarraycontains all relevant information for the plugin to generate a link
     * @return string
     */
    public function get_links($linkarray) {
        return '';
    }
    /**
     * hook to allow plagiarism specific information to be returned unformatted
     * @param int $cmid
     * @param int $userid
     * @param $file file object
     * @return array containing at least:
     *   - 'analyzed' - whether the file has been successfully analyzed
     *   - 'score' - similarity score - ('' if not known)
     *   - 'reporturl' - url of originality report - '' if unavailable
     */
    public function get_file_results($cmid, $userid, $file) {
        return array('analyzed' => '', 'score' => '', 'reporturl' => '');
    }
    /**
     * hook to add plagiarism specific settings to a module settings page
     * @param object $mform  - Lion form
     * @param object $context - current context
     * @param string $modulename - Name of the module
     */
    public function get_form_elements_module($mform, $context, $modulename = "") {
    }
    /* hook to save plagiarism specific settings on a module settings page
     * @param object $data - data from an mform submission.
     */
    public function save_form_elements($data) {
    }
    /**
     * hook to allow a disclosure to be printed notifying users what will happen with their submission
     * @param int $cmid - course module id
     * @return string
     */
    public function print_disclosure($cmid) {
    }
    /**
     * hook to allow status of submitted files to be updated - called on grading/report pages.
     *
     * @param object $course - full Course object
     * @param object $cm - full cm object
     */
    public function update_status($course, $cm) {
    }
    /**
     * hook for cron
     *
     */
    public function plagiarism_cron() {
    }
}
