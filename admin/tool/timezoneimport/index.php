<?php

/**
 * Automatic update of Timezones from a new source
 *
 * @package    tool
 * @subpackage timezoneimport
 * @copyright  1999 onwards Martin Dougiamas  {@link http://lion.com}
 * 
 */

    require_once('../../../config.php');
    require_once($CFG->libdir.'/adminlib.php');
    require_once($CFG->libdir.'/filelib.php');
    require_once($CFG->libdir.'/olson.php');

    admin_externalpage_setup('tooltimezoneimport');

    $ok = optional_param('ok', 0, PARAM_BOOL);


/// Print headings

    $strimporttimezones = get_string('importtimezones', 'tool_timezoneimport');

    echo $OUTPUT->header();

    echo $OUTPUT->heading($strimporttimezones);

    if (!$ok or !confirm_sesskey()) {
        $message = '<br /><br />';
        $message .= $CFG->tempdir.'/olson.txt<br />';
        $message .= $CFG->tempdir.'/timezone.txt<br />';
        $message .= '<a href="https://download.lion.org/timezone/">https://download.lion.org/timezone/</a><br />';
        $message .= '<a href="'.$CFG->wwwroot.'/lib/timezone.txt">'.$CFG->dirroot.'/lib/timezone.txt</a><br />';
        $message .= '<br />';

        $message = get_string("configintrotimezones", 'tool_timezoneimport', $message);

        echo $OUTPUT->confirm($message, 'index.php?ok=1', new lion_url('/admin/index.php'));

        echo $OUTPUT->footer();
        exit;
    }


/// Try to find a source of timezones to import from

    $importdone = false;

/// First, look for an Olson file locally

    $source = $CFG->tempdir.'/olson.txt';
    if (!$importdone and is_readable($source)) {
        if ($timezones = olson_to_timezones($source)) {
            update_timezone_records($timezones);
            $importdone = $source;
        }
    }

/// Next, look for a CSV file locally

    $source = $CFG->tempdir.'/timezone.txt';
    if (!$importdone and is_readable($source)) {
        if ($timezones = get_records_csv($source, 'timezone')) {
            update_timezone_records($timezones);
            $importdone = $source;
        }
    }

/// Otherwise, let's try lion.org's copy
    $source = 'https://download.lion.org/timezone/';
    if (!$importdone && ($content=download_file_content($source))) {
        if ($file = fopen($CFG->tempdir.'/timezone.txt', 'w')) {            // Make local copy
            fwrite($file, $content);
            fclose($file);
            if ($timezones = get_records_csv($CFG->tempdir.'/timezone.txt', 'timezone')) {  // Parse it
                update_timezone_records($timezones);
                $importdone = $source;
            }
            unlink($CFG->tempdir.'/timezone.txt');
        }
    }


/// Final resort, use the copy included in Lion
    $source = $CFG->dirroot.'/lib/timezone.txt';
    if (!$importdone and is_readable($source)) {  // Distribution file
        if ($timezones = get_records_csv($source, 'timezone')) {
            update_timezone_records($timezones);
            $importdone = $source;
        }
    }


/// That's it!

    if ($importdone) {
        $a = new stdClass();
        $a->count = count($timezones);
        $a->source  = $importdone;
        echo $OUTPUT->notification(get_string('importtimezonescount', 'tool_timezoneimport', $a), 'notifysuccess');
        echo $OUTPUT->continue_button(new lion_url('/admin/index.php'));

        $timezonelist = array();
        foreach ($timezones as $timezone) {
            if (is_array($timezone)) {
                $timezone = (object)$timezone;
            }
            if (isset($timezonelist[$timezone->name])) {
                $timezonelist[$timezone->name]++;
            } else {
                $timezonelist[$timezone->name] = 1;
            }
        }
        ksort($timezonelist);

        $timezonetable = new html_table();
        $timezonetable->head = array(
            get_string('timezone', 'lion'),
            get_string('entries', 'lion')
        );
        $rows = array();
        foreach ($timezonelist as $name => $count) {
            $row = new html_table_row(
                array(
                    new html_table_cell($name),
                    new html_table_cell($count)
                )
            );
            $rows[] = $row;
        }
        $timezonetable->data = $rows;
        echo html_writer::table($timezonetable);

    } else {
        echo $OUTPUT->notification(get_string('importtimezonesfailed', 'tool_timezoneimport'));
        echo $OUTPUT->continue_button(new lion_url('/admin/index.php'));
    }

    echo $OUTPUT->footer();


