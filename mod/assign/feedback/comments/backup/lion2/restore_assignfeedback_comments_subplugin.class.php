<?php

/**
 * Restore subplugin class.
 *
 * Provides the necessary information needed to restore
 * one assign_submission subplugin.
 *
 * @package   assignfeedback
 * @subpackage comments
 * @copyright 2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Restore subplugin class.
 *
 * Provides the necessary information needed to restore
 * one assignfeedback subplugin.
 *
 */
class restore_assignfeedback_comments_subplugin extends restore_subplugin {

    /**
     * Returns the paths to be handled by the subplugin at workshop level
     * @return array
     */
    protected function define_grade_subplugin_structure() {

        $paths = array();

        $elename = $this->get_namefor('grade');
        // We used get_recommended_name() so this works.
        $elepath = $this->get_pathfor('/feedback_comments');

        $paths[] = new restore_path_element($elename, $elepath);

        return $paths;
    }

    /**
     * Processes one feedback_comments element.
     * @param mixed $data
     */
    public function process_assignfeedback_comments_grade($data) {
        global $DB;

        $data = (object)$data;
        $data->assignment = $this->get_new_parentid('assign');
        $oldgradeid = $data->grade;
        // The mapping is set in the restore for the core assign activity
        // when a grade node is processed.
        $data->grade = $this->get_mappingid('grade', $data->grade);

        $DB->insert_record('assignfeedback_comments', $data);
    }
}
