<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class session {

    public function __construct() {
        $this->init();
    }

    private static function _RegenerateId() {
        if (version_compare(phpversion(), '5.1.0', '>=')) {
            session_regenerate_id(FALSE);
        } else {
            session_regenerate_id();
        }
    }

    public static function init() {
        session_start();
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
        session::_RegenerateId();
    }

    public static function get($key, $secondKey = false) {
        session::_RegenerateId();
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        if ($secondKey == true) {
            if (isset($_SESSION[$key][$secondKey]))
                return $_SESSION[$key][$secondKey];
        }
        else {
            if (isset($_SESSION[$key]))
                return $_SESSION[$key];
        }
    }

    public static function destroy() {
        session_destroy();
    }

}

$session = new session();
