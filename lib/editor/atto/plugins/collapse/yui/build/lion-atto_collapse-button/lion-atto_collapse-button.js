YUI.add('lion-atto_collapse-button', function (Y, NAME) {


/*
 * @package    atto
 * @subpackage collapse
 * @copyright  2015 Pooya Saeedi  
 * 
 */

/**
 * @module lion-atto_collapse-button
 */

/**
 * Atto text editor collapse plugin.
 *
 * @namespace M.atto_collapse
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

var PLUGINNAME = 'atto_collapse',
    ATTRSHOWGROUPS = 'showgroups',
    COLLAPSE = 'collapse',
    COLLAPSED = 'collapsed',
    GROUPS = '.atto_group';

Y.namespace('M.atto_collapse').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
    initializer: function() {
        var toolbarGroupCount = Y.Object.size(this.get('host').get('plugins'));
        if (toolbarGroupCount <= 1 + parseInt(this.get(ATTRSHOWGROUPS), 10)) {
            return;
        }

        if (this.toolbar.all(GROUPS).size() > this.get(ATTRSHOWGROUPS)) {
            return;
        }

        var button = this.addButton({
            icon: 'icon',
            iconComponent: PLUGINNAME,
            callback: this._toggle
        });

        // Perform a toggle after all plugins have been loaded for the first time.
        this.get('host').on('pluginsloaded', function(e, button) {
            this._setVisibility(button);

            // Set the toolbar to break after the initial those displayed by default.
            var firstGroup = this.toolbar.all(GROUPS).item(this.get(ATTRSHOWGROUPS));
            firstGroup.insert('<div class="toolbarbreak"></div>', 'before');
        }, this, button);
    },

    /**
     * Toggle the visibility of the extra groups in the toolbar.
     *
     * @method _toggle
     * @param {EventFacade} e
     * @private
     */
    _toggle: function(e) {
        e.preventDefault();
        var button = this.buttons[COLLAPSE];

        if (button.getData(COLLAPSED)) {
            this.highlightButtons(COLLAPSE);
            this._setVisibility(button, true);
        } else {
            this.unHighlightButtons(COLLAPSE);
            this._setVisibility(button);
        }

        this.buttons[this.name].focus();
    },

    /**
     * Set the visibility of the toolbar groups.
     *
     * @method _setVisibility
     * @param {Node} button The collapse button
     * @param {Booelan} visibility Whether the groups should be made visible
     * @private
     */
    _setVisibility: function(button, visibility) {
        var groups = this.toolbar.all(GROUPS).slice(this.get(ATTRSHOWGROUPS));

        if (visibility) {
            button.set('title', M.util.get_string('showfewer', PLUGINNAME));
            groups.show();
            button.setData(COLLAPSED, false);
        } else {
            button.set('title', M.util.get_string('showmore', PLUGINNAME));
            groups.hide();
            button.setData(COLLAPSED, true);
        }

    }
}, {
    ATTRS: {
        /**
         * How many groups to show when collapsed.
         *
         * @attribute showgroups
         * @type Number
         * @default 3
         */
        showgroups: {
            value: 3
        }
    }
});


}, '@VERSION@', {"requires": ["lion-editor_atto-plugin"]});
