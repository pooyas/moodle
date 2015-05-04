<?php
/**
 * @package    backup
 * @subpackage convert
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') or die('Direct access to this script is forbidden.');

class entities {
    /**
     * Prepares convert for inclusion into XML
     *
     * @param string $value
     * @return string
     */
    public static function safexml($value) {
        $result = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'),
                                   ENT_NOQUOTES,
                                   'UTF-8',
                                   false);
        return $result;
    }

    protected function prepare_content($content) {
        $result = $content;
        if (empty($result)) {
            return '';
        }
        $encoding = null;
        $xml_error = new libxml_errors_mgr();
        $dom = new DOMDocument();
        $dom->validateOnParse = false;
        $dom->strictErrorChecking = false;
        if ($dom->loadHTML($content)) {
            $encoding = $dom->xmlEncoding;
        }
        if (empty($encoding)) {
            $encoding = mb_detect_encoding($content, 'auto', true);
        }
        if (!empty($encoding) && !mb_check_encoding($content, 'UTF-8')) {
            $result = mb_convert_encoding($content, 'UTF-8', $encoding);
        }

        // See if we can strip off body tag and anything outside of it.
        foreach (array('body', 'html') as $tagname) {
            $regex = str_replace('##', $tagname, "/<##[^>]*>(.+)<\/##>/is");
            if (preg_match($regex, $result, $matches)) {
                $result = $matches[1];
                break;
            }
        }
        return $result;
    }

    public function load_xml_resource($path_to_file) {

        $resource = new DOMDocument();

        cc2lion::log_action('Load the XML resource file: '.$path_to_file);

        if (!$resource->load($path_to_file)) {
            cc2lion::log_action('Cannot load the XML resource file: ' . $path_to_file, true);
        }

        return $resource;
    }

    public function update_sources($html, $root_path = '') {

        $document = $this->load_html($html);

        $tags = array('img' => 'src' , 'a' => 'href');

        foreach ($tags as $tag => $attribute) {

            $elements = $document->getElementsByTagName($tag);

            foreach ($elements as $element) {

                $attribute_value = $element->getAttribute($attribute);
                $protocol = parse_url($attribute_value, PHP_URL_SCHEME);

                if (empty($protocol)) {
                    $attribute_value = str_replace("\$IMS-CC-FILEBASE\$", "", $attribute_value);
                    $attribute_value = $this->full_path($root_path . "/" . $attribute_value, "/");
                    $attribute_value = "\$@FILEPHP@\$" . "/" . $attribute_value;
                }

                $element->setAttribute($attribute, $attribute_value);
            }
        }

        $html = $this->html_insidebody($document);

        return $html;
    }

    public function full_path($path, $dir_sep = DIRECTORY_SEPARATOR) {

        $token = '$IMS-CC-FILEBASE$';
        $path = str_replace($token, '', $path);

        if (is_string($path) && ($path != '')) {
            $dot_dir = '.';
            $up_dir = '..';
            $length = strlen($path);
            $rtemp = trim($path);
            $start = strrpos($path, $dir_sep);
            $can_continue = ($start !== false);
            $result = $can_continue ? '' : $path;
            $rcount = 0;

            while ($can_continue) {

                $dir_part = ($start !== false) ? substr($rtemp, $start + 1, $length - $start) : $rtemp;
                $can_continue = ($dir_part !== false);

                if ($can_continue) {
                    if ($dir_part != $dot_dir) {
                        if ($dir_part == $up_dir) {
                            $rcount++;
                        } else {
                            if ($rcount > 0) {
                                $rcount --;
                            } else {
                                $result = ($result == '') ? $dir_part : $dir_part . $dir_sep . $result;
                            }
                        }
                    }
                    $rtemp = substr($path, 0, $start);
                    $start = strrpos($rtemp, $dir_sep);
                    $can_continue = (($start !== false) || (strlen($rtemp) > 0));
                }
            }
        }

        return $result;
    }

    public function include_titles ($html) {

        $document = $this->load_html($html);

        $images = $document->getElementsByTagName('img');

        foreach ($images as $image) {

            $src = $image->getAttribute('src');
            $alt = $image->getAttribute('alt');
            $title = $image->getAttribute('title');

            $filename = pathinfo($src);
            $filename = $filename['filename'];

            $alt = empty($alt) ? $filename : $alt;
            $title = empty($title) ? $filename : $title;

            $image->setAttribute('alt', $alt);
            $image->setAttribute('title', $title);
        }

        $html = $this->html_insidebody($document);

        return $html;
    }

    public function get_external_xml ($identifier) {

        $xpath = cc2lion::newx_path(cc2lion::$manifest, cc2lion::$namespaces);

        $files = $xpath->query('/imscc:manifest/imscc:resources/imscc:resource[@identifier="'.
            $identifier.'"]/imscc:file/@href');

        if (empty($files)) {
            $response = '';
        } else {
            $response = $files->item(0)->nodeValue;
        }

        return $response;
    }

    public function move_files($files, $destination_folder) {
        global $CFG;

        if (!empty($files)) {

            foreach ($files as $file) {
                $source = cc2lion::$path_to_manifest_folder . DIRECTORY_SEPARATOR . $file;
                $destination = $destination_folder . DIRECTORY_SEPARATOR . $file;

                $destination_directory = dirname($destination);

                cc2lion::log_action('Copy the file: ' . $source . ' to ' . $destination);

                if (!file_exists($destination_directory)) {
                    mkdir($destination_directory, $CFG->directorypermissions, true);
                }

                $copy_success = true;
                if (is_file($source)) {
                    $copy_success = @copy($source, $destination);
                }

                if (!$copy_success) {
                    notify('WARNING: Cannot copy the file ' . $source . ' to ' . $destination);
                    cc2lion::log_action('Cannot copy the file ' . $source . ' to ' . $destination, false);
                }
            }
        }
    }

    protected function get_all_files () {
        global $CFG;

        $all_files = array();

        $xpath = cc2lion::newx_path(cc2lion::$manifest, cc2lion::$namespaces);

        foreach (cc2lion::$restypes as $type) {

            $files = $xpath->query('/imscc:manifest/imscc:resources/imscc:resource[@type="' . $type . '"]/imscc:file/@href');

            if (!empty($files) && ($files->length > 0)) {
                foreach ($files as $file) {
                    // Omit html files.
                    $ext = strtolower(pathinfo($file->nodeValue, PATHINFO_EXTENSION));
                    if (in_array($ext, array('html', 'htm', 'xhtml'))) {
                        continue;
                    }
                    $all_files[] = $file->nodeValue;
                }
            }
            unset($files);
        }

        // Are there any labels?
        $xquery = "//imscc:item/imscc:item/imscc:item[imscc:title][not(@identifierref)]";
        $labels = $xpath->query($xquery);
        if (!empty($labels) && ($labels->length > 0)) {
            $tname = 'course_files';
            $dpath = cc2lion::$path_to_manifest_folder . DIRECTORY_SEPARATOR . $tname;
            $rfpath = 'files.gif';
            $fpath = $dpath . DIRECTORY_SEPARATOR . $rfpath;

            if (!file_exists($dpath)) {
                mkdir($dpath, $CFG->directorypermissions, true);
            }
            // Copy the folder.gif file.
            $folder_gif = "{$CFG->dirroot}/pix/i/files.gif";
            copy($folder_gif, $fpath);
            $all_files[] = $rfpath;
        }

        $all_files = empty($all_files) ? '' : $all_files;

        return $all_files;
    }

    public function move_all_files() {

        $files = $this->get_all_files();

        if (!empty($files)) {
            $this->move_files($files, cc2lion::$path_to_manifest_folder . DIRECTORY_SEPARATOR . 'course_files', true);
        }

    }

    /**
     * @param string $html
     * @return DOMDocument
     */
    private function load_html($html) {
        // Need to make sure that the html passed has charset meta tag.
        $metatag = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        if (strpos($html, $metatag) === false) {
            $html = '<html><head>'.$metatag.'</head><body>'.$html.'</body></html>';
        }

        $document = new DOMDocument();
        @$document->loadHTML($html);

        return $document;
    }

    /**
     * @param DOMDocument $domdocument
     * @return string
     */
    private function html_insidebody($domdocument) {
        $html = '';
        $bodyitems = $domdocument->getElementsByTagName('body');
        if ($bodyitems->length > 0) {
            $body = $bodyitems->item(0);
            $html = str_ireplace(array('<body>', '</body>'), '', $body->C14N());
        }

        return $html;
    }

    public function generate_random_string ($length = 6) {

        $response = '';
        $source = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if ($length > 0) {

            $response = '';
            $source = str_split($source, 1);

            for ($i = 1; $i <= $length; $i++) {
                $num = mt_rand(1, count($source));
                $response .= $source[$num - 1];
            }
        }

        return $response;
    }

    public function truncate_text($text, $max, $remove_html) {

        if ($max > 10) {
            $text = substr($text, 0, ($max - 6)) . ' [...]';
        } else {
            $text = substr($text, 0, $max);
        }

        $text = $remove_html ? strip_tags($text) : $text;

        return $text;
    }
}
