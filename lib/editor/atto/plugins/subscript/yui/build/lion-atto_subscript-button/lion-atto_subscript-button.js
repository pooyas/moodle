YUI.add('lion-atto_subscript-button', function (Y, NAME) {



/*
 */

/**
 * @module lion-atto_subscript-button
 */

/**
 * Atto text editor subscript plugin.
 *
 * @namespace M.atto_subscript
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_subscript').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'subscript',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'sub'
        });
    }
});


}, '@VERSION@', {"requires": ["lion-editor_atto-plugin"]});
