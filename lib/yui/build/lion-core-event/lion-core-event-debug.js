YUI.add('lion-core-event', function (Y, NAME) {



/**
 * @module lion-core-event
 */

var LOGNAME = 'lion-core-event';

/**
 * List of published global JS events in Lion. This is a collection
 * of global events that can be subscribed to, or fired from any plugin.
 *
 * @namespace M.core
 * @class event
 */
M.core = M.core || {};

M.core.event = {
    /**
     * This event is triggered when a page has added dynamic nodes to a page
     * that should be processed by the filter system. An example is loading
     * user text that could have equations in it. MathJax can typeset the equations
     * but only if it is notified that there are new nodes in the page that need processing.
     * To trigger this event use M.core.Event.fire(M.core.Event.FILTER_CONTENT_UPDATED, {nodes: list});
     *
     * @event "filter-content-updated"
     * @param nodes {Y.NodeList} List of nodes added to the DOM.
     */
    FILTER_CONTENT_UPDATED: "filter-content-updated"
};


var eventDefaultConfig = {
    emitFacade: true,
    defaultFn: function(e) {
        Y.log('Event fired: ' + e.type, 'debug', LOGNAME);
    },
    preventedFn: function(e) {
        Y.log('Event prevented: ' + e.type, 'debug', LOGNAME);
    },
    stoppedFn: function(e) {
        Y.log('Event stopped: ' + e.type, 'debug', LOGNAME);
    }
};

// Publish all the events with a standard config.
var key;
for (key in M.core.event) {
    if (M.core.event.hasOwnProperty(key)) {
        Y.publish(M.core.event[key], eventDefaultConfig);
    }
}

// Publish events with a custom config here.


}, '@VERSION@', {"requires": ["event-custom"]});
