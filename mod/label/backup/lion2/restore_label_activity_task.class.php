<?php



/**
 * @package    mod
 * @subpackage label
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/label/backup/lion2/restore_label_stepslib.php'); // Because it exists (must)

/**
 * label restore task that provides all the settings and steps to perform one
 * complete restore of the activity
 */
class restore_label_activity_task extends restore_activity_task {

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
        // label only has one structure step
        $this->add_step(new restore_label_activity_structure_step('label_structure', 'label.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        $contents = array();

        $contents[] = new restore_decode_content('label', array('intro'), 'label');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    static public function define_decode_rules() {
        return array();
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * label logs. It must return one array
     * of {@link restore_log_rule} objects
     */
    static public function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('label', 'add', 'view.php?id={course_module}', '{label}');
        $rules[] = new restore_log_rule('label', 'update', 'view.php?id={course_module}', '{label}');
        $rules[] = new restore_log_rule('label', 'view', 'view.php?id={course_module}', '{label}');

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

        $rules[] = new restore_log_rule('label', 'view all', 'index.php?id={course}', null);

        return $rules;
    }
}
