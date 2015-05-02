YUI.add('lion-atto_title-button', function (Y, NAME) {


/*
 * @package    atto_title
 * @copyright  2013 Damyon Wiese  <damyon@lion.com>
 * 
 */

/**
 * @module lion-atto_title-button
 */

/**
 * Atto text editor title plugin.
 *
 * @namespace M.atto_title
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

var component = 'atto_title',
    styles = [
        {
            text: 'h3',
            callbackArgs: '<h3>'
        },
        {
            text: 'h4',
            callbackArgs: '<h4>'
        },
        {
            text: 'h5',
            callbackArgs: '<h5>'
        },
        {
            text: 'pre',
            callbackArgs: '<pre>'
        },
        {
            text: 'p',
            callbackArgs: '<p>'
        }
    ];

Y.namespace('M.atto_title').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        var items = [];
        Y.Array.each(styles, function(style) {
            items.push({
                text: M.util.get_string(style.text, component),
                callbackArgs: style.callbackArgs
            });
        });
        this.addToolbarMenu({
            icon: 'e/styleprops',
            globalItemConfig: {
                callback: this._changeStyle
            },
            items: items
        });
    },

    /**
     * Change the title to the specified style.
     *
     * @method _changeStyle
     * @param {EventFacade} e
     * @param {string} color The new style
     * @private
     */
    _changeStyle: function(e, style) {
        document.execCommand('formatBlock', false, style);

        // Mark as updated
        this.markUpdated();
    }
});


}, '@VERSION@', {"requires": ["lion-editor_atto-plugin"]});
