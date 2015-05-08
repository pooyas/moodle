YUI.add('lion-atto_clear-button', function (Y, NAME) {


/*
 * @package    atto
 * @subpackage clear
 * @copyright  2015 Pooya Saeedi  
 * 
 */

/**
 * @module lion-atto_clear-button
 */

/**
 * Atto text editor clear plugin.
 *
 * @namespace M.atto_clear
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_clear').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'removeFormat',
            icon: 'e/clear_formatting'
        });
    }
});


}, '@VERSION@', {"requires": ["lion-editor_atto-plugin"]});
