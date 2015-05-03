<?php


/**
 * @package lioncore
 * @subpackage backup-plan
 * @copyright 2015 Pooya Saeedi
 * 
 */

/**
 * Abstract class defining the needed stuf for one backup task (a collection of steps)
 *
 * TODO: Finish phpdocs
 */
abstract class backup_task extends base_task {

    /**
     * Constructor - instantiates one object of this class
     */
    public function __construct($name, $plan = null) {
        if (!is_null($plan) && !($plan instanceof backup_plan)) {
            throw new backup_task_exception('wrong_backup_plan_specified');
        }
        parent::__construct($name, $plan);
    }

    public function get_backupid() {
        return $this->plan->get_backupid();
    }

    public function is_excluding_activities() {
        return $this->plan->is_excluding_activities();
    }
}

/*
 * Exception class used by all the @backup_task stuff
 */
class backup_task_exception extends base_task_exception {

    public function __construct($errorcode, $a=NULL, $debuginfo=null) {
        parent::__construct($errorcode, $a, $debuginfo);
    }
}
