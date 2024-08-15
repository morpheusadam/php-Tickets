<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class AH_Model extends session {

    public $DB;
    public $request;

    public function __construct() {
        global $httpRequest;
        $db = DB::db();
        $this->DB = $db;
        $this->request = $httpRequest;
        $this->check_version();
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
     public function check_column($column) {
      $this->DB->query("SHOW COLUMNS FROM `users` LIKE '$column'");
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
            echo "<script type='text/javascript'>
                    var url = window.location.href;
                    url = url.replace(/\/login/g, '');
                    window.history.pushState('', '', 'setup?update=true');
                    window.location.reload();
                </script>";
        } else {
            echo "<script type='text/javascript'>
                    var url = window.location.href;
                    url = url.replace(/\/login/g, '');
                    window.history.pushState('', '', 'setup');
                    window.location.reload();
                </script>";
        }
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

//    public function send_email($to, $from, $subject, $msg) {
//        //$msg = email_template($data, Site_URL, Site_Name);
//        if (Allow_SMTP == TRUE) {
//            $mail_smtp = new PHPMailer;
//            $mail_smtp->isSMTP();
//            $mail_smtp->Host = SMTP_Server;
//            $mail_smtp->SMTPAuth = true;
//            //$mail_smtp->SMTPDebug = 2;
//            $mail_smtp->Debugoutput = 'html';
//            $mail_smtp->Username = SMTP_User;
//            $mail_smtp->Password = SMTP_Password;
//            $mail_smtp->SMTPSecure = SMTP_Secure;
//            $mail_smtp->Port = SMTP_Port;
//            $mail_smtp->setFrom($from);
//            $mail_smtp->addAddress($to);
//            $mail_smtp->isHTML(true);
//            $mail_smtp->Subject = $subject;
//            $mail_smtp->Body = $msg;
//            $mail_smtp->CharSet = "UTF-8";
//            $mail_smtp->Encoding = "16bit";
//            $mail_smtp->send();
//        } else {
//            $mail = new Mail($to, $from, $subject, '', $msg);
//            $mail->send();
//        }
//    }

    public function ajaxUpload() {
        if ($this->request->http_isset('ajax-upload-file', 'post')) {
            $name = 'file-name';
            if (isset($_FILES[$name])) {
                $filename = $_FILES[$name]['name'];
                $filesize = $_FILES[$name]['size'];
                $tmpname = $_FILES[$name]['tmp_name'];
                $filetype = $_FILES[$name]['type'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $types = explode(',', Attach_Type);
                $size = Attach_Size;
                $Str = '-/@/-1234567891011121314151617181920-(&&^%#$%#$!%&)';
                $new_name = 'ah-' . md5(substr(str_shuffle($Str), 0, 5)) . '_';
                $folder = 'controller/files/';
                if (!empty($filename)) {
                    if (!in_array($ext, $types)) {
                        echo alert_message(__('Error'), __('invalid file type'), 'danger');
                    } elseif ($filesize > $size) {
                        echo alert_message(__('Warning'), __('file size too big'), 'warning');
                    } else {
                        move_uploaded_file($tmpname, $folder . $new_name . $filename);
                        echo Site_URL . '/' . $folder . $new_name . $filename;
                    }
                }
            }
        }
    }

}

require_once ('options.model.php');
require_once ('users.model.php');
require_once ('tickets.model.php');
require_once ('knowledges.model.php');
