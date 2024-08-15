<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class M_Users extends AH_Model {

    public $model_msg;

    public function send_email($send_title, $user_email, $sender_email, $msg) {
        if (!empty($user_email) and ! empty($sender_email)) {
            if (Allow_SMTP == TRUE) {
                $mail_smtp = new PHPMailer;
                $mail_smtp->isSMTP();
                $mail_smtp->Host = SMTP_Server;
                $mail_smtp->CharSet ='UTF-8';
                $mail_smtp->SMTPAuth = true;
                //$mail_smtp->SMTPDebug = 2;
                $mail_smtp->Debugoutput = 'html';
                $mail_smtp->Username = SMTP_User;
                $mail_smtp->Password = SMTP_Password;
                $mail_smtp->SMTPSecure = SMTP_Secure;
                $mail_smtp->Port = SMTP_Port;
                $mail_smtp->setFrom($sender_email);
                $mail_smtp->addAddress($user_email);
                $mail_smtp->isHTML(true);
                $mail_smtp->Subject = $send_title;
                $mail_smtp->Body = $msg;
                $mail_smtp->send();
            } else {
                //$my_ip = $_SERVER['REMOTE_ADDR'];
                $header = "From: " . $sender_email . "\nMessage-ID: <" . md5(uniqid(time())) . $sender_email . ">\nMIME-Version: 1.0\nContent-type: text/html; charset=utf-8\nContent-transfer-encoding: 8bit\nDate: " . date("r", time()) . "\nX-Priority: 3\nX-MSMail-Priority: Normal\nX-Mailer: PHP\n";
                mail($user_email, $send_title, $msg, $header);
            }
        }
    }
	public function send_sms($to,$text){
		ini_set("soap.wsdl_cache_enabled", "0");
		$sms = new SoapClient('http://api.payamak-panel.com/post/Send.asmx?wsdl', array('encoding'=>'UTF-8'));	
		if(!is_array($to)){
			$param['username'] = get_option('sms_username');
			$param['password'] = get_option('sms_password');
			$param['to'] = array($to);
			$param['from'] = get_option('sms_number');
			$param['text'] = $text;
			$param['isflash'] = false;
			//$sms->SendSimpleSMS($param);
			return $sms->SendSimpleSMS($param)->SendSimpleSMSResult->string;
		}
		if(is_array($to)){
			$nums = array();
			foreach($to as $number){
				array_push($nums,$number);
			}
			$param['username'] = get_option('sms_username');
			$param['password'] = get_option('sms_password');
			$param['to'] = $nums;
			$param['from'] = get_option('sms_number');
			$param['text'] = $text;
			$param['isflash'] = false;
			//$send_time = time();
			//date_default_timezone_set("Asia/Tehran");
			$sms->SendSimpleSMS($param)->SendSimpleSMSResult->string;
			return 13;
		}
	}
	public function addSMS($subject,$content,$user_id = NULL) {
		$userID = !empty($user_id) ? $user_id : NULL;
		if($userID != NULL){
			$data['status'] = $this->send_sms(user_data_byID($userID,'phone'),$content);
			$data['sent_to'] = user_data_byID($userID, 'name');
			$data['subject'] = $this->DB->escape($subject, true);
			$data['content'] = $this->DB->escape($content, true);
			$data['time'] = time();
		}
		else if($userID == NULL){
			$users = $this->get_users();
			$num_array = array();
			foreach($users as $user){
				array_push($num_array,$user['phone']);
			}
			$data['status'] = $this->send_sms($num_array,$content);
			$data['sent_to'] = __('All Users');
			$data['subject'] = $this->DB->escape($subject, true);
			$data['content'] = $this->DB->escape($content, true);
			$data['time'] = time();
		}
		if(strlen($data['status']) > 2 or $data['status'] == 13 or $data['status'] == 1){
			$sms = DB::table('sms');
			$sms->insert($data);
			$this->model_msg = '<div class="alert alert-success alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert">
										<span aria-hidden="true">&times;</span>
										<span class="sr-only">Close</span>
									</button>
									<strong>' . __('Success') . ' : </strong> ' . __('sms has been sent') . '
								</div><script>window.location.replace("'.Site_URL . '/sms/view/' . $sms->insert_id().'")</script>';
		}
		else{
			$sms = DB::table('sms');
			$sms->insert($data);
			$this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert">
										<span aria-hidden="true">&times;</span>
										<span class="sr-only">Close</span>
									</button>
									<strong>' . __('Error') . ' : </strong> ' . __('sms didn\'t sent! to be informed about erorr see status on sms section in adminpanel') . '
								</div><script>window.location.replace("'.Site_URL . '/sms/view/' . $sms->insert_id().'")</script>';
		}
	}
    public function get_users() {
        $users = DB::table('users');
        $users_list = $users->get();
    }

    public function uploadImage($name) {
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
                    return 'error_type';
                } elseif ($filesize > $size) {
                    return 'error_size';
                } else {
                    move_uploaded_file($tmpname, $folder . $new_name . $filename);
                    return Site_URL . '/' . $folder . $new_name . $filename;
                }
            }
        }
    }

    public function do_login($email, $password, $remmber = 'false') {
        $user = DB::table('users');
        $user->where('email', $this->DB->escape($email, true))->and_where('password', $this->DB->escape(md5(md5($password)), true));
        $get_user = $user->get_one();
        if (!empty($get_user) and is_array($get_user)) {
            $u_id = $get_user['id'];
            $u_active = $get_user['active'];
            $u_email = $get_user['email'];
            $u_name = $get_user['name'];
            $u_passowrd = $get_user['password'];
            $user_photo = $get_user['photo'];
            $is_admin = $get_user['is_admin'];
            if ($u_active != 1) {
                $this->model_msg = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Warning') . ' : </strong> ' . __('your account not active') . ' 
                                    </div>';
            } else if ($u_active == 1) {
                $this->set('user_id', $u_id);
                $this->set('email', $u_email);
                $this->set('password', $u_passowrd);
                $this->set('name', $u_name);
                $this->set('user_photo', $user_photo);
                $this->set('is_admin', $is_admin);
                if ($this->DB->escape($remmber, true) == 'true') {
                    $expire = time() + 60 * 60 * 24 * 30;
                    setcookie('ah_tickets_email', $this->xss_remove($email), $expire, '');
                    setcookie('ah_tickets_passowrd', $this->DB->escape(md5(md5($password))), $expire, '');
                } else if (!$this->DB->escape($remmber, true)) {
                    setcookie("ah_tickets_email", "", time() - 60000, '');
                    setcookie("ah_tickets_passowrd", "", time() - 60000, '');
                }
            }
        } else {
            $this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('invalid email or password') . ' 
                                    </div>';
        }
    }

    public function remmberLogin($email, $password) {
        $user = DB::table('users');
        $user->where('email', $this->DB->escape($email, true))->and_where('password', $this->DB->escape($password, true));
        $get_user = $user->get_one();
        if (!empty($get_user) and is_array($get_user)) {
            $u_id = $get_user['id'];
            $u_active = $get_user['active'];
            $u_email = $get_user['email'];
            $u_name = $get_user['name'];
            $u_passowrd = $get_user['password'];
            $is_admin = $get_user['is_admin'];
            if ($u_active == 1) {
                $this->set('user_id', $u_id);
                $this->set('email', $u_email);
                $this->set('password', $u_passowrd);
                $this->set('name', $u_name);
                $this->set('is_admin', $is_admin);
            }
        } else {
            
        }
    }

    public function do_register($r_name, $r_email, $r_password, $r_country, $r_sex,$r_phone) {
        $str = '(-/@/-1234567891011121314151617181920-(&&^%#$%#$!%&)abdo-hamoud[abdo-host]-/@/-)';
        $user_active = substr(str_shuffle($str), 0, 10);
        $user_get = DB::table('users');
        $user_get->fields('phone', 'email');
        $user_get->where('email', $this->DB->escape($r_email, true))->or_where('phone', $this->DB->escape($r_phone, true));
        $user_check = $user_get->get();
        $numbers = '0123456789';
        $sms_auth_code = substr(str_shuffle($numbers),0,5);  
		if(preg_match("/^09(1[0-9]|2[12]|3[0-9]|90|01)+\d{3}\d{4}$/",$r_phone) == 0){
			$this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('your phone is invalid') . '
                                    </div>';
				   return;
        }
		if(Allow_SMS_Reg_Phone == TRUE){
			$dateOBJ = new DateTime();
			$regdate = $dateOBJ->getTimestamp();
			ini_set("soap.wsdl_cache_enabled", "0");
			$sms_client = new SoapClient('http://api.payamak-panel.com/post/contacts.asmx?wsdl', array('encoding'=>'UTF-8'));
			$parameters['username'] = get_option('sms_username');
			$parameters['password'] = get_option('sms_password');
			$parameters['groupIds'] = get_option('sms_groupIds');
			$parameters['firstname'] = $r_name;
			$parameters['lastname'] = ""; 		
			$parameters['nickname'] = "";
			$parameters['corporation'] = "";
			$parameters['mobilenumber'] = $r_phone;
			$parameters['phone'] = "";
			$parameters['fax'] = "";
			$parameters['birthdate'] = $regdate;
			$parameters['email'] = "";
			$parameters['gender'] = $r_sex;
			$parameters['province'] = "";
			$parameters['city'] = "";
			$parameters['address'] = "";
			$parameters['postalCode'] = "";
			$parameters['additionaldate'] = $regdate;
			$parameters['additionaltext'] = "";
			$parameters['descriptions'] = __('Registred In System : ').Site_URL;
			if($sms_client->AddContact($parameters)->AddContactResult == 0){
				$this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('your number can\'t be registered at WS') . '
                                    </div>';
									return;
			}
		}
        if (!empty($user_check) and $user_check[0]['email'] == $r_email) {
            $this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('your email used by another user') . '
                                    </div>';
        }
		else if (!empty($user_check) and $user_check[0]['phone'] == $r_phone) {
            $this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('your phone has been registered in database by another user') . '
                                    </div>';
        }
		 else {
            $users = DB::table('users');
            $data = array(
                'name' => $this->DB->escape($this->xss_remove($r_name), true),
                'email' => $this->DB->escape($this->xss_remove($r_email), true),
                'password' => $this->DB->escape(md5(md5($r_password)), true),
                'location' => $this->DB->escape($this->xss_remove($r_country), true),
                'gender' => $this->DB->escape($this->xss_remove($r_sex), true),
                'is_admin' => 0,
                'active' => 0,
                'active_key' => md5($user_active),
                'register_time' => time(),
		            'phone' => $this->DB->escape($this->xss_remove($r_phone), true),
                'sms_auth_code' => md5($this->DB->escape($this->xss_remove($sms_auth_code), true))
                
            );
            $users->insert($data);
            if(Allow_SMS_Auth === TRUE){
              //$data['sms_auth_code'] = md5($sms_auth_code);
              $msg = "کد فعالسازی \n".$sms_auth_code;
              $this->send_sms($r_phone,$msg);
              $this->model_msg = '<div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Success') . ' : </strong> ' . __('account registred now check your phone for registration code') . '
                                    </div><meta http-equiv="refresh" content="10;url=' . Site_URL . '/active_user/id/'. $users->insert_id() .'">';
            }
            else if(Allow_SMS_Auth === FALSE){
            $msg = email_template(array(
                '<b>' . __('Hello') . ' : </b> ' . $r_name,
                '<b>' . __('Active Link') . ' : </b> <a href="' . Site_URL . '/active_user/user_key/' . md5($user_active) . '"> ' . __('Active Now') . '</a>'
            ));
            $this->send_email('' . __('Activate Your Account') . '  ' . '[ ' . Site_Name . ' ]', $r_email, Site_Email, $msg);
            $this->model_msg = '<div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Success') . ' : </strong> ' . __('registered account , go to email and active account') . '
                                    </div><meta http-equiv="refresh" content="10;url=' . Site_URL . '/login">';
        }   
     }
    
    }
    public function do_active_by_sms($user_id,$activation_code){
      $users = DB::table('users');
      $users->where('id',$this->DB->escape($user_id, true));
      $user_check1 = $users->get_one();
      if(!empty($user_check1) and $user_check1['active'] == 1){
        $this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('This account is aleardy activated') . '
                                        </div>';return;
      }
      $users->where('id',$this->DB->escape($user_id, true))->and_where('sms_auth_code',md5($this->DB->escape($activation_code, true)));
      $user_check2 = $users->get_one();
      if(!empty($user_check2) and $user_check2['sms_auth_code'] == md5($activation_code)){
        //$users->where('id',$this->DB->escape($user_id, true));
        $users->update(array('active' => 1));
        $this->model_msg = '<div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Success') . ' : </strong> ' . __('successfully registered') . '
                                    </div><meta http-equiv="refresh" content="10;url=' . Site_URL . '/login">';return;
      }
      else{
        $this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('Bad request') . '
                                    </div>';return;
      }
    }

    public function forgotPassword($email) {
        $str = '(12345678910-abcdefghijklmnopqrstuvwxyz)';
        $newPass = substr(str_shuffle($str), 0, 8);
        $user_get = DB::table('users');
        $user_get->where('email', $this->DB->escape($email, true));
        $user_check = $user_get->get_one();
        if (!empty($user_check) and $user_check['email'] == $email) {
            $users = DB::table('users');
            $users->where('email', $email);
            $users->update(array('password' => $this->DB->escape(md5(md5($newPass)), true)));
            $msg = email_template(array(
                '<b>' . __('Hello') . ' : </b> ' . $user_check['name'],
                '<b>' . __('New Password') . ' : </b> ' . $newPass
            ));
            $this->send_email(__('Reset My Password') . '  ' . "[ " . Site_Name . " ]", $email, Site_Email, $msg);
            $this->destroy();
            $this->model_msg = '<div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Success') . ' : </strong> ' . __('new password has been sent') . ' <a class="pull-right" href="' . Site_URL . '/login">' . __('Login') . '</a>
                                    </div>' . time_redirect(10000, Site_URL . '/login');
        } else {
            $this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('your email not registered') . '
                                    </div>';
        }
    }

    public function active_account($value) {
        $user_get = DB::table('users');
        $user_get->where('active_key', $this->DB->escape($value, true));
        $user_check = $user_get->get_one();
        if (!empty($user_check) and $user_check['active_key'] == $value) {
            if ($user_check['active'] == 0) {
                $users = DB::table('users');
                $users->where('active_key', $value);
                $users->update(array('active' => 1));
                $this->model_msg = '<div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Success') . ' : </strong> ' . __('your account has been activated') . ' <a class="pull-right" href="' . Site_URL . '/login">' . __('Login') . '</a>
                                    </div>' . time_redirect(10000, Site_URL . '/login');
            } else {
                $this->model_msg = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Warning') . ' : </strong> ' . __('account activated') . ' <a class="pull-right" href="' . Site_URL . '/login">' . __('Login') . '</a>
                                    </div>' . time_redirect(10000, Site_URL . '/login');
            }
        } else {
            $this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('wrong active code') . '
                                    </div>';
        }
    }

    public function addUser($name, $email, $password, $location, $gender, $active, $bio, $photo, $phone) {
        $users = DB::table('users');
	    $user_photo = '';
        $photo_file = '';
        $filename = isset($_FILES[$photo]) ? $_FILES[$photo]['name'] : NULL;
        $photo_file = $this->uploadImage($photo);
        $data = array();
		if(!empty($phone)){
			if(preg_match("/^09(1[0-9]|2[12]|3[0-9]|90|01)+\d{3}\d{4}$/",$phone) == 0){
				$this->model_msg = alert_message(__('Warning'), __('your phone is invalid'), 'warning');
				return;
			}
			else{
				$users->where('phone', $this->DB->escape($phone, true));
				$check_phone = $users->get_one();
				if(!empty($check_phone)){
					if($check_phone['id'] != Session::get('user_id')){
						$this->model_msg = alert_message(__('Warning'), __('your phone has been registered in database by another user'), 'warning');
						return;
					}
				}
				
			}
		}
        if (!empty($filename)) {
            if ($photo_file != 'error_type' and $photo_file != 'error_size') {
                $user_photo = $photo_file;
            } elseif ($photo_file == 'error_type') {
                $this->model_msg = alert_message(__('Error'), __('invalid file type'), 'danger');
                return;
            } elseif ($photo_file == 'error_size') {
                $this->model_msg = alert_message(__('Warning'), __('file size bigger than') . ' ' . formatSize(Attach_Size), 'warning');
                return;
            }
        }
        $str = '(-/@/-1234567891011121314151617181920-(&&^%#$%#$!%&)abdo-hamoud[abdo-host]-/@/-)';
        $user_active = substr(str_shuffle($str), 0, 10);
        $data = array(
            'name' => $this->DB->escape($name, true),
            'email' => $this->DB->escape($email, true),
            'password' => $this->DB->escape(md5(md5($password)), true),
            'location' => $this->DB->escape($location, true),
            'gender' => $this->DB->escape($gender, true),
            'is_admin' => 0,
            'active' => $this->DB->escape($active, true),
            'active_key' => md5($user_active),
            'bio' => $this->DB->escape($bio, true),
            'photo' => $user_photo,
            'register_time' => time(),
			'phone' => ($phone !== NULL) ? $this->DB->escape($phone, true) : NULL,
        );
		$users->where('email', $this->DB->escape($email, true));
		$check_user = $users->get_one();
        if (empty($check_user)) {
            $users->insert($data);
        } else {
            $this->model_msg = alert_message(__('Warning'), __('this email used in another account'), 'warning');
        }
    }


    public function editUser($id, $name, $email, $password, $location, $gender, $active, $bio, $photo, $phone) {
        $users = DB::table('users');
		$photo_file = '';
        $user_photo = '';
        $filename = isset($_FILES[$photo]) ? $_FILES[$photo]['name'] : NULL;
        $photo_file = $this->uploadImage($photo);
        $data = array();
		if(!empty($phone)){
			if(preg_match("/^09(1[0-9]|2[12]|3[0-9]|90|01)+\d{3}\d{4}$/",$phone) == 0){
				$this->model_msg = alert_message(__('Warning'), __('your phone is invalid'), 'warning');
				return;
			}
			else{
				$users->where('phone', $this->DB->escape($phone, true));
				$check_phone = $users->get_one();
				if(!empty($check_phone)){
					if($check_phone['id'] != $id){
						$this->model_msg = alert_message(__('Warning'), __('your phone has been registered in database by another user'), 'warning');
						return;
					}
				}
				
			}
		}
        if (!empty($filename)) {
            if ($photo_file != 'error_type' and $photo_file != 'error_size') {
                $user_photo = $photo_file;
            } elseif ($photo_file == 'error_type') {
                $this->model_msg = alert_message(__('Error'), __('invalid file type'), 'danger');
                return;
            } elseif ($photo_file == 'error_size') {
                $this->model_msg = alert_message(__('Warning'), __('file size bigger than') . ' ' . formatSize(Attach_Size), 'warning');
                return;
            }
        }
        //$users = DB::table('users');
        $users->where('id', $this->DB->escape($id, true));
        $check_image = $users->get_one();
        if (empty($user_photo))
            $user_photo = $check_image['photo'];
        if (empty($password)) {
			if(empty($phone)){
            $data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
            );
			}
			else if(!empty($phone)){
				$data = array(
					'name' => $this->DB->escape($name, true),
					'email' => $this->DB->escape($email, true),
					'location' => $this->DB->escape($location, true),
					'gender' => $this->DB->escape($gender, true),
					'active' => $this->DB->escape($active, true),
					'bio' => $this->DB->escape($bio, true),
					'photo' => $user_photo,
					'phone' => $this->DB->escape($phone, true)
				);
			}
        } else if(!empty($password)){
			if(!empty($phone)){
            $data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'password' => $this->DB->escape(md5(md5($password)), true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
				'phone' => $this->DB->escape($phone, true)
            );
			}
			else{
				$data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'password' => $this->DB->escape(md5(md5($password)), true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
            );
			}
        }
        $get_users = DB::table('users');
        $get_users->where('email', $this->DB->escape($email, true));
		$check_user = $get_users->get_one();
        if (empty($check_user)) {
            $get_users->where('id', $this->DB->escape($id, true));
            $get_users->update($data);
        } else {
            if ($check_user['id'] == $id) {
                $get_users->where('id', $this->DB->escape($id, true));
                $get_users->update($data);
            } else {
                $this->model_msg = alert_message(__('Warning'), __('this email used in another account'), 'warning');
            }
        }
    }

    public function editProfile($id, $name, $email, $password, $location, $gender, $active, $bio, $photo, $phone) {
       	$users = DB::table('users');
	    $photo_file = '';
        $user_photo = '';
        $filename = isset($_FILES[$photo]) ? $_FILES[$photo]['name'] : NULL;
        $photo_file = $this->uploadImage($photo);
        $data = array();
		if(!empty($phone)){
			if(preg_match("/^09(1[0-9]|2[12]|3[0-9]|90|01)+\d{3}\d{4}$/",$phone) == 0){
				$this->model_msg = alert_message(__('Warning'), __('your phone is invalid'), 'warning');
				return;
			}
			else{
				$users->where('phone', $this->DB->escape($phone, true));
				$check_phone = $users->get_one();
				if(!empty($check_phone)){
					if($check_phone['id'] != $id){
						$this->model_msg = alert_message(__('Warning'), __('your phone has been registered in database by another user'), 'warning');
						return;
					}
				}
				
			}
		}
        if (!empty($filename)) {
            if ($photo_file != 'error_type' and $photo_file != 'error_size') {
                $user_photo = $photo_file;
            } elseif ($photo_file == 'error_type') {
                $this->model_msg = alert_message(__('Error'), __('invalid file type'), 'danger');
                return;
            } elseif ($photo_file == 'error_size') {
                $this->model_msg = alert_message(__('Warning'), __('file size bigger than') . ' ' . formatSize(Attach_Size), 'warning');
                return;
            }
        }
        //$users = DB::table('users');
        $users->where('id', $this->DB->escape($id, true));
        $check_image = $users->get_one();
        if (empty($user_photo))
            $user_photo = $check_image['photo'];
        if (empty($password)) {
			if(empty($phone)){
            $data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
            );
			}
			else if(!empty($phone)){
				$data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
				'phone' => $this->DB->escape($phone, true),
            );
			}
        } else {
			if(!empty($phone)){
            $data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'password' => $this->DB->escape(md5(md5($password)), true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
				'phone' => $this->DB->escape($phone, true),
            );
			}
			else if(empty($phone)){
				 $data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'password' => $this->DB->escape(md5(md5($password)), true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
            );
			}
        }

        if ($id == get_session('user_id')) {
            $get_users = DB::table('users');
            $get_users->where('email', $this->DB->escape($email, true));
            $check_user = $get_users->get_one();
            if (empty($check_user)) {
                $users->where('id', $this->DB->escape($id, true));
                $users->update($data);
            } else {
                if ($check_user['id'] == $id) {
                    $users->where('id', $this->DB->escape($id, true));
                    $users->update($data);
                } else {
                    $this->model_msg = alert_message(__('Warning'), __('this email used in another account'), 'warning');
                }
            }
        }
    }

    public function addStuff($name, $email, $password, $location, $gender, $active, $departments, $edit_customers, $bio, $photo, $phone) {
        $users = DB::table('users');
		$photo_file = '';
        $user_photo = '';
        $filename = isset($_FILES[$photo]) ? $_FILES[$photo]['name'] : NULL;
        $photo_file = $this->uploadImage($photo);
        $data = array();
		if(!empty($phone)){
			if(preg_match("/^09(1[0-9]|2[12]|3[0-9]|90|01)+\d{3}\d{4}$/",$phone) == 0){
				$this->model_msg = alert_message(__('Warning'), __('your phone is invalid'), 'warning');
				return;
			}
			else{
				$users->where('phone', $this->DB->escape($phone, true));
				$check_phone = $users->get_one();
				if(!empty($check_phone)){
					if($check_phone['id'] != $id){
						$this->model_msg = alert_message(__('Warning'), __('your phone has been registered in database by another user'), 'warning');
						return;
					}
				}
				
			}
		}
        if (!empty($filename)) {
            if ($photo_file != 'error_type' and $photo_file != 'error_size') {
                $user_photo = $photo_file;
            } elseif ($photo_file == 'error_type') {
                $this->model_msg = alert_message(__('Error'), __('invalid file type'), 'danger');
                return;
            } elseif ($photo_file == 'error_size') {
                $this->model_msg = alert_message(__('Warning'), __('file size bigger than') . ' ' . formatSize(Attach_Size), 'warning');
                return;
            }
        }
        $str = '(-/@/-1234567891011121314151617181920-(&&^%#$%#$!%&)abdo-hamoud[abdo-host]-/@/-)';
        $user_active = substr(str_shuffle($str), 0, 10);
        $data = array(
            'name' => $this->DB->escape($name, true),
            'email' => $this->DB->escape($email, true),
            'password' => $this->DB->escape(md5(md5($password)), true),
            'location' => $this->DB->escape($location, true),
            'gender' => $this->DB->escape($gender, true),
            'is_admin' => 2,
            'active' => $this->DB->escape($active, true),
            'active_key' => md5($user_active),
            'bio' => $this->DB->escape($bio, true),
            'register_time' => time(),
            'photo' => $user_photo,
			'phone' => ($phone !== NULL)? $this->DB->escape($phone, true) : '',
        );
        $users->where('email', $this->DB->escape($email, true));
        $check_user = $users->get_one();
        if (empty($check_user)) {
            $department_access = DB::table('stuff_relations');
            $users->insert($data);
            foreach ($departments as $department) {
                $data_2 = array(
                    'stuff_id' => $users->insert_id(),
                    'stuff_departments' => $this->DB->escape($department, true),
                    'edit_customers' => $this->DB->escape($edit_customers, true)
                );
                $department_access->insert($data_2);
            }
        } else {
            $this->model_msg = alert_message(__('Warning'), __('this email used in another account'), 'warning');
        }
    }

    public function editStuff($id, $name, $email, $password, $location, $gender, $active, $departments, $edit_customers, $bio, $photo, $phone) {
        $users = DB::table('users');
		$photo_file = '';
        $user_photo = '';
        $filename = isset($_FILES[$photo]) ? $_FILES[$photo]['name'] : NULL;
        $photo_file = $this->uploadImage($photo);
        $data = array();
		if(!empty($phone)){
			if(preg_match("/^09(1[0-9]|2[12]|3[0-9]|90|01)+\d{3}\d{4}$/",$phone) == 0){
				$this->model_msg = alert_message(__('Warning'), __('your phone is invalid'), 'warning');
				return;
			}
			else{
				$users->where('phone', $this->DB->escape($phone, true));
				$check_phone = $users->get_one();
				if(!empty($check_phone)){
					if($check_phone['id'] != $id){
						$this->model_msg = alert_message(__('Warning'), __('your phone has been registered in database by another user'), 'warning');
						return;
					}
				}
				
			}
		}
        if (!empty($filename)) {
            if ($photo_file != 'error_type' and $photo_file != 'error_size') {
                $user_photo = $photo_file;
            } elseif ($photo_file == 'error_type') {
                $this->model_msg = alert_message(__('Error'), __('invalid file type'), 'danger');
                return;
            } elseif ($photo_file == 'error_size') {
                $this->model_msg = alert_message(__('Warning'), __('file size bigger than') . ' ' . formatSize(Attach_Size), 'warning');
                return;
            }
        }
       // $users = DB::table('users');
        $users->where('id', $this->DB->escape($id, true));
        $check_image = $users->get_one();
        if (empty($user_photo))
            $user_photo = $check_image['photo'];
        if (empty($password)) {
			if(empty($phone)){
            $data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
            );
			}
			else{
				$data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
				'phone' => $this->DB->escape($phone, true),
            );
			}
        } else {
			if(empty($phone)){
            $data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'password' => $this->DB->escape(md5(md5($password)), true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
            );
			}
			else{
				$data = array(
                'name' => $this->DB->escape($name, true),
                'email' => $this->DB->escape($email, true),
                'password' => $this->DB->escape(md5(md5($password)), true),
                'location' => $this->DB->escape($location, true),
                'gender' => $this->DB->escape($gender, true),
                'active' => $this->DB->escape($active, true),
                'bio' => $this->DB->escape($bio, true),
                'photo' => $user_photo,
				'phone' => $this->DB->escape($phone, true),
            );
			}
        }
       //$users->update($data);
        $department_access = DB::table('stuff_relations');
        $users->where('email', $this->DB->escape($email, true));
        $check_user = $users->get_one();

        if (empty($check_user)) {
            $users->where('id', $this->DB->escape($id, true));
            $users->update($data);
            $department_access->where('stuff_id', $this->DB->escape($id, true));
            $has_access = $department_access->get();
            if ($has_access) {
                $department_access->delete();
            }
            foreach ($departments as $department) {
                $data_2 = array(
                    'stuff_id' => $this->DB->escape($id, true),
                    'stuff_departments' => $this->DB->escape($department, true),
                    'edit_customers' => $this->DB->escape($edit_customers, true)
                );
                $department_access->insert($data_2);
            }
        } else {
            if ($check_user['id'] == $id) {
                $users->where('id', $this->DB->escape($id, true));
                $users->update($data);
                $department_access->where('stuff_id', $this->DB->escape($id, true));
                $has_access = $department_access->get();
                if ($has_access) {
                    $department_access->delete();
                }
                foreach ($departments as $department) {
                    $data_2 = array(
                        'stuff_id' => $this->DB->escape($id, true),
                        'stuff_departments' => $this->DB->escape($department, true),
                        'edit_customers' => $this->DB->escape($edit_customers, true)
                    );
                    $department_access->insert($data_2);
                }
            } else {
                $this->model_msg = alert_message(__('Warning'), __('this email used in another account'), 'warning');
            }
        }
    }

    public function deleteUser($id) {
        $department = DB::table('users');
        $department->where('id', $this->DB->escape($id, true));
        $department->delete();
    }

    public function getUsers($num) {
        $users = DB::table('users');
        $users->left_join('location', 'countries', 'country_code');
        $users->where('is_admin', 0);
        if ($num == null) {
            return $users->get();
        } elseif ($num != null and is_numeric($num)) {
            return $users->get($num);
        }
    }

    public function getStuff($num) {
        $users = DB::table('users');
        $users->left_join('location', 'countries', 'country_code');
        $users->where('is_admin', 2);
        if ($num == null) {
            return $users->get();
        } elseif ($num != null and is_numeric($num)) {
            return $users->get($num);
        }
    }

    public function socialLogin($social_type, $id, $r_name, $r_email, $r_country = '', $r_sex = '', $bio = '', $img = '') {
        $str = '(-/@/-1234567891011121314151617181920-(&&^%#$%#$!%&)abdo-hamoud[abdo-host]-/@/-)';
        $user_active = substr(str_shuffle($str), 0, 10);
        $user_get = DB::table('users');
        $user_get->fields('social_id', 'email');
        $user_get->where('email', $this->DB->escape($r_email, true));
        $user_check = $user_get->get();
        if (!empty($user_check) and $user_check[0]['social_id'] == $id and $user_check[0]['email'] == $r_email) {
            $this->do_login($this->DB->escape($this->xss_remove($r_email), true), $this->DB->escape($id, true), 'true');
        } else {
            if (!empty($user_check) and $user_check[0]['email'] == $r_email) {
                $this->model_msg = '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('your email used by another user') . '
                                    </div>';
            } else {
                $users = DB::table('users');
                $data = array(
                    'social_id' => $this->DB->escape($this->xss_remove($id), true),
                    'name' => $this->DB->escape($this->xss_remove($r_name), true),
                    'email' => $this->DB->escape($this->xss_remove($r_email), true),
                    'password' => $this->DB->escape(md5(md5($id)), true),
                    'location' => $this->DB->escape($this->xss_remove($r_country), true),
                    'gender' => $this->DB->escape($this->xss_remove($r_sex), true),
                    'bio' => $this->DB->escape($this->xss_remove($bio), true),
                    'photo' => $this->DB->escape($this->xss_remove($img), true),
                    'is_admin' => 0,
                    'active' => 1,
                    'active_key' => md5($user_active),
                    'social_type' => $social_type,
                    'register_time' => time()
                );
                $users->insert($data);
                $this->do_login($this->DB->escape($this->xss_remove($r_email), true), $this->DB->escape($id, true), 'true');
            }
        }
    }

}
