YUI.add('lion-atto_unorderedlist-button', function (Y, NAME) {


/*
 * @package    atto
 * @subpackage unorderedlist
 * @copyright  2015 Pooya Saeedi  
 * 
 */

/**
 * @module     lion-atto_unorderedlist-button
 */

/**
 * Atto text editor unorderedlist plugin.
 *
 * @namespace M.atto_unorderedlist
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_unorderedlist').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'insertUnorderedList',
            icon: 'e/bullet_list',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'ul'
        });
    }
});


}, '@VERSION@', {"requires": ["lion-editor_atto-plugin"]});
