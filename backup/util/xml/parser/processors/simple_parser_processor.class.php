<?php


/**
 * @package lioncore
 * @subpackage xml
 * @copyright 2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

require_once($CFG->dirroot.'/backup/util/xml/parser/processors/progressive_parser_processor.class.php');

/**
 * Simple progressive_parser_processor that will send chunks straight
 * to output. Useful for testing, compare memory use/execution time.
 */
class simple_parser_processor extends progressive_parser_processor {

   public function process_chunk($data) {
       print_r($data); // Simply output chunk, for testing purposes
   }
}
