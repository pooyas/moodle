<?php


/**
 * @package lioncore
 * @subpackage backup-helper
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

require_once($CFG->dirroot.'/backup/util/xml/parser/processors/grouped_parser_processor.class.php');

/**
 * helper implementation of grouped_parser_processor that will
 * load all the contents of one inforef.xml file to the backup_ids table
*
 * TODO: Complete phpdocs
 */
class restore_inforef_parser_processor extends grouped_parser_processor {

    protected $restoreid;

    public function __construct($restoreid) {
        $this->restoreid = $restoreid;
        parent::__construct(array());
        // Get itemnames handled by inforef files
        $items = backup_helper::get_inforef_itemnames();
        // Let's add all them as target paths for the processor
        foreach($items as $itemname) {
            $pathvalue = '/inforef/' . $itemname . 'ref/' . $itemname;
            $this->add_path($pathvalue);
        }
    }

    protected function dispatch_chunk($data) {
        // Received one inforef chunck, we are going to store it into backup_ids
        // table, with name = itemname + "ref" for later use
        $itemname = basename($data['path']). 'ref';
        $itemid   = $data['tags']['id'];
        restore_dbops::set_backup_ids_record($this->restoreid, $itemname, $itemid);
    }

    protected function notify_path_start($path) {
        // nothing to do
    }

    protected function notify_path_end($path) {
        // nothing to do
    }
}
