<?php

/**
 * assignment_base is the base class for assignment types
 *
 * This class provides all the functionality for an assignment
 *
 * @package   mod
 * @subpackage assignment
 * @copyright 2015 Pooya Saeedi
 * 
 */

/**
 * Adds an assignment instance
 *
 * Only used by generators so we can create old assignments to test the upgrade.
 *
 * @param stdClass $assignment
 * @param mod_assignment_mod_form $mform
 * @return int intance id
 */
function assignment_add_instance($assignment, $mform = null) {
    global $DB;

    $assignment->timemodified = time();
    $assignment->courseid = $assignment->course;
    $returnid = $DB->insert_record("assignment", $assignment);
    $assignment->id = $returnid;
    return $returnid;
}

/**
 * Deletes an assignment instance
 *
 * @param $id
 */
function assignment_delete_instance($id){
    global $CFG, $DB;

    if (! $assignment = $DB->get_record('assignment', array('id'=>$id))) {
        return false;
    }

    $result = true;
    // Now get rid of all files
    $fs = get_file_storage();
    if ($cm = get_coursemodule_from_instance('assignment', $assignment->id)) {
        $context = context_module::instance($cm->id);
        $fs->delete_area_files($context->id);
    }

    if (! $DB->delete_records('assignment_submissions', array('assignment'=>$assignment->id))) {
        $result = false;
    }

    if (! $DB->delete_records('event', array('modulename'=>'assignment', 'instance'=>$assignment->id))) {
        $result = false;
    }

    if (! $DB->delete_records('assignment', array('id'=>$assignment->id))) {
        $result = false;
    }

    grade_update('mod/assignment', $assignment->course, 'mod', 'assignment', $assignment->id, 0, NULL, array('deleted'=>1));

    return $result;
}

/**
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function assignment_supports($feature) {
    switch($feature) {
        case FEATURE_BACKUP_LION2:          return true;

        default: return null;
    }
}
