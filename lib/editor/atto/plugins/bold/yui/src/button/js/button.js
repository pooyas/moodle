
/*
 * @package    atto_bold
 * @copyright  2013 Damyon Wiese  <damyon@lion.com>
 * 
 */

/**
 * @module lion-atto_bold-button
 */

/**
 * Atto text editor bold plugin.
 *
 * @namespace M.atto_bold
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_bold').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'bold',

            // Key code for the keyboard shortcut which triggers this button:
            keys: '66',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'b, strong'
        });
    }
});
