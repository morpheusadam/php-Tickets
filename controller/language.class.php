<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class Language {

    public $lang_msg = '';
    public $lang_set = 'en';
    public $request;

    public function __construct() {
        global $httpRequest;
        $db = DB::db();
        $this->DB = $db;
        $this->request = $httpRequest;
    }

    public function getLang($key) {
        if ($this->request->http_cookie('ah_tickets_lang')) {
            $lang_file = 'languages/' . $this->request->http_cookie('ah_tickets_lang') . '.json';
            if (file_exists($lang_file)) {
                $get_lang = @file_get_contents($lang_file);
                $lang = json_decode($get_lang);
                if (!empty($lang->lang_text) and ! empty($key)) {
                    return (!empty($lang->lang_text->$key)) ? $lang->lang_text->$key : $key;
                }
            } else {
                return $key;
            }
        } else {
            $lang_file = 'languages/ah_' . Language . '.json';
            if (Language != '') {
                if (file_exists($lang_file)) {
                    $get_lang = @file_get_contents($lang_file);
                    $lang = json_decode($get_lang);
                    if (!empty($lang->lang_text) and ! empty($key)) {
                        return (!empty($lang->lang_text->$key)) ? $lang->lang_text->$key : $key;
                    }
                } else {
                    return $this->lang_msg = '<div class="sdba-error" style="padding:15px;color:red;margin:10px;border:1px solid red;border-radius:2px;">Language File ah_' . Language . '.json Not found !</div>';
                }
            } else {
                return $key;
            }
        }
    }

    public function get_LangPro($key) {
        $file = 'languages/ah_' . Language . '.po';
        $fd = fopen($file, "rb"); // File will get closed by PHP on return
        $file_name = $file;
        if (!$fd) {
            $msg = sprintf(__('The translation import failed, because the file %s could not be read'), $file_name);
            //do whatever you want with this error msg
            return FALSE;
        }

        $context = "COMMENT"; // Parser context: COMMENT, MSGID, MSGID_PLURAL, MSGSTR and MSGSTR_ARR
        $current = array(); // Current entry being read
        $plural = 0; // Current plural form
        $lineno = 0; // Current line
        $lang_arr = Array(); // total message in the file

        while (!feof($fd)) {

            $line = fgets($fd, 10 * 1024); // A line should not be this long
            if ($lineno == 0) {
                // The first line might come with a UTF-8 BOM, which should be removed.
                $line = str_replace("\xEF\xBB\xBF", '', $line);
            }
            $lineno++;
            $line = trim(strtr($line, array("\\\n" => "")));
            if (!strncmp("#", $line, 1)) { // A comment
                if ($context == "COMMENT") { // Already in comment context: add
                    $current["#"][] = substr($line, 2);
                } elseif (($context == "MSGSTR") || ($context == "MSGSTR_ARR")) { // End current entry, start a new one
                    if (!empty($search_key)) {
                        $pattern = "/\b" . $search_key . "\b/i";
                        if (preg_match($pattern, trim($current['msgid'])))
                            $lang_arr[] = $current;
                    } else
                        $lang_arr[] = $current;

                    $current = array();
                    $current["#"][] = substr($line, 2);
                    $context = "COMMENT";
                }
                else { // Parse error
                    $msg = sprintf(__('The translation file %s contains an error: "msgstr" was expected but not found on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
            } elseif (!strncmp("msgid_plural", $line, 12)) {
                if ($context != "MSGID") { // Must be plural form for current entry
                    $msg = sprintf(__('The translation file %s contains an error: "msgid_plural" was expected but not found on %d line'), $file_name, $lineno);
                    $this->ErrSucc->addError($msg);
                    return FALSE;
                }
                $line = trim(substr($line, 12));
                $quoted = $this->_parse_quoted($line);
                if ($quoted === FALSE) {
                    $msg = sprintf(__('The translation file %s contains a syntax error on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                $current["msgid"] = $current["msgid"] . "\0" . $quoted;
                $context = "MSGID_PLURAL";
            } elseif (!strncmp("msgid", $line, 5)) {
                if ($context == "MSGSTR") { // End current entry, start a new one
                    //$lang_arr[] = $current;
                    $current = array();
                } elseif ($context == "MSGID") { // Already in this context? Parse error
                    $msg = sprintf(__('The translation file %s contains an error: "msgid" is unexpected on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                $line = trim(substr($line, 5));
                $quoted = $this->_parse_quoted($line);
                if ($quoted === FALSE) {
                    $msg = sprintf(__('The translation file %s contains a syntax error on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                $current["msgid"] = $quoted;
                $context = "MSGID";
            } elseif (!strncmp("msgstr[", $line, 7)) {
                if (($context != "MSGID") && ($context != "MSGID_PLURAL") && ($context != "MSGSTR_ARR")) { // Must come after msgid, msgid_plural, or msgstr[]
                    $msg = sprintf(__('The translation file %s contains an error: "msgstr[]" is unexpected on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                if (strpos($line, "]") === FALSE) {
                    $msg = sprintf(__('The translation file %s contains a syntax error on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                $frombracket = strstr($line, "[");
                $plural = substr($frombracket, 1, strpos($frombracket, "]") - 1);
                $line = trim(strstr($line, " "));
                $quoted = $this->_parse_quoted($line);
                if ($quoted === FALSE) {
                    $msg = sprintf(__('The translation file %s contains a syntax error on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                $current["msgstr"][$plural] = $quoted;
                $context = "MSGSTR_ARR";
            } elseif (!strncmp("msgstr", $line, 6)) {
                if ($context != "MSGID") { // Should come just after a msgid block
                    $msg = sprintf(__('The translation file %s contains an error: "msgstr" is unexpected on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                $line = trim(substr($line, 6));
                $quoted = $this->_parse_quoted($line);
                if ($quoted === FALSE) {
                    $msg = sprintf(__('The translation file %s contains a syntax error on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                $current["msgstr"] = $quoted;
                $context = "MSGSTR";
            } elseif ($line != "") {
                $quoted = $this->_parse_quoted($line);
                if ($quoted === FALSE) {
                    $msg = sprintf(__('The translation file %s contains a syntax error on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
                if (($context == "MSGID") || ($context == "MSGID_PLURAL")) {
                    $current["msgid"] .= $quoted;
                } elseif ($context == "MSGSTR") {
                    $current["msgstr"] .= $quoted;
                } elseif ($context == "MSGSTR_ARR") {
                    $current["msgstr"][$plural] .= $quoted;
                } else {
                    $msg = sprintf(__('The translation file %s contains an error: there is an unexpected string on %d line'), $file_name, $lineno);
                    //do whatever you want with this error msg
                    return FALSE;
                }
            }
        }

        // End of PO file, flush last entry
        if (($context == "MSGSTR") || ($context == "MSGSTR_ARR")) {

            if (!empty($search_key)) {
                $pattern = "/\b" . $search_key . "\b/i";
                if (preg_match($pattern, trim($current['msgid'])))
                    $lang_arr[] = $current;
            } else
                $lang_arr[] = $current;
        }
        elseif ($context != "COMMENT") {
            $msg = sprintf(__('The translation file %s ended unexpectedly at %d line'), $file_name, $lineno);
            //do whatever you want with this error msg
            return FALSE;
        }
        fclose($fd);
        return $lang_arr;
    }

    public function _parse_quoted($string) {
        if (substr($string, 0, 1) != substr($string, -1, 1)) {
            return FALSE; // Start and end quotes must be the same
        }
        $quote = substr($string, 0, 1);
        $string = substr($string, 1, -1);
        if ($quote == '"') { // Double quotes: strip slashes
            return stripcslashes($string);
        } elseif ($quote == "'") { // Simple quote: return as-is
            return $string;
        } else {
            return FALSE; // Unrecognized quote
        }
    }

    public function lang_list() {
        $languages = array();
        $dir = 'languages';
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != "." and $file != ".." and $file != "index.php" and $file != "index.html") {
                        $lang_file = @file_get_contents($dir . '/' . $file);
                        $json = json_decode($lang_file);
                        if ($json) {
                            if ($json->lang_name) {
                                $languages[str_replace('.json', '', $file)] = $json->lang_name;
                            }
                        }
                    }
                }
                unset($languages['ah_default']);
                return $languages;
                closedir($dh);
            }
        } else {
            echo '<div class="sdba-error" style="padding:15px;color:red;margin:10px;border:1px solid red;border-radius:2px;">Error in Lang path</div>';
        }
    }

    public function set_lang() {
        if ($this->request->http_isset('set_lang', 'post')) {
            setcookie('ah_tickets_lang', $this->request->http_post('lang_key'), time() + 60 * 60 * 24 * 30 * 12, '/');
        }
    }

}

$Language = new Language();
$Language->set_lang();

function _e($key, $theme_slug = '') {
    global $Language;
    global $Language;
    echo $Language->getLang($key);
}

function __($key, $theme_slug = '') {
    global $Language;
    return $Language->getLang($key);
}

function languages_list() {
    global $Language;
    return $Language->lang_list();
}

function site_lang() {
    global $httpRequest;
    $lang = Language;
    if ($httpRequest->http_cookie('ah_tickets_lang')) {
        return str_replace('ah_', '', $httpRequest->http_cookie('ah_tickets_lang'));
    } elseif (!empty($lang)) {
        return $lang;
    } else {
        return 'en';
    }
}

//$lang_file = 'languages/ah_defualt.pot';
//
//function filter_start($item) {
//    return !preg_match('/^#/', $item);
//}
//
//$data = [];
//$file_handle = $lang_file;
//if ($fh = @fopen($file_handle, "r")) {
//    if ($fh) {
//        $attr = array('', 'msgid', 'msgstr');
//        $x = 18;
//        while (!feof($fh)) {
//            $x++;
//            $F1[] = fgets($fh, 9999);
//        }
//
//        foreach ($F1 as $key => $value) {
//            
//            $value = str_replace('"', '', $value);
//            $value = str_replace('msgid ', '', $value);
//            $value = str_replace('msgstr ', '', $value);
//            $data = array_filter(array_map('trim', $data), 'strlen');
//            if (filter_start($value)) {
//                $data [] = $value;
//            }
//        }
//
//        fclose($fh);
//    }
//}
//echo '<pre>';
//print_r($data);
//echo '</pre>';
//echo json_encode($data);
//
//exit();
