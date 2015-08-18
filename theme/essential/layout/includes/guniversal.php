<?php


/**
 * Analytics
 *
 * This module provides extensive analytics on a platform of choice
 * Currently support Google Analytics and Piwik
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

function analytics_trackurl() {
    global $DB, $PAGE;
    $pageinfo = get_context_info_array($PAGE->context->id);
    $trackurl = "'/";

    // Adds course category name.
    if (isset($pageinfo[1]->category)) {
        if ($category = $DB->get_record('course_categories', array('id' => $pageinfo[1]->category))) {
            $cats = explode("/", $category->path);
            foreach (array_filter($cats) as $cat) {
                if ($categorydepth = $DB->get_record("course_categories", array("id" => $cat))) {
                    ;
                    $trackurl .= urlencode($categorydepth->name) . '/';
                }
            }
        }
    }

    // Adds course full name.
    if (isset($pageinfo[1]->fullname)) {
        if (isset($pageinfo[2]->name)) {
            $trackurl .= urlencode($pageinfo[1]->fullname) . '/';
        } else if ($PAGE->user_is_editing()) {
            $trackurl .= urlencode($pageinfo[1]->fullname) . '/' . get_string('edit');
        } else {
            $trackurl .= urlencode($pageinfo[1]->fullname) . '/' . get_string('view');
        }
    }

    // Adds activity name.
    if (isset($pageinfo[2]->name)) {
        $trackurl .= urlencode($pageinfo[2]->modname) . '/' . urlencode($pageinfo[2]->name);
    }

    $trackurl .= "'";
    return $trackurl;
}

function insert_analytics_tracking() {
    global $PAGE, $OUTPUT;
    $trackingid = $OUTPUT->get_setting('analyticstrackingid');
    $trackadmin = $OUTPUT->get_setting('analyticstrackadmin');
    $cleanurl = $OUTPUT->get_setting('analyticscleanurl');
    $tracking = '';

    if ($cleanurl) {
        $addition =
            "{'hitType' : 'pageview',
            'page' : " . analytics_trackurl() . ",
            'title' : '" . addslashes($PAGE->heading) . "'
            }";
    } else {
        $addition = "'pageview'";
    }


    if (!is_siteadmin() || $trackadmin) {
        $tracking = "
            <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', '" . $trackingid . "', {'siteSpeedSampleRate': 50});
            ga('send', " . $addition . ");

            </script>";
    }
    return $tracking;
}

echo insert_analytics_tracking();