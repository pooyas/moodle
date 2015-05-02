
/*
 * @package    atto_superscript
 * @copyright  2014 Rosiana Wijaya <rwijaya@lion.com>
 * 
 */

/**
 * @module     lion-atto_superscript-button
 */

/**
 * Atto text editor superscript plugin.
 *
 * @namespace M.atto_superscript
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_superscript').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'superscript',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'sup'
        });
    }
});
