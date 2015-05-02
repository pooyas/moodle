
/**
 * Provides an in browser PDF editor.
 *
 * @module lion-assignfeedback_editpdf-editor
 */

/**
 * EDIT
 *
 * @namespace M.assignfeedback_editpdf
 * @class edit
 */
var EDIT = function() {

    /**
     * Starting point for the edit.
     * @property start
     * @type M.assignfeedback_editpdf.point|false
     * @public
     */
    this.start = false;

    /**
     * Finishing point for the edit.
     * @property end
     * @type M.assignfeedback_editpdf.point|false
     * @public
     */
    this.end = false;

    /**
     * Starting time for the edit.
     * @property starttime
     * @type int
     * @public
     */
    this.starttime = 0;

    /**
     * Starting point for the currently selected annotation.
     * @property annotationstart
     * @type M.assignfeedback_editpdf.point|false
     * @public
     */
    this.annotationstart = false;

    /**
     * The currently selected tool
     * @property tool
     * @type String
     * @public
     */
    this.tool = "comment";

    /**
     * The currently comment colour
     * @property commentcolour
     * @type String
     * @public
     */
    this.commentcolour = 'yellow';

    /**
     * The currently annotation colour
     * @property annotationcolour
     * @type String
     * @public
     */
    this.annotationcolour = 'red';

    /**
     * The current stamp image.
     * @property stamp
     * @type String
     * @public
     */
    this.stamp = '';

    /**
     * List of points the the current drawing path.
     * @property path
     * @type M.assignfeedback_editpdf.point[]
     * @public
     */
    this.path = [];
};

M.assignfeedback_editpdf = M.assignfeedback_editpdf || {};
M.assignfeedback_editpdf.edit = EDIT;
