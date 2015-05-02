<?php


/**
 * @package    lioncore
 * @subpackage backup-interfaces
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

/**
 * Interface to apply to all the classes we want to be annotable in the backup/restore process
 *
 * TODO: Finish phpdocs
 */
interface annotable {

    /**
     * This function implements the annotation of the current value associating it with $itemname
     */
    public function annotate($backupid);

    /**
     * This function sets the $itemname to be used when annotating
     */
    public function set_annotation_item($itemname);
}
