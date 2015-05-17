<?php


/**
 * This file contains the class for restore of this submission plugin
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Restore subplugin class.
 *
 * Provides the necessary information needed to restore
 * one assign_submission subplugin.
 *
 */
class restore_assignsubmission_onlinetext_subplugin extends restore_subplugin {

    /**
     * Returns array the paths to be handled by the subplugin at assignment level
     * @return array
     */
    protected function define_submission_subplugin_structure() {

        $paths = array();

        $elename = $this->get_namefor('submission');

        // We used get_recommended_name() so this works.
        $elepath = $this->get_pathfor('/submission_onlinetext');
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths;
    }

    /**
     * Processes one assignsubmission_onlinetext element
     *
     * @param mixed $data
     */
    public function process_assignsubmission_onlinetext_submission($data) {
        global $DB;

        $data = (object)$data;
        $data->assignment = $this->get_new_parentid('assign');
        $oldsubmissionid = $data->submission;
        // The mapping is set in the restore for the core assign activity
        // when a submission node is processed.
        $data->submission = $this->get_mappingid('submission', $data->submission);

        $DB->insert_record('assignsubmission_onlinetext', $data);

        $this->add_related_files('assignsubmission_onlinetext', 'submissions_onlinetext', 'submission', null, $oldsubmissionid);
    }

}
