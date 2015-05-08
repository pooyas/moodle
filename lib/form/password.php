<?php


/**
 * Password type form element
 *
 * Contains HTML class for a password type element
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

require_once('HTML/QuickForm/password.php');

/**
 * Password type form element
 *
 * HTML class for a password type element
 *
 */
class LionQuickForm_password extends HTML_QuickForm_password{
    /** @var string, html for help button, if empty then no help */
    var $_helpbutton='';

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the password element
     * @param string $elementLabel (optional) label for password element
     * @param mixed $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     */
    function LionQuickForm_password($elementName=null, $elementLabel=null, $attributes=null) {
        global $CFG;
        // no standard mform in lion should allow autocomplete of passwords
        if (empty($attributes)) {
            $attributes = array('autocomplete'=>'off');
        } else if (is_array($attributes)) {
            $attributes['autocomplete'] = 'off';
        } else {
            if (strpos($attributes, 'autocomplete') === false) {
                $attributes .= ' autocomplete="off" ';
            }
        }

        parent::HTML_QuickForm_password($elementName, $elementLabel, $attributes);
    }

    /**
     * get html for help button
     *
     * @return string html for help button
     */
    function getHelpButton(){
        return $this->_helpbutton;
    }
}
