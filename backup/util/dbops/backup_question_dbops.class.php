<?php



/**
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Non instantiable helper class providing DB support to the questions backup stuff
 *
 * This class contains various static methods available for all the DB operations
 * performed by questions stuff
 *
 * TODO: Finish phpdocs
 */
abstract class backup_question_dbops extends backup_dbops {

    /**
     * Calculates all the question_categories to be included
     * in backup, based in a given context (course/module) and
     * the already annotated questions present in backup_ids_temp
     */
    public static function calculate_question_categories($backupid, $contextid) {
        global $DB;

        // First step, annotate all the categories for the given context (course/module)
        // i.e. the whole context questions bank
        $DB->execute("INSERT INTO {backup_ids_temp} (backupid, itemname, itemid)
                      SELECT ?, 'question_category', id
                        FROM {question_categories}
                       WHERE contextid = ?", array($backupid, $contextid));

        // Now, based in the annotated questions, annotate all the categories they
        // belong to (whole context question banks too)
        // First, get all the contexts we are going to save their question bank (no matter
        // where they are in the contexts hierarchy, transversals... whatever)
        $contexts = $DB->get_fieldset_sql("SELECT DISTINCT qc2.contextid
                                             FROM {question_categories} qc2
                                             JOIN {question} q ON q.category = qc2.id
                                             JOIN {backup_ids_temp} bi ON bi.itemid = q.id
                                            WHERE bi.backupid = ?
                                              AND bi.itemname = 'question'
                                              AND qc2.contextid != ?", array($backupid, $contextid));
        // And now, simply insert all the question categories (complete question bank)
        // for those contexts if we have found any
        if ($contexts) {
            list($contextssql, $contextparams) = $DB->get_in_or_equal($contexts);
            $params = array_merge(array($backupid), $contextparams);
            $DB->execute("INSERT INTO {backup_ids_temp} (backupid, itemname, itemid)
                          SELECT ?, 'question_category', id
                            FROM {question_categories}
                           WHERE contextid $contextssql", $params);
        }
    }

    /**
     * Delete all the annotated questions present in backup_ids_temp
     */
    public static function delete_temp_questions($backupid) {
        global $DB;
        $DB->delete_records('backup_ids_temp', array('backupid' => $backupid, 'itemname' => 'question'));
    }
}
