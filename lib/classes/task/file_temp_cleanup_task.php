<?php

/**
 * A scheduled task.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\task;

/**
 * Simple task to delete temp files older than 1 week.
 */
class file_temp_cleanup_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('tasktempfilecleanup', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;

        $tmpdir = $CFG->tempdir;
        // Default to last weeks time.
        $time = time() - ($CFG->tempdatafoldercleanup * 3600);

        $dir = new \RecursiveDirectoryIterator($tmpdir);
        // Show all child nodes prior to their parent.
        $iter = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::CHILD_FIRST);

        // An array of the full path (key) and date last modified.
        $modifieddateobject = array();

        // Get the time modified for each directory node. Nodes will be updated
        // once a file is deleted, so we need a list of the original values.
        for ($iter->rewind(); $iter->valid(); $iter->next()) {
            $node = $iter->getRealPath();
            if (!is_readable($node)) {
                continue;
            }
            $modifieddateobject[$node] = $iter->getMTime();
        }

        // Now loop through again and remove old files and directories.
        for ($iter->rewind(); $iter->valid(); $iter->next()) {
            $node = $iter->getRealPath();
            if (!is_readable($node)) {
                continue;
            }

            // Check if file or directory is older than the given time.
            if ($modifieddateobject[$node] < $time) {
                if ($iter->isDir() && !$iter->isDot()) {
                    // Don't attempt to delete the directory if it isn't empty.
                    if (!glob($node. DIRECTORY_SEPARATOR . '*')) {
                        if (@rmdir($node) === false) {
                            mtrace("Failed removing directory '$node'.");
                        }
                    }
                }
                if ($iter->isFile()) {
                    if (@unlink($node) === false) {
                        mtrace("Failed removing file '$node'.");
                    }
                }
            } else {
                // Return the time modified to the original date.
                touch($node, $modifieddateobject[$node]);
            }
        }
    }

}
