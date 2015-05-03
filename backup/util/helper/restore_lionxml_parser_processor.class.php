<?php


/**
 * @package lioncore
 * @subpackage backup-helper
 * @copyright 2015 Pooya Saeedi
 * 
 */

require_once($CFG->dirroot.'/backup/util/xml/parser/processors/grouped_parser_processor.class.php');

/**
 * helper implementation of grouped_parser_processor that will
 * return all the information present in the lion_backup.xml file
 * accumulating it for later generation of controller->info
*
 * TODO: Complete phpdocs
 */
class restore_lionxml_parser_processor extends grouped_parser_processor {

    protected $accumchunks;

    public function __construct() {
        $this->accumchunks = array();
        parent::__construct();
        // Let's add all the paths we are interested on
        $this->add_path('/lion_backup/information', true); // Everything will be grouped below this
        $this->add_path('/lion_backup/information/details/detail');
        $this->add_path('/lion_backup/information/contents/activities/activity');
        $this->add_path('/lion_backup/information/contents/sections/section');
        $this->add_path('/lion_backup/information/contents/course');
        $this->add_path('/lion_backup/information/settings/setting');
    }

    protected function dispatch_chunk($data) {
        $this->accumchunks[] = $data;
    }

    protected function notify_path_start($path) {
        // nothing to do
    }

    protected function notify_path_end($path) {
        // nothing to do
    }

    public function get_all_chunks() {
        return $this->accumchunks;
    }

}
