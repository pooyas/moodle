YUI.add('lion-mod_forum-subscriptiontoggle', function (Y, NAME) {


/**
 * A utility to check whether the connection to the Lion server is still
 * active.
 *
 * @module     lion-core-subscriptiontoggle
 * @package    mod_forum
 * @copyright  2015 Pooya Saeedi <andrew@nicols.co.uk>
 * 
 * @main       lion-mod_forum-subscriptiontoggle
 */

/**
 * @namespace M.mod_forum
 * @class subscriptiontoggle
 */

function SubscriptionToggle() {
    SubscriptionToggle.superclass.constructor.apply(this, arguments);
}

var LOGNAME = 'lion-mod_forum-subscriptiontoggle';

Y.extend(SubscriptionToggle, Y.Base, {
    initializer: function() {
        Y.delegate('click', this._toggleSubscription, Y.config.doc.body, '.discussionsubscription .discussiontoggle', this);
    },
    _toggleSubscription: function(e) {
        var clickedLink = e.currentTarget;

        Y.io(this.get('uri'), {
            data: {
                sesskey: M.cfg.sesskey,
                forumid: clickedLink.getData('forumid'),
                discussionid: clickedLink.getData('discussionid'),
                includetext: clickedLink.getData('includetext')
            },
            context: this,
            'arguments': {
                clickedLink: clickedLink
            },
            on: {
                complete: this._handleCompletion
            }
        });

        // Prevent the standard browser behaviour now.
        e.preventDefault();
    },

    _handleCompletion: function(tid, response, args) {
        var responseObject;
        // Attempt to parse the response into an object.
        try {
            responseObject = Y.JSON.parse(response.response);
            if (responseObject.error) {
                Y.use('lion-core-notification-ajaxexception', function() {
                    return new M.core.ajaxException(responseObject);
                });
                return this;
            }
        } catch (error) {
            Y.use('lion-core-notification-exception', function() {
                return new M.core.exception(error);
            });
            return this;
        }

        if (!responseObject.icon) {
            Y.log('No icon received. Skipping the current value replacement', 'warn', LOGNAME);
            return;
        }

        var container = args.clickedLink.ancestor('.discussionsubscription');
        if (container) {
            // We should just receive the new value for the table.
            // Note: We do not need to escape the HTML here as it should be provided sanitised from the JS response already.
            container.set('innerHTML', responseObject.icon);
        }
    }
}, {
    NAME: 'subscriptionToggle',
    ATTRS: {
        /**
         * The AJAX endpoint which controls the subscription toggle.
         *
         * @attribute uri
         * @type String
         * @default M.cfg.wwwroot + '/mod/forum/subscribe_ajax.php'
         */
        uri: {
            value: M.cfg.wwwroot + '/mod/forum/subscribe_ajax.php'
        }
    }
});

var NS = Y.namespace('M.mod_forum.subscriptiontoggle');
NS.init = function(config) {
    return new SubscriptionToggle(config);
};


}, '@VERSION@', {"requires": ["base-base", "io-base"]});
