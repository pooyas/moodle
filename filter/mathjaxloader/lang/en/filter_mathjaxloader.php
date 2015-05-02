<?php

/**
 * Strings for component 'filter_mathjaxloader', language 'en'.
 *
 * @package    filter_mathjaxloader
 * @copyright  1999 onwards Martin Dougiamas  {@link http://lion.com}
 * 
 */

$string['filtername'] = 'MathJax';
$string['additionaldelimiters'] = 'Additional equation delimiters';
$string['additionaldelimiters_help'] = 'MathJax filter parses text for equations contained within delimiter characters.

The list of recognised delimiter characters can be added to here (e.g. AsciiMath uses `). Delimiters can contain multiple characters and multiple delimiters can be separated with commas.';
$string['httpurl'] = 'HTTP MathJax URL';
$string['httpurl_help'] = 'Full URL to MathJax library. Used when the page is loaded via http.';
$string['httpsurl'] = 'HTTPS MathJax URL';
$string['httpsurl_help'] = 'Full URL to MathJax library. Used when the page is loaded via https (secure). ';
$string['texfiltercompatibility'] = 'TeX filter compatibility';
$string['texfiltercompatibility_help'] = 'The MathJax filter can be used as a replacement for the TeX notation filter.

To support all the delimiters supported by the TeX notation filter, MathJax will be configured to display all equations "inline" with the text.';
$string['localinstall'] = 'Local MathJax installation';
$string['localinstall_help'] = 'The default MathJax configuration uses the CDN version of MathJax, but MathJax can be installed locally if required.

This can be useful to save on bandwidth or because of local proxy restrictions.

To use a local installation of MathJax, first download the full MathJax library from http://www.mathjax.org/. Then install it on a web server. Finally update the MathJax filter settings httpurl and/or httpsurl to point to the local MathJax.js URL.';
$string['mathjaxsettings'] = 'MathJax configuration';
$string['mathjaxsettings_desc'] = 'The default MathJax configuration should be appropriate for most users, but MathJax is highly configurable and any of the standard MathJax configuration options can be added here.';
