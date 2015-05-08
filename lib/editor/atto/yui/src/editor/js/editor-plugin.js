
/**
 * Atto editor plugin.
 *
 * @module lion-editor_atto-plugin
 * @submodule plugin-base
 * @package    editor
 * @subpackage atto
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * A Plugin for the Atto Editor used in Lion.
 *
 * This class should not be directly instantiated, and all Editor plugins
 * should extend this class.
 *
 * @namespace M.editor_atto
 * @class EditorPlugin
 * @main
 * @constructor
 * @uses M.editor_atto.EditorPluginButtons
 * @uses M.editor_atto.EditorPluginDialogue
 */

function EditorPlugin() {
    EditorPlugin.superclass.constructor.apply(this, arguments);
}

var GROUPSELECTOR = '.atto_group.',
    GROUP = '_group';

Y.extend(EditorPlugin, Y.Base, {
    /**
     * The name of the current plugin.
     *
     * @property name
     * @type string
     */
    name: null,

    /**
     * A Node reference to the editor.
     *
     * @property editor
     * @type Node
     */
    editor: null,

    /**
     * A Node reference to the editor toolbar.
     *
     * @property toolbar
     * @type Node
     */
    toolbar: null,

    initializer: function(config) {
        // Set the references to configuration parameters.
        this.name = config.name;
        this.toolbar = config.toolbar;
        this.editor = config.editor;

        // Set up the prototypal properties.
        // These must be set up here becuase prototypal arrays and objects are copied across instances.
        this.buttons = {};
        this.buttonNames = [];
        this.buttonStates = {};
        this.menus = {};
        this._primaryKeyboardShortcut = [];
        this._buttonHandlers = [];
        this._menuHideHandlers = [];
        this._highlightQueue = {};
    },

    /**
     * Mark the content ediable content as having been changed.
     *
     * This is a convenience function and passes through to
     * {{#crossLink "M.editor_atto.EditorTextArea/updateOriginal"}}updateOriginal{{/crossLink}}.
     *
     * @method markUpdated
     */
    markUpdated: function() {
        // Save selection after changes to the DOM. If you don't do this here,
        // subsequent calls to restoreSelection() will fail expecting the
        // previous DOM state.
        this.get('host').saveSelection();

        return this.get('host').updateOriginal();
    }
}, {
    NAME: 'editorPlugin',
    ATTRS: {
        /**
         * The editor instance that this plugin was instantiated by.
         *
         * @attribute host
         * @type M.editor_atto.Editor
         * @writeOnce
         */
        host: {
            writeOnce: true
        },

        /**
         * The toolbar group that this button belongs to.
         *
         * When setting, the name of the group should be specified.
         *
         * When retrieving, the Node for the toolbar group is returned. If
         * the group doesn't exist yet, then it is created first.
         *
         * @attribute group
         * @type Node
         * @writeOnce
         */
        group: {
            writeOnce: true,
            getter: function(groupName) {
                var group = this.toolbar.one(GROUPSELECTOR + groupName + GROUP);
                if (!group) {
                    group = Y.Node.create('<div class="atto_group ' +
                            groupName + GROUP + '"></div>');
                    this.toolbar.append(group);
                }

                return group;
            }
        }
    }
});

Y.namespace('M.editor_atto').EditorPlugin = EditorPlugin;
