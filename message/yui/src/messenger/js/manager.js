
/**
 * Messenger manager.
 *
 * @module     lion-core_message-messenger
 * @package    core_message
 * @copyright  2015 Frédéric Massart - FMCorz.net
 * 
 */

SELECTORS.MANAGER = {
    SENDMESSAGE: '[data-trigger="core_message-messenger::sendmessage"]'
};

/**
 * Messenger manager.
 *
 * @namespace M.core_message.messenger
 * @class MANAGER
 * @constructor
 */
var MANAGER = function() {
    MANAGER.superclass.constructor.apply(this, arguments);
};
Y.namespace('M.core_message.messenger').Manager = Y.extend(MANAGER, Y.Base, {

    _sendMessageDialog: null,
    _events: [],

    /**
     * Initializer.
     *
     * @method initializer
     */
    initializer: function() {
        this._setEvents();
    },

    /**
     * Sending a message.
     *
     * @method sendMessage
     * @param  {Number} userid   The user ID to send a message to.
     * @param  {String} fullname The fullname of the user.
     * @param  {EventFacade} e   The event triggered, when any it should be passed to the dialog.
     */
    sendMessage: function(userid, fullname, e) {
        var Klass;
        if (!this._sendMessageDialog) {
            Klass = Y.namespace('M.core_message.messenger.sendMessage');
            this._sendMessageDialog = new Klass({
                url: this.get('url')
            });
        }

        this._sendMessageDialog.prepareForUser(userid, fullname);
        this._sendMessageDialog.show(e);
    },

    /**
     * Register the events.
     *
     * @method _setEvents.
     */
    _setEvents: function() {
        var captureEvent = function(e) {
            var target = e.currentTarget,
                userid = parseInt(target.getData('userid'), 10),
                fullname = target.getData('fullname');

            if (!userid || !fullname) {
                return;
            }

            // Pass the validation before preventing defaults.
            e.preventDefault();
            this.sendMessage(userid, fullname, e);
        };

        this._events.push(Y.delegate('click', captureEvent, 'body', SELECTORS.MANAGER.SENDMESSAGE, this));
        this._events.push(Y.one(Y.config.doc).delegate('key', captureEvent, 'space', SELECTORS.MANAGER.SENDMESSAGE, this));
    }

}, {
    NAME: 'core_message-messenger-manager',
    ATTRS: {

        /**
         * URL to the message Ajax actions.
         *
         * @attribute url
         * @default M.cfg.wwwroot + '/message/ajax.php'
         * @type String
         */
        url: {
            readonly: true,
            value: M.cfg.wwwroot + '/message/ajax.php'
        }
    }
});

var MANAGERINST;
Y.namespace('M.core_message.messenger').init = function(config) {
    if (!MANAGERINST) {
        // Prevent duplicates of the manager if this function is called more than once.
        MANAGERINST = new MANAGER(config);
    }
    return MANAGERINST;
};
