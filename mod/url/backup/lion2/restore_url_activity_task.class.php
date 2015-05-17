<?php



/**
 * @package    mod
 * @subpackage url
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/url/backup/lion2/restore_url_stepslib.php'); // Because it exists (must)

/**
 * url restore task that provides all the settings and steps to perform one
 * complete restore of the activity
 */
class restore_url_activity_task extends restore_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No particular settings for this activity
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        // url only has one structure step
        $this->add_step(new restore_url_activity_structure_step('url_structure', 'url.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        $contents = array();

        $contents[] = new restore_decode_content('url', array('intro', 'externalurl'), 'url');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    static public function define_decode_rules() {
        $rules = array();

        $rules[] = new restore_decode_rule('URLINDEX', '/mod/url/index.php?id=$1', 'course');
        $rules[] = new restore_decode_rule('URLVIEWBYID', '/mod/url/view.php?id=$1', 'course_module');
        $rules[] = new restore_decode_rule('URLVIEWBYU', '/mod/url/view.php?u=$1', 'url');

        return $rules;

    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * url logs. It must return one array
     * of {@link restore_log_rule} objects
     */
    static public function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('url', 'add', 'view.php?id={course_module}', '{url}');
        $rules[] = new restore_log_rule('url', 'update', 'view.php?id={course_module}', '{url}');
        $rules[] = new restore_log_rule('url', 'view', 'view.php?id={course_module}', '{url}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * course logs. It must return one array
     * of {@link restore_log_rule} objects
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     */
    static public function define_restore_log_rules_for_course() {
        $rules = array();

        $rules[] = new restore_log_rule('url', 'view all', 'index.php?id={course}', null);

        return $rules;
    }
}
