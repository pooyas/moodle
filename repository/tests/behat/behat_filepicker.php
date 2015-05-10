<?php

/**
 * Filemanager and filepicker manipulation steps definitions.
 *
 * @package    core
 * @subpackage filepicker
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../lib/behat/behat_files.php');

use Behat\Mink\Exception\ExpectationException as ExpectationException,
    Behat\Gherkin\Node\TableNode as TableNode;

/**
 * Steps definitions to deal with the filemanager and filepicker.
 *
 * Extends behat_files rather than behat_base as is file-related.
 *
 */
class behat_filepicker extends behat_files {

    /**
     * Creates a folder with specified name in the current folder and in the specified filemanager field.
     *
     * @Given /^I create "(?P<foldername_string>(?:[^"]|\\")*)" folder in "(?P<filemanager_field_string>(?:[^"]|\\")*)" filemanager$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $foldername
     * @param string $filemanagerelement
     */
    public function i_create_folder_in_filemanager($foldername, $filemanagerelement) {

        $fieldnode = $this->get_filepicker_node($filemanagerelement);

        // Looking for the create folder button inside the specified filemanager.
        $exception = new ExpectationException('No folders can be created in "'.$filemanagerelement.'" filemanager', $this->getSession());
        $newfolder = $this->find('css', 'div.fp-btn-mkdir a', $exception, $fieldnode);
        $newfolder->click();

        // Setting the folder name in the modal window.
        $exception = new ExpectationException('The dialog to enter the folder name does not appear', $this->getSession());
        $dialoginput = $this->find('css', '.fp-mkdir-dlg-text input', $exception);
        $dialoginput->setValue($foldername);

        $exception = new ExpectationException('The button for the create folder dialog can not be located', $this->getSession());
        $dialognode = $this->find('css', '.lion-dialogue-focused');
        $buttonnode = $this->find('css', '.fp-dlg-butcreate', $exception, $dialognode);
        $buttonnode->click();
    }

    /**
     * Opens the contents of a filemanager folder. It looks for the folder in the current folder and in the path bar.
     *
     * @Given /^I open "(?P<foldername_string>(?:[^"]|\\")*)" folder from "(?P<filemanager_field_string>(?:[^"]|\\")*)" filemanager$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $foldername
     * @param string $filemanagerelement
     */
    public function i_open_folder_from_filemanager($foldername, $filemanagerelement) {

        $fieldnode = $this->get_filepicker_node($filemanagerelement);

        $exception = new ExpectationException(
            'The "'.$foldername.'" folder can not be found in the "'.$filemanagerelement.'" filemanager',
            $this->getSession()
        );

        $folderliteral = $this->getSession()->getSelectorsHandler()->xpathLiteral($foldername);

        // We look both in the pathbar and in the contents.
        try {

            // In the current folder workspace.
            $folder = $this->find(
                'xpath',
                "//div[contains(concat(' ', normalize-space(@class), ' '), ' fp-folder ')]" .
                    "/descendant::div[contains(concat(' ', normalize-space(@class), ' '), ' fp-filename ')]" .
                    "[normalize-space(.)=$folderliteral]",
                $exception,
                $fieldnode
            );
        } catch (ExpectationException $e) {

            // And in the pathbar.
            $folder = $this->find(
                'xpath',
                "//a[contains(concat(' ', normalize-space(@class), ' '), ' fp-path-folder-name ')]" .
                    "[normalize-space(.)=$folderliteral]",
                $exception,
                $fieldnode
            );
        }

        // It should be a NodeElement, otherwise an exception would have been thrown.
        $folder->click();
    }

    /**
     * Unzips the specified file from the specified filemanager field. The zip file has to be visible in the current folder.
     *
     * @Given /^I unzip "(?P<filename_string>(?:[^"]|\\")*)" file from "(?P<filemanager_field_string>(?:[^"]|\\")*)" filemanager$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $filename
     * @param string $filemanagerelement
     */
    public function i_unzip_file_from_filemanager($filename, $filemanagerelement) {

        // Open the contextual menu of the filemanager element.
        $this->open_element_contextual_menu($filename, $filemanagerelement);

        // Execute the action.
        $exception = new ExpectationException($filename.' element can not be unzipped', $this->getSession());
        $this->perform_on_element('unzip', $exception);
    }

    /**
     * Zips the specified folder from the specified filemanager field. The folder has to be in the current folder.
     *
     * @Given /^I zip "(?P<filename_string>(?:[^"]|\\")*)" folder from "(?P<filemanager_field_string>(?:[^"]|\\")*)" filemanager$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $foldername
     * @param string $filemanagerelement
     */
    public function i_zip_folder_from_filemanager($foldername, $filemanagerelement) {

        // Open the contextual menu of the filemanager element.
        $this->open_element_contextual_menu($foldername, $filemanagerelement);

        // Execute the action.
        $exception = new ExpectationException($foldername.' element can not be zipped', $this->getSession());
        $this->perform_on_element('zip', $exception);
    }

    /**
     * Deletes the specified file or folder from the specified filemanager field.
     *
     * @Given /^I delete "(?P<file_or_folder_name_string>(?:[^"]|\\")*)" from "(?P<filemanager_field_string>(?:[^"]|\\")*)" filemanager$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $name
     * @param string $filemanagerelement
     */
    public function i_delete_file_from_filemanager($name, $filemanagerelement) {

        // Open the contextual menu of the filemanager element.
        $this->open_element_contextual_menu($name, $filemanagerelement);

        // Execute the action.
        $exception = new ExpectationException($name.' element can not be deleted', $this->getSession());
        $this->perform_on_element('delete', $exception);

        // Yes, we are sure.
        // Using xpath + click instead of pressButton as 'Ok' it is a common string.
        $okbutton = $this->find('css', 'div.fp-dlg button.fp-dlg-butconfirm');
        $okbutton->click();
    }


