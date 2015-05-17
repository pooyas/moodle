

/*
 */

/**
 * @module lion-atto_orderedlist-button
 */

/**
 * Atto text editor orderedlist plugin.
 *
 * @namespace M.atto_orderedlist
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_orderedlist').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'insertOrderedList',
            icon: 'e/numbered_list',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'ol'
        });
    }
});
