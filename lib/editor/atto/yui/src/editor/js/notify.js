

/**
 * A notify function for the Atto editor.
 *
 * @module     lion-editor_atto-notify
 * @submodule  notify
 */

var LOGNAME_NOTIFY = 'lion-editor_atto-editor-notify',
    NOTIFY_INFO = 'info',
    NOTIFY_WARNING = 'warning';

function EditorNotify() {}

EditorNotify.ATTRS= {
};

EditorNotify.prototype = {

    /**
     * A single Y.Node for this editor. There is only ever one - it is replaced if a new message comes in.
     *
     * @property messageOverlay
     * @type {Node}
     */
    messageOverlay: null,

    /**
     * A single timer object that can be used to cancel the hiding behaviour.
     *
     * @property hideTimer
     * @type {timer}
     */
    hideTimer: null,

    /**
     * Initialize the notifications.
     *
     * @method setupNotifications
     * @chainable
     */
    setupNotifications: function() {
        var preload1 = new Image(),
            preload2 = new Image();

        preload1.src = M.util.image_url('i/warning', 'lion');
        preload2.src = M.util.image_url('i/info', 'lion');

        return this;
    },

    /**
     * Show a notification in a floaty overlay somewhere in the atto editor text area.
     *
     * @method showMessage
     * @param {String} message The translated message (use get_string)
     * @param {String} type Must be either "info" or "warning"
     * @param {Number} timeout Time in milliseconds to show this message for.
     * @chainable
     */
    showMessage: function(message, type, timeout) {
        var messageTypeIcon = '',
            intTimeout,
            bodyContent;

        if (this.messageOverlay === null) {
            this.messageOverlay = Y.Node.create('<div class="editor_atto_notification"></div>');

            this.messageOverlay.hide(true);
            this.textarea.get('parentNode').append(this.messageOverlay);

            this.messageOverlay.on('click', function() {
                this.messageOverlay.hide(true);
            }, this);
        }

        if (this.hideTimer !== null) {
            this.hideTimer.cancel();
        }

        if (type === NOTIFY_WARNING) {
            messageTypeIcon = '<img src="' +
                              M.util.image_url('i/warning', 'lion') +
                              '" alt="' + M.util.get_string('warning', 'lion') + '"/>';
        } else if (type === NOTIFY_INFO) {
            messageTypeIcon = '<img src="' +
                              M.util.image_url('i/info', 'lion') +
                              '" alt="' + M.util.get_string('info', 'lion') + '"/>';
        } else {
            Y.log('Invalid message type specified: ' + type + '. Must be either "info" or "warning".', 'debug', LOGNAME_NOTIFY);
        }

        // Parse the timeout value.
        intTimeout = parseInt(timeout, 10);
        if (intTimeout <= 0) {
            intTimeout = 60000;
        }

        // Convert class to atto_info (for example).
        type = 'atto_' + type;

        bodyContent = Y.Node.create('<div class="' + type + '" role="alert" aria-live="assertive">' +
                                        messageTypeIcon + ' ' +
                                        Y.Escape.html(message) +
                                        '</div>');
        this.messageOverlay.empty();
        this.messageOverlay.append(bodyContent);
        this.messageOverlay.show(true);

        this.hideTimer = Y.later(intTimeout, this, function() {
            Y.log('Hide Atto notification.', 'debug', LOGNAME_NOTIFY);
            this.hideTimer = null;
            this.messageOverlay.hide(true);
        });

        return this;
    }

};

Y.Base.mix(Y.M.editor_atto.Editor, [EditorNotify]);
