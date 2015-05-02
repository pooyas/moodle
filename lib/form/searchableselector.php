<?php

/**
 * searchable select type element
 *
 * Contains HTML class for a searchable select type element
 *
 * @package   core_form
 * @copyright 2009 Jerome Mouneyrac <jerome@mouneyrac.com>
 * 
 */

require_once('select.php');

/**
 * searchable select type element
 *
 * Display a select input with a search textfield input on the top
 * The search textfield is created by the javascript file searchselector.js
 * (so when javascript is not activated into the browser, the search field is not displayed)
 * If ever the select can be reset/unselect/blank/nooption, you will have to add an option "noselected"
 * and manage this special case when you get/set the form data (i.e. $mform->get_data()/$this->set_data($yourobject)).
 *
 * @package   core_form
 * @category  form
 * @copyright 2009 Jerome Mouneyrac
 * 
 */
class LionQuickForm_searchableselector extends LionQuickForm_select{
    /**
     * Constructor
     *
     * @param string $elementName Select name attribute
     * @param mixed $elementLabel Label(s) for the select
     * @param array $options additional options.
     * @param mixed $attributes Either a typical HTML attribute string or an associative array
     */
    function LionQuickForm_searchableselector($elementName=null, $elementLabel=null, $options=null, $attributes=null) {
        //set size default to 12
        if (empty($attributes) || empty($attributes['size'])) {
            $attributes['size'] = 12;
        }
        parent::LionQuickForm_select($elementName, $elementLabel, $options, $attributes);
    }

    /**
     * Returns the select element in HTML
     *
     * @return string
     */
    function toHtml(){
        global $OUTPUT;
        if ($this->_hiddenLabel || $this->_flagFrozen) {
            return parent::toHtml();
        } else {
            // Javascript for the search/selection fields
            global $PAGE;
            $PAGE->requires->js('/lib/form/searchableselector.js');
            $PAGE->requires->js_function_call('selector.filter_init', array(get_string('search'),$this->getAttribute('id')));

            $strHtml = '';
            $strHtml .= parent::toHtml(); //the select input
            return $strHtml;
        }
    }

}
