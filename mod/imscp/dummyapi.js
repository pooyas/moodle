
/**
 * IMS Content Package module including dummy SCORM API.
 *
 * @package    mod
 * @subpackage imscp
 * @copyright  2009 Petr Skoda  {@link http://skodak.org}
 * 
 */

/** Dummy SCORM API adapter */
var API = new function () {
    this.LMSCommit         = function (parameter) {return "true";};
    this.LMSFinish         = function (parameter) {return "true";};
    this.LMSGetDiagnostic  = function (errorCode) {return "n/a";};
    this.LMSGetErrorString = function (errorCode) {return "n/a";};
    this.LMSGetLastError   = function () {return "0";};
    this.LMSGetValue       = function (element) {return "";};
    this.LMSInitialize     = function (parameter) {return "true";};
    this.LMSSetValue       = function (element, value) {return "true";};
};