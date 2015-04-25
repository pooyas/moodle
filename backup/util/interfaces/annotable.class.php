<?php

/**
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
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
