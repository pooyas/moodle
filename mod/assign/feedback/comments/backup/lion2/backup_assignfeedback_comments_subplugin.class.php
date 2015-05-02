<?php

/**
 * This file contains the class for backup of this feedback plugin
 *
 * @package   assignfeedback_comments
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Provides the information to backup comments feedback.
 *
 * This just records the text and format.
 *
 * @package   assignfeedback_comments
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * 
 */
class backup_assignfeedback_comments_subplugin extends backup_subplugin {

    /**
     * Returns the subplugin information to attach to submission element.
     * @return backup_subplugin_element
     */
    protected function define_grade_subplugin_structure() {

        // Create XML elements.
        $subplugin = $this->get_subplugin_element();
        $subpluginwrapper = new backup_nested_element($this->get_recommended_name());
        $subpluginelement = new backup_nested_element('feedback_comments',
                                                      null,
                                                      array('commenttext', 'commentformat', 'grade'));

        // Connect XML elements into the tree.
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subpluginelement);

        // Set source to populate the data.
        $subpluginelement->set_source_table('assignfeedback_comments',
                                            array('grade' => backup::VAR_PARENTID));

        return $subplugin;
    }
}
