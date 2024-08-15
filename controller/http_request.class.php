<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

if (!class_exists('httpRequest')) {

    class httpRequest {

        public $param; // the returned POST/GET values
        public $cookie; // the returned COOKIE values
        public $session; // the returned SESSION values
        private $strength; // the strength of sanitization

        /**
         * Class constructor takes one argument to set the strength of sanitization
         * @param string $strength values can be 'normal', 'strong', or 'strict'
         */

        public function __construct($strength = 'normal') {
            $this->param = NULL;
            $this->cookie = NULL;
            $this->session = NULL;
            $this->strength = $strength;
        }

        function xss_clean($data) {
            // Fix &entity\n;
            $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
            $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
            $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
            $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

            // Remove any attribute starting with "on" or xmlns
            $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

            // Remove javascript: and vbscript: protocols
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

            // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

            // Remove namespaced elements (we do not need them)
            $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

            do {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
            } while ($old_data !== $data);

            // we are done...
            return $data;
        }

        public function escape($string) {
            return htmlspecialchars($this->xss_clean($string), ENT_QUOTES, 'UTF-8');
        }

        public function escape_html($string) {
            return addslashes($this->xss_clean($string));
        }

        public function escape_array($array) {
            return $array;
        }
        /**
         * Method to set, clean &/or sanitize a $_GET value if set
         * @param string $name the name of the value sought
         * @param boolean $urlDecode set to TRUE if the method should urldecode the value
         * @param boolean $san set to TRUE if the method should sanitize the value against XSS vulnerabilities
         * @return array
         */
        public function http_get($name = '', $escape = 'escape') {
            if (isset($_GET[$name])) {
                if ($escape == 'escape') {
                    $this->param = $this->escape($_GET[$name]);
                } elseif ($escape == 'escape_html') {
                    $this->param = $this->escape_html($_GET[$name]);
                }
            } else {
                $this->param = NULL;
            }
            return $this->param;
        }

        /**
         * Method to set, clean &/or sanitize a $_POST value if set
         * @param string $name the name of the value sought
         * @param boolean $urlDecode set to TRUE if the method should urldecode the value
         * @param boolean $san set to TRUE if the method should sanitize the value against XSS vulnerabilities
         * @return array
         */
        public function http_post($name = '', $escape = 'escape') {
            if (isset($_POST[$name])) {
                if ($escape == 'escape') {
                    $this->param = $this->escape($_POST[$name]);
                } elseif ($escape == 'escape_html') {
                    $this->param = $this->escape_html($_POST[$name]);
                } elseif ($escape == 'escape_array') {
                    $this->param = $this->escape_array($_POST[$name]);
                }
            } else {
                $this->param = NULL;
            }
            return $this->param;
        }

        /**
         * Additional method to set a $_COOKIE value if set
         * @param string $name the name of the value sought
         */
        public function http_cookie($name = '') {
            $this->cookie = (isset($_COOKIE[$name])) ? $_COOKIE[$name] : NULL;
            return $this->cookie;
        }

        /**
         * Additional method to set a $_SESSION value if set
         * @param string $name the name of the value sought
         */
        public function http_session($name = '') {
            $this->session = (isset($_SESSION[$name])) ?
                    $_SESSION[$name] : NULL;
            return $this->session;
        }

        /**
         * Private method to sanitize data
         * @param mixed $data
         */
        private function san_data($data) {
            switch ($this->strength) {
                default:
                    return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
                    break;
                case 'strong':
                    return htmlentities($data, ENT_QUOTES | ENT_IGNORE, "UTF-8");
                    break;
                case 'strict':
                    return urlencode($data);
                    break;
            }
        }

        public function http_isset($value, $type) {
            if ($type == 'post') {
                return isset($_POST[$value]);
            } elseif ($type == 'get') {
                return isset($_GET[$value]);
            } elseif ($type == 'cookie') {
                return isset($_COOKIE[$value]);
            } elseif ($type == 'session') {
                return isset($_SESSION[$value]);
            }
        }

        public function http_notset($value, $type) {
            if ($type == 'post') {
                return !isset($_POST[$value]);
            } elseif ($type == 'get') {
                return !isset($_GET[$value]);
            }
        }

        public function http_is_int($value, $type) {
            if ($type == 'post') {
                if (isset($_POST[$value])) {
                    if (is_numeric($_POST[$value]))
                        return true;
                }else {
                    return false;
                }
            } elseif ($type == 'get') {
                if (isset($_GET[$value])) {
                    if (is_numeric($_GET[$value]))
                        return true;
                }else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function http_not_empty($value, $type) {
            if ($type == 'post') {
                if (isset($_POST[$value])) {
                    if (!empty($_POST[$value]))
                        return true;
                }else {
                    return false;
                }
            } elseif ($type == 'get') {
                if (isset($_GET[$value])) {
                    if (!empty($_GET[$value]))
                        return true;
                }else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function http_empty($value = '', $type = '') {
            if ($type == 'post') {
                if (isset($_POST[$value])) {
                    if (empty($_POST[$value]))
                        return true;
                }else {
                    return false;
                }
            } elseif ($type == 'get') {
                if (isset($_GET[$value])) {
                    if (empty($_GET[$value]))
                        return true;
                }else {
                    return false;
                }
            } else {
                return false;
            }
        }

    }

}

$httpRequest = new httpRequest();

