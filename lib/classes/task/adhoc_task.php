<?php

/**
 * Adhoc task abstract class.
 *
 * All background tasks should extend this class.
 *
 * @package    core
 * @category   task
 * @copyright  2013 Damyon Wiese
 * 
 */

namespace core\task;

/**
 * Abstract class defining an adhoc task.
 * @copyright  2013 Damyon Wiese
 * 
 */
abstract class adhoc_task extends task_base {

    /** @var string $customdata - Custom data required for when this task is executed. */
    private $customdata = '';

    /** @var integer|null $id - Adhoc tasks each have their own database record id. */
    private $id = null;

    /**
     * Setter for $id.
     * @param int|null $id
     */
    public function set_id($id) {
        $this->id = $id;
    }

    /**
     * Getter for $id.
     * @return int|null $id
     */
    public function get_id() {
        return $this->id;
    }

    /**
     * Setter for $customdata.
     * @param mixed $customdata (anything that can be handled by json_encode)
     */
    public function set_custom_data($customdata) {
        $this->customdata = json_encode($customdata);
    }

    /**
     * Alternate setter for $customdata. Expects the data as a json_encoded string.
     * @param string $customdata json_encoded string
     */
    public function set_custom_data_as_string($customdata) {
        $this->customdata = $customdata;
    }

    /**
     * Getter for $customdata.
     * @return mixed (anything that can be handled by json_decode).
     */
    public function get_custom_data() {
        return json_decode($this->customdata);
    }

    /**
     * Alternate getter for $customdata.
     * @return string this is the raw json encoded version.
     */
    public function get_custom_data_as_string() {
        return $this->customdata;
    }


}
