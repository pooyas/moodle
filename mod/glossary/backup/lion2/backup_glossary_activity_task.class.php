<?php


/**
 * Defines backup_glossary_activity_task class
 *
 * @package     mod_glossary
 * @category    backup
 * @copyright   2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/glossary/backup/lion2/backup_glossary_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Glossary instance
 */
class backup_glossary_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the glossary.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_glossary_activity_structure_step('glossary_structure', 'glossary.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot,"/");

        // Link to the list of glossaries
        $search="/(".$base."\/mod\/glossary\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@GLOSSARYINDEX*$2@$', $content);

        // Link to glossary view by moduleid
        $search="/(".$base."\/mod\/glossary\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@GLOSSARYVIEWBYID*$2@$', $content);

        // Link to glossary entry
        $search="/(".$base."\/mod\/glossary\/showentry.php\?courseid=)([0-9]+)(&|&amp;)eid=([0-9]+)/";
        $content = preg_replace($search, '$@GLOSSARYSHOWENTRY*$2*$4@$', $content);

        return $content;
    }
}
