<?php



/**
 * Defines backup_url_activity_task class
 *
 * @category    backup
 * @package    mod
 * @subpackage url
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/url/backup/lion2/backup_url_stepslib.php');

/**
 * Provides all the settings and steps to perform one complete backup of the activity
 */
class backup_url_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the url.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_url_activity_structure_step('url_structure', 'url.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot.'/mod/url','#');

        //Access a list of all links in a course
        $pattern = '#('.$base.'/index\.php\?id=)([0-9]+)#';
        $replacement = '$@URLINDEX*$2@$';
        $content = preg_replace($pattern, $replacement, $content);

        //Access the link supplying a course module id
        $pattern = '#('.$base.'/view\.php\?id=)([0-9]+)#';
        $replacement = '$@URLVIEWBYID*$2@$';
        $content = preg_replace($pattern, $replacement, $content);

        //Access the link supplying an instance id
        $pattern = '#('.$base.'/view\.php\?u=)([0-9]+)#';
        $replacement = '$@URLVIEWBYU*$2@$';
        $content = preg_replace($pattern, $replacement, $content);

        return $content;
    }
}
