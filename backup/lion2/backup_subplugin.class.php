<?php



/**
 * Defines backup_subplugin class
 * @category    backup
 * @package    backup
 * @subpackage lion2
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Class implementing the subplugins support for lion2 backups
 *
 * TODO: Finish phpdocs
 * TODO: Make this subclass of backup_plugin
 */
abstract class backup_subplugin {

    protected $subplugintype;
    protected $subpluginname;
    protected $connectionpoint;
    protected $optigroup; // Optigroup, parent of all optigroup elements
    protected $step;
    protected $task;

    public function __construct($subplugintype, $subpluginname, $optigroup, $step) {
        $this->subplugintype = $subplugintype;
        $this->subpluginname = $subpluginname;
        $this->optigroup     = $optigroup;
        $this->connectionpoint = '';
        $this->step          = $step;
        $this->task          = $step->get_task();
    }

    public function define_subplugin_structure($connectionpoint) {

        $this->connectionpoint = $connectionpoint;

        $methodname = 'define_' . $connectionpoint . '_subplugin_structure';

        if (method_exists($this, $methodname)) {
            $this->$methodname();
        }
    }

// Protected API starts here

// backup_step/structure_step/task wrappers

    /**
     * Returns the value of one (task/plan) setting
     */
    protected function get_setting_value($name) {
        if (is_null($this->task)) {
            throw new backup_step_exception('not_specified_backup_task');
        }
        return $this->task->get_setting_value($name);
    }

// end of backup_step/structure_step/task wrappers

    /**
     * Factory method that will return one backup_subplugin_element (backup_optigroup_element)
     * with its name automatically calculated, based one the subplugin being handled (type, name)
     */
    protected function get_subplugin_element($final_elements = null, $conditionparam = null, $conditionvalue = null) {
        // Something exclusive for this backup_subplugin_element (backup_optigroup_element)
        // because it hasn't XML representation
        $name = 'optigroup_' . $this->subplugintype . '_' . $this->subpluginname . '_' . $this->connectionpoint;
        $optigroup_element = new backup_subplugin_element($name, $final_elements, $conditionparam, $conditionvalue);
        $this->optigroup->add_child($optigroup_element);  // Add optigroup_element to stay connected since beginning
        return $optigroup_element;
    }

    /**
     * Simple helper function that suggests one name for the main nested element in subplugins
     * It's not mandatory to use it but recommended ;-)
     */
    protected function get_recommended_name() {
        return 'subplugin_' . $this->subplugintype . '_' . $this->subpluginname . '_' . $this->connectionpoint;
    }

}
