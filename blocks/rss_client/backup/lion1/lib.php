<?php

/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    block_rss_client
 * @copyright  2012 Paul Nicholls
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Block conversion handler for rss_client
 */
class lion1_block_rss_client_handler extends lion1_block_handler {
    public function process_block(array $data) {
        parent::process_block($data);
        $instanceid = $data['id'];
        $contextid = $this->converter->get_contextid(CONTEXT_BLOCK, $data['id']);

        // Lion 1.9 backups do not include sufficient data to restore feeds, so we need an empty shell rss_client.xml
        // for the restore process to find
        $this->open_xml_writer("course/blocks/{$data['name']}_{$instanceid}/rss_client.xml");
        $this->xmlwriter->begin_tag('block', array('id' => $instanceid, 'contextid' => $contextid, 'blockname' => 'rss_client'));
        $this->xmlwriter->begin_tag('rss_client', array('id' => $instanceid));
        $this->xmlwriter->full_tag('feeds', '');
        $this->xmlwriter->end_tag('rss_client');
        $this->xmlwriter->end_tag('block');
        $this->close_xml_writer();

        return $data;
    }
}
