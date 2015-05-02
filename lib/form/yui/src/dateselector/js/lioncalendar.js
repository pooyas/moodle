/**
 * Provides the Lion Calendar class.
 *
 * @module lion-form-dateselector
 */

/**
 * A class to overwrite the YUI3 Calendar in order to change the strings..
 *
 * @class M.form_lioncalendar
 * @constructor
 * @extends Calendar
 */
var LIONCALENDAR = function() {
    LIONCALENDAR.superclass.constructor.apply(this, arguments);
};

Y.extend(LIONCALENDAR, Y.Calendar, {
        initializer: function(cfg) {
            this.set("strings.very_short_weekdays", cfg.WEEKDAYS_MEDIUM);
            this.set("strings.first_weekday", cfg.firstdayofweek);
        }
    }, {
        NAME: 'Calendar',
        ATTRS: {}
    }
);

M.form_lioncalendar = M.form_lioncalendar || {};
M.form_lioncalendar.initializer = function(params) {
    return new LIONCALENDAR(params);
};
