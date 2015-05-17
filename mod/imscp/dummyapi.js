

/**
 * IMS Content Package module including dummy SCORM API.
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