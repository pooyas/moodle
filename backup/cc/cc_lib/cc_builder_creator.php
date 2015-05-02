<?php
/**
* @package    backup-convert
* @subpackage cc-library
* @copyright  2011 Darko Miletic <dmiletic@lionrooms.com>
* 
*/

/**
 * Factory pattern class
 * Create the version class to use
 *
 */
class cc_builder_creator {

   public static function factory($version){
       if (is_null($version)) {
           throw new Exception("Version is null!");
       }
       if (include_once 'cc_version' . $version . '.php') {
           $classname = 'cc_version' . $version;
           return new $classname;
       } else {
           throw new Exception ("Dont find cc version class!");
       }
   }
}