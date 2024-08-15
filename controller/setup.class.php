<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class update {

    public $DB;
    public $request;

    public function __construct() {
        global $httpRequest;
        $db = DB::db();
        $this->DB = $db;
        $this->request = $httpRequest;
    }

    public function check_table($table) {
        $this->DB->query("SHOW TABLES LIKE '$table'");
        $result = $this->DB->row();
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_version() {
        if ($this->check_table('users') and $this->check_table('tickets') and $this->check_table('departments') and $this->check_table('stuff_relations') and $this->check_table('countries') and $this->check_table('options') and $this->check_table('posts')) {
            return;
        } else if ($this->check_table('users') and $this->check_table('tickets') and $this->check_table('departments') and $this->check_table('stuff_relations') and $this->check_table('countries')) {
            return;
        } else {
            header("location:" . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . 'setup');
            exit('xxxxxxx');
        }
    }

    public function runUpdate() {
        $this->DB->query("SHOW COLUMNS FROM users LIKE 'social_id'");
        $data = $this->DB->row();
        if (!$data) {
            $this->DB->query("ALTER TABLE `users` ADD `social_id` VARCHAR( 255 ) NOT NULL AFTER `id`");
            $this->DB->query("ALTER TABLE `tickets` CHANGE `user_id` `user_id` BIGINT NOT NULL ;");
        }
    }

}

$update = new update();
$update->check_version();
