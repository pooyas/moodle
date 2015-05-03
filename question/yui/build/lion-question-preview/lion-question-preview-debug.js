YUI.add('lion-question-preview', function (Y, NAME) {


/*
 * @copyright 2015 Pooya Saeedi
 * 
 */

/**
 * JavaScript required by the question preview pop-up.
 *
 * @module lion-question-preview
 */

M.question = M.question || {};
M.question.preview = M.question.preview || {};

/*
 * Initialise JavaScript-specific parts of the question preview popup.
 */
M.question.preview.init = function() {
    M.core_question_engine.init_form(Y, '#responseform');

    // Add a close button to the window.
    var closebutton = Y.Node.create('<input type="button" />')
            .set('value', M.util.get_string('closepreview', 'question'));

    closebutton.on('click', function() {
        window.close();
    });
    Y.one('#previewcontrols').append(closebutton);

    // Stop a question form being submitted more than once.
    Y.on('submit', M.core_question_engine.prevent_repeat_submission, '#mform1', null, Y);
};


}, '@VERSION@', {"requires": ["base", "dom", "event-delegate", "event-key", "core_question_engine"]});
