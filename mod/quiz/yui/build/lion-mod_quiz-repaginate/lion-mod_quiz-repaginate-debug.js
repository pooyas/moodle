YUI.add('lion-mod_quiz-repaginate', function (Y, NAME) {



/**
 * Repaginate functionality for a popup in quiz editing page.
 *
 * @package   mod
 * @subpackage quiz
 * @copyright 2015 Pooya Saeedi
 * 
 */

var CSS = {
    REPAGINATECONTAINERCLASS: '.rpcontainerclass',
    REPAGINATECOMMAND: '#repaginatecommand'
};

var PARAMS = {
    CMID: 'cmid',
    HEADER: 'header',
    FORM: 'form'
};

var POPUP = function() {
    POPUP.superclass.constructor.apply(this, arguments);
};

Y.extend(POPUP, Y.Base, {
    header: null,
    body: null,

    initializer : function() {
        var rpcontainerclass = Y.one(CSS.REPAGINATECONTAINERCLASS);

        // Set popup header and body.
        this.header = rpcontainerclass.getAttribute(PARAMS.HEADER);
        this.body = rpcontainerclass.getAttribute(PARAMS.FORM);
        Y.one(CSS.REPAGINATECOMMAND).on('click', this.display_dialog, this);
    },

    display_dialog : function (e) {
        e.preventDefault();

        // Configure the popup.
        var config = {
            headerContent : this.header,
            bodyContent : this.body,
            draggable : true,
            modal : true,
            zIndex : 1000,
            context: [CSS.REPAGINATECOMMAND, 'tr', 'br', ['beforeShow']],
            centered: false,
            width: '30em',
            visible: false,
            postmethod: 'form',
            footerContent: null
        };

        var popup = { dialog: null };
        popup.dialog = new M.core.dialogue(config);
        popup.dialog.show();
    }
});

M.mod_quiz = M.mod_quiz || {};
M.mod_quiz.repaginate = M.mod_quiz.repaginate || {};
M.mod_quiz.repaginate.init = function() {
    return new POPUP();
};


}, '@VERSION@', {"requires": ["base", "event", "node", "io", "lion-core-notification-dialogue"]});
