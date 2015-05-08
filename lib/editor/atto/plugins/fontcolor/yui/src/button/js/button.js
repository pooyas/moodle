
/*
 * @package    atto
 * @subpackage fontcolor
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * @module lion-atto_align-button
 */

/**
 * Atto text editor fontcolor plugin.
 *
 * @namespace M.atto_fontcolor
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

Y.namespace('M.atto_fontcolor').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        var items = [];
        Y.Array.each(colors, function(color) {
            items.push({
                text: '<div style="width: 20px; height: 20px; border: 1px solid #CCC; background-color: ' +
                        color.color +
                        '"></div>',
                callbackArgs: color.color,
                callback: this._changeStyle
            });
        });

        this.addToolbarMenu({
            icon: 'e/text_color',
            overlayWidth: '4',
            menuColor: '#333333',
            globalItemConfig: {
                callback: this._changeStyle
            },
            items: items
        });
    },

    /**
     * Change the font color to the specified color.
     *
     * @method _changeStyle
     * @param {EventFacade} e
     * @param {string} color The new font color
     * @private
     */
    _changeStyle: function(e, color) {
        this.get('host').formatSelectionInlineStyle({
            color: color
        });
    }
});
