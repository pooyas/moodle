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
 * load all the categories and questions (header info only) from then questions.xml file
 * to the backup_ids table storing the whole structure there for later processing.
 * Note: only "needed" categories are loaded (must have question_categoryref record in backup_ids)
 * Note: parentitemid will contain the category->contextid for categories
 * Note: parentitemid will contain the category->id for questions
 *
 * TODO: Complete phpdocs
 */
class restore_questions_parser_processor extends grouped_parser_processor {

    protected $restoreid;
    protected $lastcatid;

    public function __construct($restoreid) {
        $this->restoreid = $restoreid;
        $this->lastcatid = 0;
        parent::__construct(array());
        // Set the paths we are interested on
        $this->add_path('/question_categories/question_category');
        $this->add_path('/question_categories/question_category/questions/question');
    }

    protected function dispatch_chunk($data) {
        // Prepare question_category record
        if ($data['path'] == '/question_categories/question_category') {
            $info     = (object)$data['tags'];
            $itemname = 'question_category';
            $itemid   = $info->id;
            $parentitemid = $info->contextid;
            $this->lastcatid = $itemid;

        // Prepare question record
        } else if ($data['path'] == '/question_categories/question_category/questions/question') {
            $info = (object)$data['tags'];
            $itemname = 'question';
            $itemid   = $info->id;
            $parentitemid = $this->lastcatid;

        // Not question_category nor question, impossible. Throw exception.
        } else {
            throw new progressive_parser_exception('restore_questions_parser_processor_unexpected_path', $data['path']);
        }

        // Only load it if needed (exist same question_categoryref itemid in table)
        if (restore_dbops::get_backup_ids_record($this->restoreid, 'question_categoryref', $this->lastcatid)) {
            restore_dbops::set_backup_ids_record($this->restoreid, $itemname, $itemid, 0, $parentitemid, $info);
        }
    }

    protected function notify_path_start($path) {
        // nothing to do
    }

    protected function notify_path_end($path) {
        // nothing to do
    }

    /**
     * Provide NULL decoding
     */
    public function process_cdata($cdata) {
        if ($cdata === '$@NULL@$') {
            return null;
        }
        return $cdata;
    }
}
