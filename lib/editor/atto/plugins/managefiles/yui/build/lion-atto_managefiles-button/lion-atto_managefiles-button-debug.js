YUI.add('lion-atto_managefiles-button', function (Y, NAME) {


/**
 * @package    atto
 * @subpackage managefiles
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * @module lion-atto-managefiles-button
 */

/**
 * Atto text editor managefiles plugin.
 *
 * @namespace M.atto_link
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

var LOGNAME = 'atto_managefiles';

Y.namespace('M.atto_managefiles').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {

    /**
     * A reference to the current selection at the time that the dialogue
     * was opened.
     *
     * @property _currentSelection
     * @type Range
     * @private
     */
    _currentSelection: null,

    initializer: function() {
        if (this.get('disabled')) {
            return;
        }

        var host = this.get('host'),
            area = this.get('area'),
            options = host.get('filepickeroptions');

        if (options.image && options.image.itemid) {
            area.itemid = options.image.itemid;
            this.set('area', area);
        } else {
            Y.log('Plugin managefiles not available because itemid is missing.',
                    'warn', LOGNAME);
            return;
        }

        this.addButton({
            icon: 'e/manage_files',
            callback: this._displayDialogue
        });
    },

    /**
     * Display the manage files.
     *
     * @method _displayDialogue
     * @private
     */
    _displayDialogue: function(e) {
        e.preventDefault();

        var dialogue = this.getDialogue({
            headerContent: M.util.get_string('managefiles', LOGNAME),
            width: '800px',
            focusAfterHide: true
        });

        var iframe = Y.Node.create('<iframe></iframe>');
        // We set the height here because otherwise it is really small. That might not look
        // very nice on mobile devices, but we considered that enough for now.
        iframe.setStyles({
            height: '700px',
            border: 'none',
            width: '100%'
        });
        iframe.setAttribute('src', this._getIframeURL());

        dialogue.set('bodyContent', iframe)
                .show();

        this.markUpdated();
    },

    /**
     * Returns the URL to the file manager.
     *
     * @param _getIframeURL
     * @return {String} URL
     * @private
     */
    _getIframeURL: function() {
        var args = Y.mix({
                    elementid: this.get('host').get('elementid')
                },
                this.get('area'));
        return M.cfg.wwwroot + '/lib/editor/atto/plugins/managefiles/manage.php?' +
                Y.QueryString.stringify(args);
    }
}, {
    ATTRS: {
        disabled: {
            value: true
        },
        area: {
            value: {}
        }
    }
});


}, '@VERSION@', {"requires": ["lion-editor_atto-plugin"]});
