
/**
 * Wrapper for the YUI M.core.notification class. Allows us to
 * use the YUI version in AMD code until it is replaced.
 *
 * @module     core/notification
 * @class      notification
 * @package    core
 * @copyright  2015 Damyon Wiese <damyon@lion.com>
 * 
 * @since      2.9
 */
define(['core/yui'], function(Y) {

    // Private variables and functions.

    return /** @alias module:core/notification */ {
        // Public variables and functions.
        /**
         * Wrap M.core.alert.
         *
         * @method alert
         * @param {string} title
         * @param {string} message
         * @param {string} yesLabel
         */
        alert: function(title, message, yesLabel) {
            // Here we are wrapping YUI. This allows us to start transitioning, but
            // wait for a good alternative without having inconsistent dialogues.
            Y.use('lion-core-notification-alert', function () {
                var alert = new M.core.alert({
                    title : title,
                    message : message,
                    yesLabel: yesLabel
                });

                alert.show();
            });
        },

        /**
         * Wrap M.core.confirm.
         *
         * @method confirm
         * @param {string} title
         * @param {string} question
         * @param {string} yesLabel
         * @param {string} noLabel
         * @param {function} callback
         */
        confirm: function(title, question, yesLabel, noLabel, callback) {
            // Here we are wrapping YUI. This allows us to start transitioning, but
            // wait for a good alternative without having inconsistent dialogues.
            Y.use('lion-core-notification-confirm', function () {
                var modal = new M.core.confirm({
                    title : title,
                    question : question,
                    yesLabel: yesLabel,
                    noLabel: noLabel
                });

                modal.on('complete-yes', function() {
                    callback();
                });
                modal.show();
            });
        },

        /**
         * Wrap M.core.exception.
         *
         * @method exception
         * @param {Error} ex
         */
        exception: function(ex) {
            // Fudge some parameters.
            if (ex.backtrace) {
                ex.lineNumber = ex.backtrace[0].line;
                ex.fileName = ex.backtrace[0].file;
                ex.fileName = '...' + ex.fileName.substr(ex.fileName.length - 20);
                ex.stack = ex.debuginfo;
                ex.name = ex.errorcode;
            }
            Y.use('lion-core-notification-exception', function () {
                var modal = new M.core.exception(ex);

                modal.show();
            });
        }
    };
});
