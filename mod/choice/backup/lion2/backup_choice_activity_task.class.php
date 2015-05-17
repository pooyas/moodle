<?php



/**
 * Defines backup_choice_activity_task class
 *
 * @category    backup
 * @package    mod
 * @subpackage choice
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/choice/backup/lion2/backup_choice_stepslib.php');
require_once($CFG->dirroot . '/mod/choice/backup/lion2/backup_choice_settingslib.php');

/**
 * Provides the steps to perform one complete backup of the Choice instance
 */
class backup_choice_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the choice.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_choice_activity_structure_step('choice_structure', 'choice.xml'));
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

        // Link to the list of choices
        $search="/(".$base."\/mod\/choice\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@CHOICEINDEX*$2@$', $content);

        // Link to choice view by moduleid
        $search="/(".$base."\/mod\/choice\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@CHOICEVIEWBYID*$2@$', $content);

        return $content;
    }
}
