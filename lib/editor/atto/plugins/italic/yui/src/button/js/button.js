

/*
 */

/**
 * @module     lion-atto_italic-button
 */

/**
 * Atto text editor italic plugin.
 *
 * @namespace M.atto_italic
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_italic').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'italic',

            // Key code for the keyboard shortcut which triggers this button:
            keys: '73',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'i'
        });
    }
});
