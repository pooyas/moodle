var DIALOGUE_PREFIX,
    BASE,
    CONFIRMYES,
    CONFIRMNO,
    TITLE,
    QUESTION,
    CSS;

DIALOGUE_PREFIX = 'lion-dialogue',
BASE = 'notificationBase',
CONFIRMYES = 'yesLabel',
CONFIRMNO = 'noLabel',
TITLE = 'title',
QUESTION = 'question',
CSS = {
    BASE : 'lion-dialogue-base',
    WRAP : 'lion-dialogue-wrap',
    HEADER : 'lion-dialogue-hd',
    BODY : 'lion-dialogue-bd',
    CONTENT : 'lion-dialogue-content',
    FOOTER : 'lion-dialogue-ft',
    HIDDEN : 'hidden',
    LIGHTBOX : 'lion-dialogue-lightbox'
};

// Set up the namespace once.
M.core = M.core || {};
