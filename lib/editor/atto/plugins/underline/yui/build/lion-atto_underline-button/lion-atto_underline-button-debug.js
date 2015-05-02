YUI.add('lion-atto_underline-button', function (Y, NAME) {


/*
 * @package    atto_underline
 * @copyright  2013 Damyon Wiese  <damyon@lion.com>
 * 
 */

/**
 * @module lion-atto_underline-button
 */

/**
 * Atto text editor underline plugin.
 *
 * @namespace M.atto_underline
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_underline').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'underline',

            // Key code for the keyboard shortcut which triggers this button:
            keys: '85',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'u'
        });
    }
});


}, '@VERSION@', {"requires": ["lion-editor_atto-plugin"]});
