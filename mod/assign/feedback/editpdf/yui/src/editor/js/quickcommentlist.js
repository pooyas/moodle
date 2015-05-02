
/**
 * Provides an in browser PDF editor.
 *
 * @module lion-assignfeedback_editpdf-editor
 */

/**
 * Class representing a users list of quick comments.
 *
 * @namespace M.assignfeedback_editpdf
 * @class quickcommentlist
 */
var QUICKCOMMENTLIST = function(editor) {

    /**
     * Reference to M.assignfeedback_editpdf.editor.
     * @property editor
     * @type M.assignfeedback_editpdf.editor
     * @public
     */
    this.editor = editor;

    /**
     * Array of Comments
     * @property shapes
     * @type M.assignfeedback_editpdf.quickcomment[]
     * @public
     */
    this.comments = [];

    /**
     * Add a comment to the users quicklist.
     *
     * @protected
     * @method add
     */
    this.add = function(comment) {
        var ajaxurl = AJAXBASE,
            config;

        // Do not save empty comments.
        if (comment.rawtext === '') {
            return;
        }

        config = {
            method: 'post',
            context: this,
            sync: false,
            data : {
                'sesskey' : M.cfg.sesskey,
                'action' : 'addtoquicklist',
                'userid' : this.editor.get('userid'),
                'commenttext' : comment.rawtext,
                'width' : comment.width,
                'colour' : comment.colour,
                'attemptnumber' : this.editor.get('attemptnumber'),
                'assignmentid' : this.editor.get('assignmentid')
            },
            on: {
                success: function(tid, response) {
                    var jsondata, quickcomment;
                    try {
                        jsondata = Y.JSON.parse(response.responseText);
                        if (jsondata.error) {
                            return new M.core.ajaxException(jsondata);
                        } else {
                            quickcomment = new M.assignfeedback_editpdf.quickcomment(jsondata.id,
                                                                                     jsondata.rawtext,
                                                                                     jsondata.width,
                                                                                     jsondata.colour);
                            this.comments.push(quickcomment);
                        }
                    } catch (e) {
                        return new M.core.exception(e);
                    }
                },
                failure: function(tid, response) {
                    return M.core.exception(response.responseText);
                }
            }
        };

        Y.io(ajaxurl, config);
    };

    /**
     * Remove a comment from the users quicklist.
     *
     * @public
     * @method remove
     */
    this.remove = function(comment) {
        var ajaxurl = AJAXBASE,
            config;

        // Should not happen.
        if (!comment) {
            return;
        }

        config = {
            method: 'post',
            context: this,
            sync: false,
            data : {
                'sesskey' : M.cfg.sesskey,
                'action' : 'removefromquicklist',
                'userid' : this.editor.get('userid'),
                'commentid' : comment.id,
                'attemptnumber' : this.editor.get('attemptnumber'),
                'assignmentid' : this.editor.get('assignmentid')
            },
            on: {
                success: function() {
                    var i;

                    // Find and remove the comment from the quicklist.
                    i = this.comments.indexOf(comment);
                    if (i >= 0) {
                        this.comments.splice(i, 1);
                    }
                },
                failure: function(tid, response) {
                    return M.core.exception(response.responseText);
                }
            }
        };

        Y.io(ajaxurl, config);
    };

    /**
     * Load the users quick comments list.
     *
     * @protected
     * @method load_quicklist
     */
    this.load = function() {
        var ajaxurl = AJAXBASE,
            config;

        config = {
            method: 'get',
            context: this,
            sync: false,
            data : {
                'sesskey' : M.cfg.sesskey,
                'action' : 'loadquicklist',
                'userid' : this.editor.get('userid'),
                'attemptnumber' : this.editor.get('attemptnumber'),
                'assignmentid' : this.editor.get('assignmentid')
            },
            on: {
                success: function(tid, response) {
                    var jsondata;
                    try {
                        jsondata = Y.JSON.parse(response.responseText);
                        if (jsondata.error) {
                            return new M.core.ajaxException(jsondata);
                        } else {
                            Y.each(jsondata, function(comment) {
                                var quickcomment = new M.assignfeedback_editpdf.quickcomment(comment.id,
                                                                                             comment.rawtext,
                                                                                             comment.width,
                                                                                             comment.colour);
                                this.comments.push(quickcomment);
                            }, this);
                        }
                    } catch (e) {
                        return new M.core.exception(e);
                    }
                },
                failure: function(tid, response) {
                    return M.core.exception(response.responseText);
                }
            }
        };

        Y.io(ajaxurl, config);
    };
};

M.assignfeedback_editpdf = M.assignfeedback_editpdf || {};
M.assignfeedback_editpdf.quickcommentlist = QUICKCOMMENTLIST;
