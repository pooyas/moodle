YUI.add('lion-atto_strike-button', function (Y, NAME) {


/*
 * @package    atto_strike
 * @copyright  2013 Damyon Wiese  <damyon@lion.com>
 * 
 */

/**
 * @module lion-atto_strike-button
 */

/**
 * Atto text editor strike plugin.
 *
 * @namespace M.atto_strike
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_strike').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'strikeThrough',
            icon: 'e/strikethrough',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'strike'
        });
    }
});


}, '@VERSION@', {"requires": ["lion-editor_atto-plugin"]});
