<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class Update extends AH_Model {

    public $update_msg;

    function __construct() {
        parent::__construct();
       if ($this->check_table('users') and $this->check_table('tickets') and $this->check_table('departments') and $this->check_table('stuff_relations') and $this->check_table('countries') and $this->check_table('options') and $this->check_table('posts')) {
            if (!$this->check_table('notifications')) {
                add_action('ajax', array($this, 'update_2_2'));
                $this->update_msg = $this->update_alert('2.2');
            }
	   
			else{
				if ($this->check_table('notifications') and !$this->check_table('sms')) {
					//if(!$this->check_table('sms')){
					add_action('ajax', array($this, 'update_2_3'));
					$this->update_msg = $this->update_alert('2.3');
					//}
				}
        if(!$this->check_column('sms_auth_code')){
          add_action('ajax', array($this, 'update_2_3_2'));
					$this->update_msg = $this->update_alert('2.3.2');
        }
			}
		}
        	
    }

    public function update_alert($version) {
        return alert_message(__('Update New Version'), ' V' . $version . ' <button data-ajax="' . Site_URL . '/ajax/update_'. str_replace(".","_",$version) .'" class="btn btn-sm btn-twitter pull-right run_new_updates" data-version="' . $version . '" id="v_'.str_replace(".","_",$version).'" style="postion:realtive; top:-5px;">' . __('Update Now') . ' <em class="form-loading"><i class="fa fa-refresh"></i></em></button>', 'info');
    }

    public function update_sqlDB($file_version) {
        $filename = "models/sql/$file_version";
        $templine = '';
        // Read in entire file
        $lines = file($filename);
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $this->DB->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                // Reset temp variable to empty
                $templine = '';
            }
        }
    }

    public function update_2_2() {
        if ($this->request->http_isset('update_2_2', 'post')) {
            add_option('custom_options', 'a:0:{}');
            update_option('attach_file_type', 'image/jpeg,image/jpg,image/png,text/plain,application/zip,application/x-zip-compressed,multipart/x-zip,application/x-compressed,application/x-rar-compressed,application/octet-stream,application/pdf');
			update_option('script_version','2.2');
            $this->update_sqlDB('update-2.2.sql');
            die('updates done');
        }
    }
	 public function update_2_3() {
        if ($this->request->http_isset('update_2_3', 'post')) {
            add_option('allow_sms', 'off');
			add_option('allow_sms_inform_reply','off');
			add_option('sms_username','');
			add_option('sms_password','');
			add_option('sms_number','');
			add_option('allow_sms_reg_phone','off');
			add_option('sms_groupIds','');
			update_option('script_version','2.3');
      $this->update_sqlDB('update-2.3.sql');
      die('updates done');
        }
    }
    public function update_2_3_2(){
       if ($this->request->http_isset('version', 'post') and $this->request->http_post('version') == 'v_2_3_2') {
      $this->DB->query('ALTER TABLE `users` ADD `sms_auth_code` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `active_key`');
      add_option('allow_sms_auth','off');
      update_option('script_version','2.3.2');
      die('updates done');
       }
    }

}


$Update = new Update();

define('Update_MSG', $Update->update_msg);