    /**
     * Makes sure user can see the exact number of elements (files in folders) in the filemanager.
     *
     * @Then /^I should see "(?P<elementscount_number>\d+)" elements in "(?P<filemanagerelement_string>(?:[^"]|\\")*)" filemanager$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param int $elementscount
     * @param string $filemanagerelement
     */
    public function i_should_see_elements_in_filemanager($elementscount, $filemanagerelement) {
        $filemanagernode = $this->get_filepicker_node($filemanagerelement);

        // We count .fp-file elements inside a filemanager not being updated.
        $xpath = "//div[contains(concat(' ', normalize-space(@class), ' '), ' filemanager ')]" .
            "[not(contains(concat(' ', normalize-space(@class), ' '), ' fm-updating '))]" .
            "//div[contains(concat(' ', normalize-space(@class), ' '), ' fp-content ')]" .
            "//div[contains(concat(' ', normalize-space(@class), ' '), ' fp-file ')]";

        $elements = $this->find_all('xpath', $xpath, false, $filemanagernode);
        if (count($elements) != $elementscount) {
            throw new ExpectationException('Found '.count($elements).' elements in filemanager instead of expected '.$elementscount, $this->getSession());
        }
    }

    /**
     * Picks the file from repository leaving default values in select file dialogue.
     *
     * @When /^I add "(?P<filepath_string>(?:[^"]|\\")*)" file from "(?P<repository_string>(?:[^"]|\\")*)" to "(?P<filemanagerelement_string>(?:[^"]|\\")*)" filemanager$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $filepath
     * @param string $repository
     * @param string $filemanagerelement
     */
    public function i_add_file_from_repository_to_filemanager($filepath, $repository, $filemanagerelement) {
        $this->add_file_from_repository_to_filemanager($filepath, $repository, $filemanagerelement, new TableNode(), false);
    }

    /**
     * Picks the file from repository leaving default values in select file dialogue and confirming to overwrite an existing file.
     *
     * @When /^I add and overwrite "(?P<filepath_string>(?:[^"]|\\")*)" file from "(?P<repository_string>(?:[^"]|\\")*)" to "(?P<filemanagerelement_string>(?:[^"]|\\")*)" filemanager$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $filepath
     * @param string $repository
     * @param string $filemanagerelement
     */
    public function i_add_and_overwrite_file_from_repository_to_filemanager($filepath, $repository, $filemanagerelement) {
        $this->add_file_from_repository_to_filemanager($filepath, $repository, $filemanagerelement, new TableNode(),
                get_string('overwrite', 'repository'));
    }

    /**
     * Picks the file from repository filling the form in Select file dialogue.
     *
     * @When /^I add "(?P<filepath_string>(?:[^"]|\\")*)" file from "(?P<repository_string>(?:[^"]|\\")*)" to "(?P<filemanager_field_string>(?:[^"]|\\")*)" filemanager as:$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $filepath
     * @param string $repository
     * @param string $filemanagerelement
     * @param TableNode $data Data to fill the form in Select file dialogue
     */
    public function i_add_file_from_repository_to_filemanager_as($filepath, $repository, $filemanagerelement, TableNode $data) {
        $this->add_file_from_repository_to_filemanager($filepath, $repository, $filemanagerelement, $data, false);
    }

    /**
     * Picks the file from repository confirming to overwrite an existing file
     *
     * @When /^I add and overwrite "(?P<filepath_string>(?:[^"]|\\")*)" file from "(?P<repository_string>(?:[^"]|\\")*)" to "(?P<filemanager_field_string>(?:[^"]|\\")*)" filemanager as:$/
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $filepath
     * @param string $repository
     * @param string $filemanagerelement
     * @param TableNode $data Data to fill the form in Select file dialogue
     */
    public function i_add_and_overwrite_file_from_repository_to_filemanager_as($filepath, $repository, $filemanagerelement, TableNode $data) {
        $this->add_file_from_repository_to_filemanager($filepath, $repository, $filemanagerelement, $data,
                get_string('overwrite', 'repository'));
    }

    /**
     * Picks the file from private files repository
     *
     * @throws ExpectationException Thrown by behat_base::find
     * @param string $filepath
     * @param string $repository
     * @param string $filemanagerelement
     * @param TableNode $data Data to fill the form in Select file dialogue
     * @param false|string $overwriteaction false if we don't expect that file with the same name already exists,
     *     or button text in overwrite dialogue ("Overwrite", "Rename to ...", "Cancel")
     */
    protected function add_file_from_repository_to_filemanager($filepath, $repository, $filemanagerelement, TableNode $data,
            $overwriteaction = false) {
        $filemanagernode = $this->get_filepicker_node($filemanagerelement);

        // Opening the select repository window and selecting the upload repository.
        $this->open_add_file_window($filemanagernode, $repository);

        $this->open_element_contextual_menu($filepath);

        // Fill the form in Select window.
        $datahash = $data->getRowsHash();

        // The action depends on the field type.
        foreach ($datahash as $locator => $value) {

            $field = behat_field_manager::get_form_field_from_label($locator, $this);

            // Delegates to the field class.
            $field->set_value($value);
        }

        $this->find_button(get_string('getfile', 'repository'))->click();

        // We wait for all the JS to finish as it is performing an action.
        $this->getSession()->wait(self::TIMEOUT, self::PAGE_READY_JS);

        if ($overwriteaction !== false) {
            $overwritebutton = $this->find_button($overwriteaction);
            $this->ensure_node_is_visible($overwritebutton);
            $overwritebutton->click();

            // We wait for all the JS to finish.
            $this->getSession()->wait(self::TIMEOUT, self::PAGE_READY_JS);
        }

    }

}
