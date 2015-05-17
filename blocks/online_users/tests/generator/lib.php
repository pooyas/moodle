<?php


/**
 * block_online_users data generator
 *
 * @category   test
 * @package    blocks
 * @subpackage online_users
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();


/**
 * Online users block data generator class
 *
 * @category   test
 */
class block_online_users_generator extends testing_block_generator {

    /**
     * Create new block instance
     * @param array|stdClass $record
     * @param array $options
     * @return stdClass activity record with extra cmid field
     */
    public function create_instance($record = null, array $options = null) {
        global $DB, $CFG;
        require_once("$CFG->dirroot/mod/page/locallib.php");

        $this->instancecount++;

        $record = (object)(array)$record;
        $options = (array)$options;

        $record = $this->prepare_record($record);

        $id = $DB->insert_record('block_instances', $record);
        context_block::instance($id);

        $instance = $DB->get_record('block_instances', array('id'=>$id), '*', MUST_EXIST);

        return $instance;
    }
}
