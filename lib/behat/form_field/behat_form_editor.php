<?php


/**
 * Lion editor field.
 *
 * @category   test
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

use Behat\Mink\Element\NodeElement as NodeElement;

require_once(__DIR__ . '/behat_form_textarea.php');

/**
 * Lion editor field.
 *
 * @todo Support for multiple editors
 * @category  test
 */
class behat_form_editor extends behat_form_textarea {

    /**
     * Sets the value to a field.
     *
     * @param string $value
     * @return void
     */
    public function set_value($value) {

        $editorid = $this->field->getAttribute('id');
        if ($this->running_javascript()) {
            $value = addslashes($value);
            $js = '
var editor = Y.one(document.getElementById("'.$editorid.'editable"));
if (editor) {
    editor.setHTML("' . $value . '");
}
editor = Y.one(document.getElementById("'.$editorid.'"));
editor.set("value", "' . $value . '");
';
            $this->session->executeScript($js);
        } else {
            parent::set_value($value);
        }
    }

    /**
     * Select all the text in the form field.
     *
     */
    public function select_text() {
        // NodeElement.keyPress simply doesn't work.
        if (!$this->running_javascript()) {
            throw new coding_exception('Selecting text requires javascript.');
        }

        $editorid = $this->field->getAttribute('id');
        $js = ' (function() {
    var e = document.getElementById("'.$editorid.'editable"),
        r = rangy.createRange(),
        s = rangy.getSelection();

    while ((e.firstChild !== null) && (e.firstChild.nodeType != document.TEXT_NODE)) {
        e = e.firstChild;
    }
    e.focus();
    r.selectNodeContents(e);
    s.setSingleRange(r);
}()); ';
        $this->session->executeScript($js);
    }

    /**
     * Matches the provided value against the current field value.
     *
     * @param string $expectedvalue
     * @return bool The provided value matches the field value?
     */
    public function matches($expectedvalue) {
        // A text editor may silently wrap the content in p tags (or not). Neither is an error.
        return $this->text_matches($expectedvalue) || $this->text_matches('<p>' . $expectedvalue . '</p>');
    }
}

