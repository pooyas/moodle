
/**
 * URL utility functions.
 *
 * @module     core/url
 * @package    core
 * @class      url
 * @copyright  2015 Pooya Saeedi 
 * 
 * @since      2.9
 */
define(['core/config'], function(config) {


    return /** @alias module:core/url */ {
        // Public variables and functions.
        /**
         * Generate a style tag referencing this sheet and add it to the head of the page.
         *
         * @method fileUrl
         * @param {string} sheet The style sheet name. Must exist in the theme, or one of it's parents.
         * @return {string}
         */
        fileUrl: function(relativeScript, slashArg) {

            var url = config.wwwroot + relativeScript;

            // Force a /
            if (slashArg.charAt(0) != '/') {
                slashArg = '/' + slashArg;
            }
            if (config.slasharguments) {
                url += slashArg;
            } else {
                url += '?file=' + encodeURIComponent(slashArg);
            }
            return url;
        },

        /**
         * Take a path relative to the lion basedir and do some fixing (see class lion_url in php).
         *
         * @method relativeUrl
         * @param {string} relativePath The path relative to the lion basedir.
         * @return {string}
         */
        relativeUrl: function(relativePath) {

            if (relativePath.indexOf('http:') === 0 || relativePath.indexOf('https:') === 0 || relativePath.indexOf('://')) {
                throw new Error('relativeUrl function does not accept absolute urls');
            }

            // Fix non-relative paths;
            if (relativePath.charAt(0) != '/') {
                relativePath = '/' + relativePath;
            }

            // Fix admin urls.
            if (config.admin !== 'admin') {
                relativePath = relativePath.replace(/^\/admin\//, '/' + config.admin + '/');
            }
            return config.wwwroot + relativePath;
        },

        /**
         * Wrapper for image_url function.
         *
         * @method imageUrl
         * @param {string} imagename The image name (e.g. t/edit).
         * @param {string} component The component (e.g. mod_feedback).
         * @return {string}
         */
        imageUrl: function(imagename, component) {
            return M.util.image_url(imagename, component);
        }
    };
});
