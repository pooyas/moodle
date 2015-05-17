

/*
 * Question Bank Management.
 *
 */

/**
 * Questionbank Management.
 *
 * @module lion-question-qbankmanager
 */

/**
 * Question Bank Management.
 *
 * @class M.question.qbankmanager
 */

var manager = {
    /**
     * A reference to the header checkbox.
     *
     * @property _header
     * @type Node
     * @private
     */
    _header: null,

    /**
     * The ID of the first checkbox on the page.
     *
     * @property _firstCheckbox
     * @type Node
     * @private
     */
    _firstCheckbox: null,

    /**
     * Set up the Question Bank Manager.
     *
     * @method init
     */
    init: function() {
        // Find the header checkbox, and set the initial values.
        this._header = Y.one('#qbheadercheckbox');
        if (!this._header) {
            return;
        }
        this._header.setAttrs({
            disabled: false,
            title: M.util.get_string('selectall', 'lion')
        });

        this._header.on('click', this._headerClick, this);

        // Store the first checkbox details.
        var table = this._header.ancestor('table');
        this._firstCheckbox = table.one('tbody tr td.checkbox input');
    },

    /**
     * Handle toggling of the header checkbox.
     *
     * @method _headerClick
     * @private
     */
    _headerClick: function() {
        // Get the list of questions we affect.
        var categoryQuestions = Y.one('#categoryquestions')
                .all('[type=checkbox],[type=radio]');

        // We base the state of all of the questions on the state of the first.
        if (this._firstCheckbox.get('checked')) {
            categoryQuestions.set('checked', false);
            this._header.setAttribute('title', M.util.get_string('selectall', 'lion'));
        } else {
            categoryQuestions.set('checked', true);
            this._header.setAttribute('title', M.util.get_string('deselectall', 'lion'));
        }

        this._header.set('checked', false);
    }
};

M.question = M.question || {};
M.question.qbankmanager = M.question.qbankmanager || manager;
