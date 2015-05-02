
/**
 * A list of globals used by this module.
 *
 * @module lion-assignfeedback_editpdf-editor
 */
var AJAXBASE = M.cfg.wwwroot + '/mod/assign/feedback/editpdf/ajax.php',
    AJAXBASEPROGRESS = M.cfg.wwwroot + '/mod/assign/feedback/editpdf/ajax_progress.php',
    CSS = {
        DIALOGUE : 'assignfeedback_editpdf_widget'
    },
    SELECTOR = {
        PREVIOUSBUTTON : '.' + CSS.DIALOGUE + ' .navigate-previous-button',
        NEXTBUTTON : '.' + CSS.DIALOGUE + ' .navigate-next-button',
        SEARCHCOMMENTSBUTTON : '.' + CSS.DIALOGUE + ' .searchcommentsbutton',
        SEARCHFILTER : '.assignfeedback_editpdf_commentsearch input',
        SEARCHCOMMENTSLIST : '.assignfeedback_editpdf_commentsearch ul',
        PAGESELECT : '.' + CSS.DIALOGUE + ' .navigate-page-select',
        LOADINGICON : '.' + CSS.DIALOGUE + ' .loading',
        PROGRESSBARCONTAINER : '.' + CSS.DIALOGUE + ' .progress-info.progress-striped',
        DRAWINGREGION : '.' + CSS.DIALOGUE + ' .drawingregion',
        DRAWINGCANVAS : '.' + CSS.DIALOGUE + ' .drawingcanvas',
        SAVE : '.' + CSS.DIALOGUE + ' .savebutton',
        COMMENTCOLOURBUTTON : '.' + CSS.DIALOGUE + ' .commentcolourbutton',
        COMMENTMENU : ' .commentdrawable a',
        ANNOTATIONCOLOURBUTTON : '.' + CSS.DIALOGUE + ' .annotationcolourbutton',
        DELETEANNOTATIONBUTTON : '.' + CSS.DIALOGUE + ' .deleteannotationbutton',
        UNSAVEDCHANGESDIV : '.assignfeedback_editpdf_unsavedchanges',
        STAMPSBUTTON : '.' + CSS.DIALOGUE + ' .currentstampbutton',
        DIALOGUE : '.' + CSS.DIALOGUE
    },
    SELECTEDBORDERCOLOUR = 'rgba(200, 200, 255, 0.9)',
    SELECTEDFILLCOLOUR = 'rgba(200, 200, 255, 0.5)',
    COMMENTTEXTCOLOUR = 'rgb(51, 51, 51)',
    COMMENTCOLOUR = {
        'white' : 'rgb(255,255,255)',
        'yellow' : 'rgb(255,236,174)',
        'red' : 'rgb(249,181,179)',
        'green' : 'rgb(214,234,178)',
        'blue' : 'rgb(203,217,237)',
        'clear' : 'rgba(255,255,255, 0)'
    },
    ANNOTATIONCOLOUR = {
        'white' : 'rgb(255,255,255)',
        'yellow' : 'rgb(255,207,53)',
        'red' : 'rgb(239,69,64)',
        'green' : 'rgb(152,202,62)',
        'blue' : 'rgb(125,159,211)',
        'black' : 'rgb(51,51,51)'
    },
    CLICKTIMEOUT = 300,
    TOOLSELECTOR = {
        'comment': '.' + CSS.DIALOGUE + ' .commentbutton',
        'pen': '.' + CSS.DIALOGUE + ' .penbutton',
        'line': '.' + CSS.DIALOGUE + ' .linebutton',
        'rectangle': '.' + CSS.DIALOGUE + ' .rectanglebutton',
        'oval': '.' + CSS.DIALOGUE + ' .ovalbutton',
        'stamp': '.' + CSS.DIALOGUE + ' .stampbutton',
        'select': '.' + CSS.DIALOGUE + ' .selectbutton',
        'highlight': '.' + CSS.DIALOGUE + ' .highlightbutton'
    },
    STROKEWEIGHT = 4;
