<?php


/**
 * Defines {@link backup_workshop_activity_task} class
 *
 * @package     mod_workshop
 * @category    backup
 * @copyright   2010 David Mudrak <david.mudrak@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/workshop/backup/lion2/backup_workshop_settingslib.php');
require_once($CFG->dirroot . '/mod/workshop/backup/lion2/backup_workshop_stepslib.php');

/**
 * Provides all the settings and steps to perform one complete backup of workshop activity
 */
class backup_workshop_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the workshop.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_workshop_activity_structure_step('workshop_structure', 'workshop.xml'));
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

        // Link to the list of workshops
        $search = "/(" . $base . "\/mod\/workshop\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@WORKSHOPINDEX*$2@$', $content);

        //Link to workshop view by moduleid
        $search = "/(" . $base . "\/mod\/workshop\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@WORKSHOPVIEWBYID*$2@$', $content);

        return $content;
    }
}
