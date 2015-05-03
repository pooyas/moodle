<?php


/**
 * @package    lioncore
 * @subpackage backup-dbops
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Base abstract class for all the helper classes providing DB operations
 *
 * TODO: Finish phpdocs
 */
abstract class backup_dbops { }

/*
 * Exception class used by all the @dbops stuff
 */
class backup_dbops_exception extends backup_exception {

    public function __construct($errorcode, $a=NULL, $debuginfo=null) {
        parent::__construct($errorcode, 'error', '', $a, null, $debuginfo);
    }
}
