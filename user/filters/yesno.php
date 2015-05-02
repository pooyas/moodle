<?php

/**
 * Yes/No (boolean) filter.
 *
 * @package   core_user
 * @category  user
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * 
 */

/**
 * Generic yes/no filter with radio buttons for integer fields.
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * 
 */
class user_filter_yesno extends user_filter_simpleselect {

    /**
     * Constructor
     * @param string $name the name of the filter instance
     * @param string $label the label of the filter instance
     * @param boolean $advanced advanced form element flag
     * @param string $field user table filed name
     */
    public function user_filter_yesno($name, $label, $advanced, $field) {
        parent::user_filter_simpleselect($name, $label, $advanced, $field, array(0 => get_string('no'), 1 => get_string('yes')));
    }

    /**
     * Returns the condition to be used with SQL
     *
     * @param array $data filter settings
     * @return array sql string and $params
     */
    public function get_sql_filter($data) {
        static $counter = 0;
        $name = 'ex_yesno'.$counter++;

        $value = $data['value'];
        $field = $this->_field;
        if ($value == '') {
            return array();
        }
        return array("$field=:$name", array($name => $value));
    }
}
