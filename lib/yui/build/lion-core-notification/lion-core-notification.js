YUI.add('lion-core-notification', function (Y, NAME) {

/**
 * The notification module provides a standard set of dialogues for use
 * within Lion.
 *
 * @module lion-core-notification
 * @main
 */

/**
 * To avoid bringing lion-core-notification into modules in it's
 * entirety, we now recommend using on of the subclasses of
 * lion-core-notification. These include:
 * <dl>
 *  <dt> lion-core-notification-dialogue</dt>
 *  <dt> lion-core-notification-alert</dt>
 *  <dt> lion-core-notification-confirm</dt>
 *  <dt> lion-core-notification-exception</dt>
 *  <dt> lion-core-notification-ajaxexception</dt>
 * </dl>
 *
 * @class M.core.notification
 * @deprecated
 */


}, '@VERSION@', {
    "requires": [
        "lion-core-notification-dialogue",
        "lion-core-notification-alert",
        "lion-core-notification-confirm",
        "lion-core-notification-exception",
        "lion-core-notification-ajaxexception"
    ]
});
