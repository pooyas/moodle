<?php


/**
 * @package assignment_offline
 * @subpackage backup-lion2
 * @copyright 2015 Pooya Saeedi
 * 
 */

/**
 * restore subplugin class that provides the necessary information
 * needed to restore one assignment->offline subplugin.
 *
 * Note: Offline assignments really haven't any special subplugin
 * information to backup/restore, hence code below is skipped (return false)
 * but it's a good example of subplugins supported at different
 * elements (assignment and submission)
 */
class restore_assignment_offline_subplugin extends restore_subplugin {

    /**
     * Returns the paths to be handled by the subplugin at assignment level
     */
    protected function define_assignment_subplugin_structure() {

        return false; // This subplugin restore is only one example. Skip it.

        $paths = array();

        $elename = $this->get_namefor('config');
        $elepath = $this->get_pathfor('/config'); // because we used get_recommended_name() in backup this works
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths; // And we return the interesting paths
    }

    /**
     * Returns the paths to be handled by the subplugin at submission level
     */
    protected function define_submission_subplugin_structure() {

        return false; // This subplugin restore is only one example. Skip it.

        $paths = array();

        $elename = $this->get_namefor('submission_config');
        $elepath = $this->get_pathfor('/submission_config'); // because we used get_recommended_name() in backup this works
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths; // And we return the interesting paths
    }

    /**
     * This method processes the config element inside one offline assignment (see offline subplugin backup)
     */
    public function process_assignment_offline_config($data) {
        $data = (object)$data;
        print_object($data); // Nothing to do, just print the data

        // Just to check that the whole API is available here
        $this->set_mapping('assignment_offline_config', 1, 1, true);
        $this->add_related_files('mod_assignment', 'intro', 'assignment_offline_config');
        print_object($this->get_mappingid('assignment_offline_config', 1));
        print_object($this->get_old_parentid('assignment'));
        print_object($this->get_new_parentid('assignment'));
        print_object($this->get_mapping('assignment', $this->get_old_parentid('assignment')));
        print_object($this->apply_date_offset(1));
        print_object($this->task->get_courseid());
        print_object($this->task->get_contextid());
        print_object($this->get_restoreid());
    }

    /**
     * This method processes the submission_config element inside one offline assignment (see offline subplugin backup)
     */
    public function process_assignment_offline_submission_config($data) {
        $data = (object)$data;
        print_object($data); // Nothing to do, just print the data
    }
}
