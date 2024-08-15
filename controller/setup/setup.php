<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */


require_once ('../../config.php');
require_once ('../../models/db_config.php');
require_once ('../../models/db_class.php');

class Setup {

    public $run_setup_1;
    public $run_setup_2;
    public $run_setup_3;
    public $run_setup_4;
    public $run_setup_5;
    public $options = array();
    public $DB;

    public function __construct() {
        $db = DB::db();
        $this->DB = $db;
    }

    public function create_tables() {
        $filename = 'db.sql';
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
        echo '<ul>';
        echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "users" Created</li>';
        echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "tickets" Created</li>';
        echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "posts" Created</li>';
        echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "departments" Created</li>';
        echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "stuff_relations" Created</li>';
        echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "countries" Created with ()</li>';
        echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Insert (242 row) To Table "countries" </li>';
        echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "options" Created</li>';
		    echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "sms" Created</li>';
        echo '</ul><div class="clear-15"></div>';
        echo "<div class='alert alert-success'>Tables created successfully</div>";
    }

    public function update_tables() {
        $filename = 'db-update.sql';
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

        $data = array(
            'site_name' => $this->DB->escape($_POST['site_name'], true),
            'site_logo' => $this->DB->escape($_POST['site_logo'], true),
            'site_url' => $this->DB->escape($_POST['site_url'], true),
            'theme_name' => 'AH-Tickets',
            'site_description' => $this->DB->escape($_POST['site_description'], true),
            'site_email' => $this->DB->escape($_POST['site_email'], true),
            'site_phone' => '',
			'privacy_policy' => '',
            'activity_email' => $this->DB->escape($_POST['activity_email'], true),
            'allow_attach_file' => 'on',
            'attach_file_size' => '5242880',
            'attach_file_type' => 'image/jpeg,image/jpg,image/png,text/plain,application/zip,application/x-zip-compressed,multipart/x-zip,application/x-compressed,application/x-rar-compressed,application/octet-stream,application/pdf',
            'allow_delete_replies' => 'on',
            'allow_delete_tickets' => 'on',
            'SMTP_allow' => 'off',
            'SMTP_server' => 'mail.yoursite.com',
            'SMTP_user' => 'name@yoursite.com',
            'SMTP_password' => '123456',
            'SMTP_port' => '465',
            'allow_register' => 'on',
            'allow_login_facebook' => 'on',
            'allow_login_google' => 'on',
            'allow_login_linkedin' => 'on',
            'facebook_APP_KEY' => '',
            'linkedin_APP_KEY' => '',
            'google_Client_ID' => '',
            'allow_map' => 'off',
            'map_latitude' => '',
            'map_longitude' => '',
            'MailChimp_API_KEY' => '',
            'MailChimp_List_ID' => '',
            'contact_email' => $_POST['activity_email'],
            'theme' => serialize(array()),
            'script_version' => "2.3.1",
            'custom_options' => serialize(array()),
            'allow_sms' => 'off',
            'allow_sms_inform_reply' => 'off',
            'sms_username' => '',
            'sms_password' => '',
            'sms_number' => '',
            'allow_sms_reg_phone' => '',
            'sms_groupIds' => ''
        );
        $options = $this->DB->table('options');
        foreach ($data as $key => $value) {
            $options->where('option_name', $key);
            $data = $options->get_one();
            if (!$data)
                $options->insert(array('option_name' => $this->DB->escape($key, true), 'option_value' => $this->DB->escape($value, true)));
        }

        // echo "<div class='alert alert-success'>Tables created and updated successfully</div>";
        echo "<script>window.location.href = '" . $this->getOptions('site_url') . "/login'</script>";
        die();
    }

