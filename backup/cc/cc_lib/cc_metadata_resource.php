<?php


/**
* Metadata managing
*
 * @package    backup
 * @subpackage cc
 * @copyright  2015 Pooya Saeedi
*/



/**
 * Metadata Resource Educational Type
 *
 */
class cc_metadata_resouce_educational{

    public $value   = array();


    public function set_value ($value){
        $arr = array($value);
        $this->value[] = $arr;
    }

}

/**
 * Metadata Resource
 *
 */
class cc_metadata_resouce implements cc_i_metadata_resource {

    public $arrayeducational  = array();

    public function add_metadata_resource_educational($obj){
        if (empty($obj)){
            throw new Exception('Medatada Object given is invalid or null!');
        }
         !is_null($obj->value)? $this->arrayeducational['value']=$obj->value:null;
    }


}