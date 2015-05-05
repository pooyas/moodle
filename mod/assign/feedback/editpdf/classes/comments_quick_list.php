<?php

/**
 * This file contains the functions for managing a users comments quicklist.
 *
 * @package   assignfeedback_editpdf
 * @copyright 2015 Pooya Saeedi
 * 
 */

namespace assignfeedback_editpdf;

/**
 * This class performs crud operations on a users quicklist comments.
 *
 * No capability checks are done - they should be done by the calling class.
 * @package   assignfeedback_editpdf
 * @copyright 2015 Pooya Saeedi
 * 
 */
class comments_quick_list {

    /**
     * Get all comments for the current user.
     * @return array(comment)
     */
    public static function get_comments() {
        global $DB, $USER;

        $comments = array();
        $records = $DB->get_records('assignfeedback_editpdf_quick', array('userid'=>$USER->id));

        return $records;
    }

    /**
     * Add a comment to the quick list.
     * @param string $commenttext
     * @param int $width
     * @param string $colour
     * @return stdClass - the comment record (with new id set)
     */
    public static function add_comment($commenttext, $width, $colour) {
        global $DB, $USER;

        $comment = new \stdClass();
        $comment->userid = $USER->id;
        $comment->rawtext = $commenttext;
        $comment->width = $width;
        $comment->colour = $colour;

        $comment->id = $DB->insert_record('assignfeedback_editpdf_quick', $comment);
        return $comment;
    }

    /**
     * Get a single comment by id.
     * @param int $commentid
     * @return comment or false
     */
    public static function get_comment($commentid) {
        global $DB;

        $record = $DB->get_record('assignfeedback_editpdf_quick', array('id'=>$commentid), '*', IGNORE_MISSING);
        if ($record) {
            return $record;
        }
        return false;
    }

    /**
     * Remove a comment from the quick list.
     * @param int $commentid
     * @return bool
     */
    public static function remove_comment($commentid) {
        global $DB, $USER;
        return $DB->delete_records('assignfeedback_editpdf_quick', array('id'=>$commentid, 'userid'=>$USER->id));
    }
}