    public function save_options() {
        if (isset($_POST['save_options'])) {
            $data = array(
                'site_name' => $this->DB->escape($_POST['site_name'], true),
                'site_logo' => $this->DB->escape($_POST['site_logo'], true),
                'site_url' => $this->DB->escape($_POST['site_url'], true),
                'theme_name' => 'AH-Tickets',
                'site_description' => $this->DB->escape($_POST['site_description'], true),
                'site_email' => $this->DB->escape($_POST['site_email'], true),
                'site_phone' => '',
                'activity_email' => $this->DB->escape($_POST['activity_email'], true),
				'privacy_policy' => '',
                'allow_attach_file' => 'on',
                'attach_file_size' => '5242880',
                'attach_file_type' => 'image/jpeg,image/jpg,image/png,text/plain,application/zip,application/x-zip-compressed,multipart/x-zip,application/x-compressed,application/pdf',
                'allow_delete_replies' => 'on',
                'allow_delete_tickets' => 'on',
                'SMTP_allow' => 'off',
                'SMTP_server' => 'mail.yoursite.com',
                'SMTP_user' => 'name@yoursite.com',
                'SMTP_password' => '123456',
                'SMTP_port' => '465',
                'allow_register' => 'on',
                'allow_login_facebook' => 'on',
                'allow_login_google' => 'on',
                'allow_login_linkedin' => 'on',
                'facebook_APP_KEY' => '',
                'linkedin_APP_KEY' => '',
                'google_Client_ID' => '',
                'allow_map' => 'off',
                'map_latitude' => '',
                'map_longitude' => '',
                'MailChimp_API_KEY' => '',
                'MailChimp_List_ID' => '',
                'contact_email' => $_POST['activity_email'],
                'theme' => serialize(array()),
				        'script_version' => "2.3.1",
                'custom_options' => serialize(array()),
                'allow_sms' => 'off',
                'allow_sms_inform_reply' => 'off',
                'sms_username' => '',
                'sms_password' => '',
                'sms_number' => '',
                'allow_sms_reg_phone' => '',
                'sms_groupIds' => ''
            );
            $options = $this->DB->table('options');
            foreach ($data as $key => $value) {
                $options->where('option_name', $key);
                $data = $options->get_one();
                if (!$data)
                    $options->insert(array('option_name' => $this->DB->escape($key, true), 'option_value' => $this->DB->escape($value, true)));
            }
        }
    }

    public function getOptions($name) {
        $options = $this->DB->table('options');
        $options->where('option_name', $name);
        $data = $options->get_one();
        if ($data)
            return $data['option_value'];
    }

    public function create_account() {
        if (isset($_POST['save_admin'])) {
            $str = '(-/@/-1234567891011121314151617181920-(&&^%#$%#$!%&)abdo-hamoud[abdo-host]-/@/-)';
            $user_active = substr(str_shuffle($str), 0, 10);
            $users = DB::table('users');
            $r_name = isset($_POST['register_name']) ? $_POST['register_name'] : '';
            $r_email = isset($_POST['register_email']) ? $_POST['register_email'] : '';
            $r_password = isset($_POST['register_password']) ? $_POST['register_password'] : '';
            $data = array(
                'id' => $this->DB->escape(1, true),
                'name' => $this->DB->escape($r_name, true),
                'email' => $this->DB->escape($r_email, true),
                'password' => $this->DB->escape(md5(md5($r_password)), true),
                'is_admin' => 1,
                'active' => 1,
                'active_key' => md5($user_active),
                'register_time' => time()
            );
            $users->insert($data);
//            $msg = email_template(array(
//                '<b>' . __('Hello') . ' : </b> ' . $r_name,
//                '<b>' . __('Login Link') . ' : </b> <a href="' . $this->getOptions('site_url') . '/login"> ' . __('Active Now') . '</a>'
//            ));
//            $this->send_email('' . __('AH Tickets Setup') . '  ' . '[ ' . $this->getOptions('site_name') . ' ]', $r_email, $this->getOptions('site_email'), $msg);
            echo "<script>window.location.href = '" . $this->getOptions('site_url') . "/login'</script>";
            die();
        }
    }

    public function setup_page() {
        include ('template-setup.php');
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
            
        } else if ($this->check_table('users') and $this->check_table('tickets') and $this->check_table('departments') and $this->check_table('stuff_relations') and $this->check_table('countries')) {
            
        } else {
            
        }
    }

    public function is_setup() {
        if ($this->check_table('users') and $this->check_table('tickets') and $this->check_table('departments') and $this->check_table('stuff_relations') and $this->check_table('countries') and $this->check_table('options') and $this->check_table('posts')) {
            $user = DB::table('users');
            $user->where('id', 1);
            $get_user = $user->get();
            if (!empty($get_user))
                return TRUE;
        }
    }

}

$Setup = new Setup();
//$Setup->check_version();
$Setup->create_account();
$Setup->setup_page();
$Setup->save_options();
