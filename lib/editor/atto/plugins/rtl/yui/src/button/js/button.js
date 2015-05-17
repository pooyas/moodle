

/*
 */

/**
 * @module lion-atto_rtl-button
 */

/**
 * Atto text editor rtl plugin.
 *
 * @namespace M.atto_rtl
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

Y.namespace('M.atto_rtl').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        var direction;

        direction = 'ltr';
        this.addButton({
            icon: 'e/left_to_right',
            title: direction,
            buttonName: direction,
            callback: this._toggleRTL,
            callbackArgs: direction
        });

        direction = 'rtl';
        this.addButton({
            icon: 'e/right_to_left',
            title: direction,
            buttonName: direction,
            callback: this._toggleRTL,
            callbackArgs: direction
        });
    },

    /**
     * Toggle the RTL/LTR values based on the supplied direction.
     *
     * @method _toggleRTL
     * @param {EventFacade} e
     * @param {String} direction
     */
    _toggleRTL: function(e, direction) {
        var host = this.get('host'),
            selection = host.getSelection();
        if (selection) {
            // Format the selection to be sure it has a tag parent (not the contenteditable).
            var parentNode = host.formatSelectionBlock(),
                parentDOMNode = parentNode.getDOMNode();

            var currentDirection = parentDOMNode.getAttribute('dir');
            if (currentDirection === direction) {
                parentDOMNode.removeAttribute("dir");
            } else {
                parentDOMNode.setAttribute("dir", direction);
            }

            // Mark the text as having been updated.
            this.markUpdated();
        }
    }
});
