

/**
 * Provides an in browser PDF editor.
 *
 * @module lion-assignfeedback_editpdf-editor
 */

/**
 * Class representing a highlight.
 *
 * @namespace M.assignfeedback_editpdf
 * @class annotationhighlight
 * @extends M.assignfeedback_editpdf.annotation
 * @module lion-assignfeedback_editpdf-editor
 */
var ANNOTATIONHIGHLIGHT = function(config) {
    ANNOTATIONHIGHLIGHT.superclass.constructor.apply(this, [config]);
};

ANNOTATIONHIGHLIGHT.NAME = "annotationhighlight";
ANNOTATIONHIGHLIGHT.ATTRS = {};

Y.extend(ANNOTATIONHIGHLIGHT, M.assignfeedback_editpdf.annotation, {
    /**
     * Draw a highlight annotation
     * @protected
     * @method draw
     * @return M.assignfeedback_editpdf.drawable
     */
    draw : function() {
        var drawable,
            shape,
            bounds,
            highlightcolour;

        drawable = new M.assignfeedback_editpdf.drawable(this.editor);
        bounds = new M.assignfeedback_editpdf.rect();
        bounds.bound([new M.assignfeedback_editpdf.point(this.x, this.y),
                      new M.assignfeedback_editpdf.point(this.endx, this.endy)]);

        highlightcolour = ANNOTATIONCOLOUR[this.colour];

        // Add an alpha channel to the rgb colour.

        highlightcolour = highlightcolour.replace('rgb', 'rgba');
        highlightcolour = highlightcolour.replace(')', ',0.5)');

        shape = this.editor.graphic.addShape({
            type: Y.Rect,
            width: bounds.width,
            height: bounds.height,
            stroke: false,
            fill: {
                color: highlightcolour
            },
            x: bounds.x,
            y: bounds.y
        });

        drawable.shapes.push(shape);
        this.drawable = drawable;

        return ANNOTATIONHIGHLIGHT.superclass.draw.apply(this);
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
            shape,
            bounds,
            highlightcolour;

        bounds = new M.assignfeedback_editpdf.rect();
        bounds.bound([new M.assignfeedback_editpdf.point(edit.start.x, edit.start.y),
                      new M.assignfeedback_editpdf.point(edit.end.x, edit.end.y)]);

        // Set min. width of highlight.
        if (!bounds.has_min_width()) {
            bounds.set_min_width();
        }

        highlightcolour = ANNOTATIONCOLOUR[edit.annotationcolour];
        // Add an alpha channel to the rgb colour.

        highlightcolour = highlightcolour.replace('rgb', 'rgba');
        highlightcolour = highlightcolour.replace(')', ',0.5)');

        // We will draw a box with the current background colour.
        shape = this.editor.graphic.addShape({
            type: Y.Rect,
            width: bounds.width,
            height: 16,
            stroke: false,
            fill: {
               color: highlightcolour
            },
            x: bounds.x,
            y: edit.start.y
        });

        drawable.shapes.push(shape);

        return drawable;
    },

    /**
     * Promote the current edit to a real annotation.
     *
     * @public
     * @method init_from_edit
     * @param M.assignfeedback_editpdf.edit edit
     * @return bool true if highlight bound is more than min width/height, else false.
     */
    init_from_edit : function(edit) {
        var bounds = new M.assignfeedback_editpdf.rect();
        bounds.bound([edit.start, edit.end]);

        this.gradeid = this.editor.get('gradeid');
        this.pageno = this.editor.currentpage;
        this.x = bounds.x;
        this.y = edit.start.y;
        this.endx = bounds.x + bounds.width;
        this.endy = edit.start.y + 16;
        this.colour = edit.annotationcolour;
        this.page = '';

        return (bounds.has_min_width());
    }

});

M.assignfeedback_editpdf = M.assignfeedback_editpdf || {};
M.assignfeedback_editpdf.annotationhighlight = ANNOTATIONHIGHLIGHT;
