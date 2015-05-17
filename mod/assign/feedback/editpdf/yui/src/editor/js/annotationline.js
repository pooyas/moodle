

/**
 * Provides an in browser PDF editor.
 *
 * @module lion-assignfeedback_editpdf-editor
 */

/**
 * Class representing a line.
 *
 * @namespace M.assignfeedback_editpdf
 * @class annotationline
 * @extends M.assignfeedback_editpdf.annotation
 */
var ANNOTATIONLINE = function(config) {
    ANNOTATIONLINE.superclass.constructor.apply(this, [config]);
};

ANNOTATIONLINE.NAME = "annotationline";
ANNOTATIONLINE.ATTRS = {};

Y.extend(ANNOTATIONLINE, M.assignfeedback_editpdf.annotation, {
    /**
     * Draw a line annotation
     * @protected
     * @method draw
     * @return M.assignfeedback_editpdf.drawable
     */
    draw : function() {
        var drawable,
            shape;

        drawable = new M.assignfeedback_editpdf.drawable(this.editor);

        shape = this.editor.graphic.addShape({
        type: Y.Path,
            fill: false,
            stroke: {
                weight: STROKEWEIGHT,
                color: ANNOTATIONCOLOUR[this.colour]
            }
        });

        shape.moveTo(this.x, this.y);
        shape.lineTo(this.endx, this.endy);
        shape.end();
        drawable.shapes.push(shape);
        this.drawable = drawable;

        return ANNOTATIONLINE.superclass.draw.apply(this);
    },

    /**
     * Draw the in progress edit.
     *
     * @public
     * @method draw_current_edit
     * @param M.assignfeedback_editpdf.edit edit
     */
    draw_current_edit : function(edit) {
        var drawable = new M.assignfeedback_editpdf.drawable(this.editor),
            shape;

        shape = this.editor.graphic.addShape({
           type: Y.Path,
            fill: false,
            stroke: {
                weight: STROKEWEIGHT,
                color: ANNOTATIONCOLOUR[edit.annotationcolour]
            }
        });

        shape.moveTo(edit.start.x, edit.start.y);
        shape.lineTo(edit.end.x, edit.end.y);
        shape.end();

        drawable.shapes.push(shape);

        return drawable;
    },

    /**
     * Promote the current edit to a real annotation.
     *
     * @public
     * @method init_from_edit
     * @param M.assignfeedback_editpdf.edit edit
     * @return bool true if line bound is more than min width/height, else false.
     */
    init_from_edit : function(edit) {
        this.gradeid = this.editor.get('gradeid');
        this.pageno = this.editor.currentpage;
        this.x = edit.start.x;
        this.y = edit.start.y;
        this.endx = edit.end.x;
        this.endy = edit.end.y;
        this.colour = edit.annotationcolour;
        this.path = '';

        return !(((this.endx - this.x) === 0) && ((this.endy - this.y) === 0));
    }

});

M.assignfeedback_editpdf = M.assignfeedback_editpdf || {};
M.assignfeedback_editpdf.annotationline = ANNOTATIONLINE;
