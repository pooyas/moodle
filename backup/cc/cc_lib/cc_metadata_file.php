<?php

/**
* Metadata management
*
* @package    backup-convert
* @subpackage cc-library
* @copyright  2011 Darko Miletic <dmiletic@lionrooms.com>
* 
*/


/**
 * Metadata File Education Type
 *
 */
class cc_metadata_file_educational{

    public $value   = array();

    public function set_value ($value){
        $arr = array($value);
        $this->value[] = $arr;
    }

}

/**
 * Metadata File
 *
 */
class cc_metadata_file implements cc_i_metadata_file {

    public $arrayeducational  = array();

    public function add_metadata_file_educational($obj){
        if (empty($obj)){
            throw new Exception('Medatada Object given is invalid or null!');
        }
         !is_null($obj->value)? $this->arrayeducational['value']=$obj->value:null;
    }


}