

/**
 * Provides an in browser PDF editor.
 *
 * @module lion-assignfeedback_editpdf-editor
 */

/**
 * Class representing a users quick comment.
 *
 * @namespace M.assignfeedback_editpdf
 * @class quickcomment
 */
var QUICKCOMMENT = function(id, rawtext, width, colour) {

    /**
     * Quick comment text.
     * @property rawtext
     * @type String
     * @public
     */
    this.rawtext = rawtext || '';

    /**
     * ID of the comment
     * @property id
     * @type Int
     * @public
     */
    this.id = id || 0;

    /**
     * Width of the comment
     * @property width
     * @type Int
     * @public
     */
    this.width = width || 100;

    /**
     * Colour of the comment.
     * @property colour
     * @type String
     * @public
     */
    this.colour = colour || "yellow";
};

M.assignfeedback_editpdf = M.assignfeedback_editpdf || {};
M.assignfeedback_editpdf.quickcomment = QUICKCOMMENT;
