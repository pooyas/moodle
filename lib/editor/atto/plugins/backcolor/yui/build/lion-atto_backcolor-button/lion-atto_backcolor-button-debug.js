YUI.add('lion-atto_backcolor-button', function (Y, NAME) {


/*
 * @package    atto
 * @subpackage backcolor
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * @module lion-atto_backcolor-button
 */

/**
 * Atto text editor backcolor plugin.
 *
 * @namespace M.atto_backcolor
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

var colors = [
        {
            name: 'white',
            color: '#FFFFFF'
        }, {
            name: 'red',
            color: '#EF4540'
        }, {
            name: 'yellow',
            color: '#FFCF35'
        }, {
            name: 'green',
            color: '#98CA3E'
        }, {
            name: 'blue',
            color: '#7D9FD3'
        }, {
            name: 'black',
            color: '#333333'
        }
    ];

Y.namespace('M.atto_backcolor').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        var items = [];
        Y.Array.each(colors, function(color) {
            items.push({
                text: '<div style="width: 20px; height: 20px; border: 1px solid #CCC; background-color: ' +
                        color.color +
                        '"></div>',
                callbackArgs: color.color
            });
        });

        this.addToolbarMenu({
            icon: 'e/text_highlight',
            overlayWidth: '4',
            globalItemConfig: {
                callback: this._changeStyle
            },
            items: items
        });
    },

    /**
     * Change the background color to the specified color.
     *
     * @method _changeStyle
     * @param {EventFacade} e
     * @param {string} color The new background color
     * @private
     */
    _changeStyle: function(e, color) {
        this.get('host').formatSelectionInlineStyle({
            backgroundColor: color
        });
    }
});


}, '@VERSION@');
