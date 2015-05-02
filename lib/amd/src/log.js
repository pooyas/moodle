
/**
 * This is an empty module, that is required before all other modules.
 * Because every module is returned from a request for any other module, this
 * forces the loading of all modules with a single request.
 *
 * @module     core/log
 * @package    core
 * @copyright  2015 Andrew Nicols <andrew@nicols.co.uk>
 * 
 */
define(['core/loglevel'], function(log) {
    var originalFactory = log.methodFactory;
    log.methodFactory = function (methodName, logLevel) {
        var rawMethod = originalFactory(methodName, logLevel);

        return function (message, source) {
            if (source) {
                rawMethod(source + ": " + message);
            } else {
                rawMethod(message);
            }
        };
    };

    /**
     * Set default config settings.
     *
     * @param {String} level The level to use.
     * @method setConfig
     */
    log.setConfig = function(config) {
        if (typeof config.level !== "undefined") {
            log.setLevel(config.level);
        }
    };

    return log;
});
