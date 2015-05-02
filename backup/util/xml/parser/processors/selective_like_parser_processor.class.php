<?php


/**
 * @package lioncore
 * @subpackage xml
 * @copyright 2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

require_once($CFG->dirroot.'/backup/util/xml/parser/processors/progressive_parser_processor.class.php');

/**
 * Selective progressive_parser_processor that will send chunks straight
 * to output but only for chunks matching (in a left padded way - like) some defined paths
 */
class selective_like_parser_processor extends progressive_parser_processor {

   protected $paths; // array of paths we are interested on

   public function __construct(array $paths) {
       parent::__construct();
       $this->paths = '=>' . implode('=>', $paths);
   }

   public function process_chunk($data) {
       if ($this->path_is_selected($data['path'])) {
           print_r($data); // Simply output chunk, for testing purposes
       } else {
           $this->chunks--; // Chunk skipped
       }
   }

// Protected API starts here

   protected function path_is_selected($path) {
       return strpos('@=>' . $path, $this->paths);
   }
}
