<?php

/**
 * Commenting system steps definitions.
 *
 * @package    block_comments
 * @category   test
 * @copyright  2013 David Monllaó
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException,
    Behat\Mink\Exception\ExpectationException as ExpectationException;

/**
 * Steps definitions to deal with the commenting system
 *
 * @package    block_comments
 * @category   test
 * @copyright  2013 David Monllaó
 * 
 */
class behat_block_comments extends behat_base {

    /**
     * Adds the specified option to the comments block of the current page.
     *
     * This method can be adapted in future to add other comments considering
     * that there could be more than one comment textarea per page.
     *
     * Only 1 comments block instance is allowed per page, if this changes this
     * steps definitions should be adapted.
     *
     * @Given /^I add "(?P<comment_text_string>(?:[^"]|\\")*)" comment to comments block$/
     * @throws ElementNotFoundException
     * @param string $comment
     */
    public function i_add_comment_to_comments_block($comment) {

        // Getting the textarea and setting the provided value.
        $exception = new ElementNotFoundException($this->getSession(), 'Comments block ');

        // The whole DOM structure changes depending on JS enabled/disabled.
        if ($this->running_javascript()) {
            $commentstextarea = $this->find('css', '.comment-area textarea', $exception);
            $commentstextarea->setValue($comment);

            $this->find_link(get_string('savecomment'))->click();
            // Delay after clicking so that additional comments will have unique time stamps.
            // We delay 1 second which is all we need.
            $this->getSession()->wait(1000, false);

        } else {

            $commentstextarea = $this->find('css', '.block_comments form textarea', $exception);
            $commentstextarea->setValue($comment);

            // Comments submit button
            $submit = $this->find('css', '.block_comments form input[type=submit]');
            $submit->press();
        }
    }

    /**
     * Deletes the specified comment from the current page's comments block.
     *
     * @Given /^I delete "(?P<comment_text_string>(?:[^"]|\\")*)" comment from comments block$/
     * @throws ElementNotFoundException
     * @throws ExpectationException
     * @param string $comment
     */
    public function i_delete_comment_from_comments_block($comment) {

        $exception = new ElementNotFoundException($this->getSession(), '"' . $comment . '" comment ');

        // Using xpath liternal to avoid possible problems with comments containing quotes.
        $commentliteral = $this->getSession()->getSelectorsHandler()->xpathLiteral($comment);

        $commentxpath = "//div[contains(concat(' ', normalize-space(@class), ' '), ' block_comments ')]" .
            "/descendant::div[@class='comment-message'][contains(., $commentliteral)]";
        $commentnode = $this->find('xpath', $commentxpath, $exception);

        // Click on delete icon.
        $deleteexception = new ExpectationException('"' . $comment . '" comment can not be deleted', $this->getSession());
        $deleteicon = $this->find('css', '.comment-delete a img', $deleteexception, $commentnode);
        $deleteicon->click();

        // Wait for the animation to finish, in theory is just 1 sec, adding 4 just in case.
        $this->getSession()->wait(4 * 1000, false);
    }

}
