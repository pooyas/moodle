<?php


/**
 * Defines backup_wiki_activity_task class
 *
 * @package     mod_wiki
 * @category    backup
 * @copyright   2010 Jordi Piguillem <pigui0@hotmail.com>
 * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/wiki/backup/lion2/backup_wiki_stepslib.php');
require_once($CFG->dirroot . '/mod/wiki/backup/lion2/backup_wiki_settingslib.php');

/**
 * Provides all the settings and steps to perform one complete backup of the activity
 */
class backup_wiki_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the wiki.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_wiki_activity_structure_step('wiki_structure', 'wiki.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        // Link to the list of wikis
        $search = "/(" . $base . "\/mod\/wiki\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@WIKIINDEX*$2@$', $content);

        // Link to wiki view by moduleid
        $search = "/(" . $base . "\/mod\/wiki\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@WIKIVIEWBYID*$2@$', $content);

        // Link to wiki view by pageid
        $search = "/(" . $base . "\/mod\/wiki\/view.php\?pageid\=)([0-9]+)/";
        $content = preg_replace($search, '$@WIKIPAGEBYID*$2@$', $content);

        return $content;
    }
}
