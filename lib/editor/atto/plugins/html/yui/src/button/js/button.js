
/*
 * @package    atto
 * @subpackage html
 * @copyright  2015 Pooya Saeedi  
 * 
 */

/**
 * @module     lion-atto_html-button
 */

/**
 * Atto text editor HTML plugin.
 *
 * @namespace M.atto_html
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_html').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addButton({
            icon: 'e/source_code',
            callback: this._toggleHTML
        });
    },

    /**
     * Toggle the view between the content editable div, and the textarea,
     * updating the content as it goes.
     *
     * @method _toggleHTML
     * @private
     */
    _toggleHTML: function() {
        // Toggle the HTML status.
        this.set('isHTML', !this.get('isHTML'));

        // Now make the UI changes.
        this._showHTML();
    },

    /**
     * Set the current state of the textarea and contenteditable div
     * according to the isHTML property.
     *
     * @method _showHTML
     * @private
     */
    _showHTML: function() {
        var host = this.get('host');
        if (!this.get('isHTML')) {
            // Unhighlight icon.
            this.unHighlightButtons('html');

            // Enable all plugins.
            host.enablePlugins();

            // Copy the text to the contenteditable div.
            host.updateFromTextArea();

            // Hide the textarea, and show the editor.
            host.textarea.hide();
            this.editor.show();

            // Focus on the editor.
            host.focus();

            // And re-mark everything as updated.
            this.markUpdated();
        } else {
            // Highlight icon.
            this.highlightButtons('html');

            // Disable all plugins.
            host.disablePlugins();

            // And then re-enable this one.
            host.enablePlugins(this.name);

            // Copy the text to the contenteditable div.
            host.updateOriginal();

            // Get the width, padding, and margin of the editor.
            host.textarea.setStyles({
                'width': this.editor.getComputedStyle('width'),
                'height': this.editor.getComputedStyle('height'),
                'margin': this.editor.getComputedStyle('margin'),
                'padding': this.editor.getComputedStyle('padding')
            });

            // Hide the editor, and show the textarea.
            this.editor.hide();
            host.textarea.show();


            // Focus on the textarea.
            host.textarea.focus();
        }
    }
}, {
    ATTRS: {
        /**
         * The current state for the HTML view. If true, the HTML source is
         * shown in a textarea, otherwise the contenteditable area is
         * displayed.
         *
         * @attribute isHTML
         * @type Boolean
         * @default false
         */
        isHTML: {
            value: false
        }
    }
});
