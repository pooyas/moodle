
/**
 * @module lion-editor_atto-plugin
 * @submodule dialogue
 */

/**
 * Dialogue functions for an Atto Plugin.
 *
 * See {{#crossLink "M.editor_atto.EditorPlugin"}}{{/crossLink}} for details.
 *
 * @namespace M.editor_atto
 * @class EditorPluginDialogue
 */

function EditorPluginDialogue() {}

EditorPluginDialogue.ATTRS= {
};

EditorPluginDialogue.prototype = {
    /**
     * A reference to the instantiated dialogue.
     *
     * @property _dialogue
     * @private
     * @type M.core.Dialogue
     */
    _dialogue: null,

    /**
     * Fetch the instantiated dialogue. If a dialogue has not yet been created, instantiate one.
     *
     * <em><b>Note:</b> Only one dialogue is supported through this interface.</em>
     *
     * For a full list of options, see documentation for {{#crossLink "M.core.dialogue"}}{{/crossLink}}.
     *
     * A sensible default is provided for the focusAfterHide attribute.
     *
     * @method getDialogue
     * @param {object} config
     * @param {boolean|string|Node} [config.focusAfterHide=undefined] Set the focusAfterHide setting to the
     * specified Node according to the following values:
     * <ul>
     * <li>If true was passed, the first button for this plugin will be used instead; or</li>
     * <li>If a String was passed, the named button for this plugin will be used instead; or</li>
     * <li>If a Node was passed, that Node will be used instead.</li>
     *
     * This setting is checked each time that getDialogue is called.
     *
     * @return {M.core.dialogue}
     */
    getDialogue: function(config) {
        // Config is an optional param - define a default.
        config = config || {};

        var focusAfterHide = false;
        if (config.focusAfterHide) {
            // Remove the focusAfterHide because we may pass it a non-node value.
            focusAfterHide = config.focusAfterHide;
            delete config.focusAfterHide;
        }

        if (!this._dialogue) {
            // Merge the default configuration with any provided configuration.
            var dialogueConfig = Y.merge({
                    visible: false,
                    modal: true,
                    close: true,
                    draggable: true
                }, config);

            // Instantiate the dialogue.
            this._dialogue = new M.core.dialogue(dialogueConfig);
        }

        if (focusAfterHide !== false) {
            if (focusAfterHide === true) {
                this._dialogue.set('focusAfterHide', this.buttons[this.buttonNames[0]]);

            } else if (typeof focusAfterHide === 'string') {
                this._dialogue.set('focusAfterHide', this.buttons[focusAfterHide]);

            } else {
                this._dialogue.set('focusAfterHide', focusAfterHide);

            }
        }

        return this._dialogue;
    }
};

Y.Base.mix(Y.M.editor_atto.EditorPlugin, [EditorPluginDialogue]);
