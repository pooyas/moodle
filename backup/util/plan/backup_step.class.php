<?php


/**
 * @package lioncore
 * @subpackage backup-plan
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

/**
 * Abstract class defining the needed stuf for one backup step
 *
 * TODO: Finish phpdocs
 */
abstract class backup_step extends base_step {

    /**
     * Constructor - instantiates one object of this class
     */
    public function __construct($name, $task = null) {
        if (!is_null($task) && !($task instanceof backup_task)) {
            throw new backup_step_exception('wrong_backup_task_specified');
        }
        parent::__construct($name, $task);
    }

    protected function get_backupid() {
        if (is_null($this->task)) {
            throw new backup_step_exception('not_specified_backup_task');
        }
        return $this->task->get_backupid();
    }
}

/*
 * Exception class used by all the @backup_step stuff
 */
class backup_step_exception extends base_step_exception {

    public function __construct($errorcode, $a=NULL, $debuginfo=null) {
        parent::__construct($errorcode, $a, $debuginfo);
    }
}
