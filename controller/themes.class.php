<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class Run_Theme {

    public $theme_msg = '';
    public $DB;
    public $request;

    public function __construct() {
        global $httpRequest;
        $db = DB::db();
        $this->DB = $db;
        $this->request = $httpRequest;
        add_action('ajax', array($this, 'save_option'));
        add_action('ajax', array($this, 'theme_style'));
    }

    public function xss_remove($x_content) {
        $x_content = preg_replace('#(<[^>]+[\s\r\n\"\'])(on|xmlns)[^>]*>#iU', "$1>", $x_content);
        $x_content = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*)[\\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iU', '$1=$2nojavascript...', $x_content);
        $x_content = preg_replace('#([a-z]*)[\x00-\x20]*=([\'\"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iU', '$1=$2novbscript...', $x_content);
        $x_content = preg_replace('#</*\w+:\w[^>]*>#i', '', $x_content);
        do {
            $oldstring = $x_content;
            $x_content = preg_replace('#</*(\?xml|applet|meta|xml|blink|link|style|script|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i', "", $x_content);
        } while ($oldstring != $x_content);
        return $x_content;
    }

    public function getOptions($name) {
        $options = $this->DB->table('options');
        $options->where('option_name', $name);
        $data = $options->get_one();
        if ($data)
            return $data['option_value'];
    }

    public function get_themeOptions($name) {
        $options = $this->DB->table('options');
        $options->where('option_name', 'theme');
        $data = $options->get_one();
        if ($data) {
            $theme_options = $data['option_value'];
            if ($theme_options) {
                $option_array = unserialize($theme_options);
                if (is_array($option_array)) {
                    if (isset($option_array[$name]))
                        return $option_array[$name];
                }
            }
        }
    }
    
    public function get_customOptions($name) {
        $options = $this->DB->table('options');
        $options->where('option_name', 'custom_options');
        $data = $options->get_one();
        if ($data) {
            $theme_options = $data['option_value'];
            if ($theme_options) {
                $option_array = unserialize($theme_options);
                if (is_array($option_array)) {
                    if (isset($option_array[$name]))
                        return $option_array[$name];
                }
            }
        }
    }

    public function saveOptions($data) {
        $options = $this->DB->table('options');
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $options->where('option_name', $key);
                $options->update(array('option_value' => serialize($value)));
            } else {
                $options->where('option_name', $key);
                $options->update(array('option_value' => $this->DB->escape($this->xss_remove($value), true)));
            }
        }
    }

    public function get_options($name) {
        return $this->getOptions($name);
    }

    public function get_themeNme() {
        return $this->get_options('theme_name');
    }

    function theme_style() {
        if ($this->request->http_get('function') == 'main-style') {
            $style = @file_get_contents(get_theme_assets('css/main.less'));
            if ($this->get_themeOptions('color')) {
                $style = str_replace('@my-color: #1be08f;', '@my-color: ' . $this->get_themeOptions('color') . ';', $style);
            }
            echo $style;
        }
    }

    public function theme_functions() {
        $functions = 'views/themes/' . $this->get_themeNme() . '/functions.php';
        if (file_exists($functions)) {
            require($functions);
        } else {
            die('Error : functions.php not found !');
        }
    }

    public function run_themeIndex() {
        if (isset($_GET['page'])) {
            $index = 'views/themes/' . $this->get_themeNme() . '/page.php';
            if (file_exists($index)) {
                require($index);
            } else {
                die('Error : page.php not found !');
            }
        } elseif (isset($_GET['get-ajax'])) {
            $index = 'views/themes/' . $this->get_themeNme() . '/get-ajax.php';
            if (file_exists($index)) {
                require($index);
            } else {
                die('Error : get-ajax.php not found !');
            }
        } else {
            $index = 'views/themes/' . $this->get_themeNme() . '/index.php';
            if (file_exists($index)) {
                require($index);
            } else {
                die('Error : index.php or main.php not found !');
            }
        }
    }

    public function save_option() {
        if ($this->request->http_isset('save_options', 'post')) {
            $this->saveOptions($this->request->http_post('option', 'escape_array'));
        }
    }

}

$Run_Theme = new Run_Theme();

function get_option($name) {
    global $Run_Theme;
    return $Run_Theme->get_options($name);
}

function get_theme_option($name) {
    global $Run_Theme;
    return $Run_Theme->get_themeOptions($name);
}

function get_custom_option($name) {
    global $Run_Theme;
    return $Run_Theme->get_customOptions($name);
}
