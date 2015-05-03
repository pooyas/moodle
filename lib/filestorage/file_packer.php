<?php

/**
 * Abstraction of general file packer.
 *
 * @package   core_files
 * @copyright 2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Abstract class for archiving of files.
 *
 * @package   core_files
 * @copyright 2015 Pooya Saeedi 
 * 
 */
abstract class file_packer {
    /**
     * Archive files and store the result in file storage.
     *
     * The key of the $files array is always the path within the archive, e.g.
     * 'folder/subfolder/file.txt'. There are several options for the values of
     * the array:
     * - null = this entry represents a directory, so no file
     * - string = full path to file within operating system filesystem
     * - stored_file = file within Lion filesystem
     * - array with one string element = use in-memory string for file content
     *
     * For the string (OS path) and stored_file (Lion filesystem) cases, you
     * can specify a directory instead of a file to recursively include all files
     * within this directory.
     *
     * @param array $files Array of files to archive
     * @param int $contextid context ID
     * @param string $component component
     * @param string $filearea file area
     * @param int $itemid item ID
     * @param string $filepath file path
     * @param string $filename file name
     * @param int $userid user ID
     * @param bool $ignoreinvalidfiles true means ignore missing or invalid files, false means abort on any error
     * @param file_progress $progress Progress indicator callback or null if not required
     * @return stored_file|bool false if error stored_file instance if ok
     */
    public abstract function archive_to_storage(array $files, $contextid,
            $component, $filearea, $itemid, $filepath, $filename,
            $userid = NULL, $ignoreinvalidfiles=true, file_progress $progress = null);

    /**
     * Archive files and store the result in os file.
     *
     * The key of the $files array is always the path within the archive, e.g.
     * 'folder/subfolder/file.txt'. There are several options for the values of
     * the array:
     * - null = this entry represents a directory, so no file
     * - string = full path to file within operating system filesystem
     * - stored_file = file within Lion filesystem
     * - array with one string element = use in-memory string for file content
     *
     * For the string (OS path) and stored_file (Lion filesystem) cases, you
     * can specify a directory instead of a file to recursively include all files
     * within this directory.
     *
     * @param array $files array with zip paths as keys (archivepath=>ospathname or archivepath=>stored_file)
     * @param string $archivefile path to target zip file
     * @param bool $ignoreinvalidfiles true means ignore missing or invalid files, false means abort on any error
     * @param file_progress $progress Progress indicator callback or null if not required
     * @return bool true if file created, false if not
     */
    public abstract function archive_to_pathname(array $files, $archivefile,
            $ignoreinvalidfiles=true, file_progress $progress = null);

    /**
     * Extract file to given file path (real OS filesystem), existing files are overwritten.
     *
     * @param stored_file|string $archivefile full pathname of zip file or stored_file instance
     * @param string $pathname target directory
     * @param array $onlyfiles only extract files present in the array
     * @param file_progress $progress Progress indicator callback or null if not required
     * @return array|bool list of processed files; false if error
     */
    public abstract function extract_to_pathname($archivefile, $pathname,
            array $onlyfiles = NULL, file_progress $progress = null);

    /**
     * Extract file to given file path (real OS filesystem), existing files are overwritten.
     *
     * @param string|stored_file $archivefile full pathname of zip file or stored_file instance
     * @param int $contextid context ID
     * @param string $component component
     * @param string $filearea file area
     * @param int $itemid item ID
     * @param string $pathbase file path
     * @param int $userid user ID
     * @param file_progress $progress Progress indicator callback or null if not required
     * @return array|bool list of processed files; false if error
     */
    public abstract function extract_to_storage($archivefile, $contextid,
            $component, $filearea, $itemid, $pathbase, $userid = NULL,
            file_progress $progress = null);

    /**
     * Returns array of info about all files in archive.
     *
     * @param string|file_archive $archivefile
     * @return array of file infos
     */
    public abstract function list_files($archivefile);
}
