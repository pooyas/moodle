
/**
 * Expose the global YUI variable. Note: This is only for scripts that are writing AMD
 * wrappers for YUI functionality. This is not for plugins.
 *
 * @module     core/yui
 * @package    core
 * @copyright  2015 Damyon Wiese <damyon@lion.com>
 * 
 * @since      2.9
 */
define(function() {

    // This module exposes only the global yui instance.
    return /** @alias module:core/yui */ Y;
});
