<?php

/**
 * Steps definitions related with the forum activity.
 *
 * @package    mod
 * @subpackage forum
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Gherkin\Node\TableNode as TableNode;
/**
 * Forum-related steps definitions.
 *
 */
class behat_mod_forum extends behat_base {

    /**
     * Adds a topic to the forum specified by it's name. Useful for the News forum and blog-style forums.
     *
     * @Given /^I add a new topic to "(?P<forum_name_string>(?:[^"]|\\")*)" forum with:$/
     * @param string $forumname
     * @param TableNode $table
     */
    public function i_add_a_new_topic_to_forum_with($forumname, TableNode $table) {
        return $this->add_new_discussion($forumname, $table, get_string('addanewtopic', 'forum'));
    }

    /**
     * Adds a discussion to the forum specified by it's name with the provided table data (usually Subject and Message). The step begins from the forum's course page.
     *
     * @Given /^I add a new discussion to "(?P<forum_name_string>(?:[^"]|\\")*)" forum with:$/
     * @param string $forumname
     * @param TableNode $table
     */
    public function i_add_a_forum_discussion_to_forum_with($forumname, TableNode $table) {
        return $this->add_new_discussion($forumname, $table, get_string('addanewdiscussion', 'forum'));
    }

    /**
     * Adds a reply to the specified post of the specified forum. The step begins from the forum's page or from the forum's course page.
     *
     * @Given /^I reply "(?P<post_subject_string>(?:[^"]|\\")*)" post from "(?P<forum_name_string>(?:[^"]|\\")*)" forum with:$/
     * @param string $postname The subject of the post
     * @param string $forumname The forum name
     * @param TableNode $table
     */
    public function i_reply_post_from_forum_with($postsubject, $forumname, TableNode $table) {

        return array(
            new Given('I follow "' . $this->escape($forumname) . '"'),
            new Given('I follow "' . $this->escape($postsubject) . '"'),
            new Given('I follow "' . get_string('reply', 'forum') . '"'),
            new Given('I set the following fields to these values:', $table),
            new Given('I press "' . get_string('posttoforum', 'forum') . '"'),
            new Given('I wait to be redirected')
        );

    }

    /**
     * Returns the steps list to add a new discussion to a forum.
     *
     * Abstracts add a new topic and add a new discussion, as depending
     * on the forum type the button string changes.
     *
     * @param string $forumname
     * @param TableNode $table
     * @param string $buttonstr
     * @return Given[]
     */
    protected function add_new_discussion($forumname, TableNode $table, $buttonstr) {

        // Escaping $forumname as it has been stripped automatically by the transformer.
        return array(
            new Given('I follow "' . $this->escape($forumname) . '"'),
            new Given('I press "' . $buttonstr . '"'),
            new Given('I set the following fields to these values:', $table),
            new Given('I press "' . get_string('posttoforum', 'forum') . '"'),
            new Given('I wait to be redirected')
        );

    }

}
