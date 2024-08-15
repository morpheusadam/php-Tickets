<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class M_Tickets extends AH_Model {

    public $model_msg;

    public function send_email($to, $from, $subject, $msg) {
        if (Allow_SMTP == TRUE) {
            $mail_smtp = new PHPMailer;
            $mail_smtp->isSMTP();
	    $mail_smtp->CharSet ='UTF-8';
            $mail_smtp->Host = SMTP_Server;
            $mail_smtp->SMTPAuth = true;
            //$mail_smtp->SMTPDebug = 2;
            $mail_smtp->Debugoutput = 'html';
            $mail_smtp->Username = SMTP_User;
            $mail_smtp->Password = SMTP_Password;
            $mail_smtp->SMTPSecure = SMTP_Secure;
            $mail_smtp->Port = SMTP_Port;
            $mail_smtp->setFrom($from);
            $mail_smtp->addAddress($to);
            $mail_smtp->isHTML(true);
            $mail_smtp->Subject = $subject;
            $mail_smtp->Body = $msg;
            $mail_smtp->send();
        } else {
            $header = "From: " . $from . "\nMessage-ID: <" . md5(uniqid(time())) . $from . ">\nMIME-Version: 1.0\nContent-type: text/html; charset=utf-8\nContent-transfer-encoding: 8bit\nDate: " . date("r", time()) . "\nX-Priority: 3\nX-MSMail-Priority: Normal\nX-Mailer: PHP\n";
            mail($to, $subject, $msg, $header);
        }
    }
	public function send_sms($to,$text){
		$sms = new SoapClient('http://api.payamak-panel.com/post/Send.asmx?wsdl', array('encoding'=>'UTF-8'));
		$param['username'] = get_option('sms_username');
		$param['password'] = get_option('sms_password');
		$param['to'] = array($to);
		$param['from'] = get_option('sms_number');
		$param['text'] = $text;
		$param['isflash'] = false;
		return $sms->SendSimpleSMS($param)->SendSimpleSMSResult->string;
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

    public function push_notification_admin($from_user, $department, $type = '', $data = array()) {
        $staff = stuff_data_byDepartment($department);
        $notifications = DB::table('notifications');
        if ($staff) {
            foreach ($staff as $user) {
                $data_table = array(
                    'n_user_from' => $this->DB->escape($from_user, true),
                    'n_user_to' => $this->DB->escape($user['id'], true),
                    'n_type' => $this->DB->escape($type, true),
                    'n_data' => serialize($data),
                    'n_browser_read' => 0,
                    'n_user_read' => 0,
                    'n_time' => time()
                );
                $notifications->insert($data_table);
            }
        }
        $data_table = array(
            'n_user_from' => $this->DB->escape($from_user, true),
            'n_user_to' => $this->DB->escape(1, true),
            'n_type' => $this->DB->escape($type, true),
            'n_data' => serialize($data),
            'n_browser_read' => 0,
            'n_user_read' => 0,
            'n_time' => time()
        );
        $notifications->insert($data_table);
    }

    public function push_notification_user($from_user, $to_user, $type = '', $data = array()) {
        $notifications = DB::table('notifications');
        $data_table = array(
            'n_user_from' => $this->DB->escape($from_user, true),
            'n_user_to' => $this->DB->escape($to_user, true),
            'n_type' => $this->DB->escape($type, true),
            'n_data' => serialize($data),
            'n_browser_read' => 0,
            'n_user_read' => 0,
            'n_time' => time()
        );
        $notifications->insert($data_table);
    }

    public function stuff_send_email($department, $tikect_id, $subject) {
        $emails = stuff_data_byDepartment($department);
        if ($emails) {
            foreach ($emails as $email) {
                $msg = email_template(array(
                    '<b>' . get_session('name') . '</b> ' . __('add new ticket on your department') . '',
                    '<b>' . __('ID') . ' : </b> <a>' . $tikect_id . '</a>',
                    '<b>' . __('Subject') . ' : </b>' . $this->DB->escape($subject, true),
                    '<b><a href="' . Site_URL . '/tickets/view/' . $tikect_id . '">' . __('View Ticket') . '</a></b>'
                ));
                $this->send_email($email['email'], get_session('email'), '' . __('You have new open ticket') . ' - ' . Site_Name, $msg);
            }
        }
    }

    public function stuff_email_reply($department, $tikect_id, $subject) {
        $emails = stuff_data_byDepartment($department);
        if ($emails) {
            foreach ($emails as $email) {
                $msg = email_template(array(
                    '<b> ' . __('Hello') . ' </b> ' . Site_Name . ' ' . __('Stuff Team') . '',
                    '<b>' . __('ID') . ' : </b> <a>' . $tikect_id . '</a>',
                    '<b>' . __('Subject') . ' : </b>' . $subject,
                    '<b><a href="' . Site_URL . '/tickets/view/' . $tikect_id . '">' . __('View Ticket') . '</a></b>'
                ));
                $this->send_email($email['email'], get_session('email'), '' . __('You have reply from customer') . ' [' . get_session('name') . '] - ' . Site_Name, $msg);
            }
        }
    }

    public function addTicket($subject, $department, $type, $content, $attach, $user_id = NULL) {
        $userID = !empty($user_id) ? $user_id : get_session('user_id');
        $userName = (user_data_byID($userID, 'name')) ? user_data_byID($userID, 'name') : '';
        $userEmail = (user_data_byID($userID, 'email')) ? user_data_byID($userID, 'email') : '';
        $filename = isset($_FILES[$attach]) ? $_FILES[$attach]['name'] : NULL;
        $attach_file = $this->uploadImage($attach);
        if (!empty($filename)) {
            if ($attach_file != 'error_type' and $attach_file != 'error_size') {
                $data = array(
                    'user_id' => $this->DB->escape($userID, true),
                    'parent_id' => 0,
                    'subject' => $this->DB->escape($subject, true),
                    'department' => $this->DB->escape($department, true),
                    'status' => 1,
                    'priority' => $this->DB->escape($type, true),
                    'content' => $this->DB->escape($content, true),
                    'attach_file' => $attach_file,
                    'time' => time()
                );
                $tikets = DB::table('tickets');
                $tikets->insert($data);
                $this->push_notification_admin($userID, $department, 'new_ticket', array(
                    'department' => $department,
                    'user_name' => $userName,
                    'text' => 'تیکت جدیدی ارسال کرد',
                    'link' => Site_URL . '/tickets/view/' . $tikets->insert_id()
                ));
                $msg = email_template(array(
                    '<b>' . $userName . '</b> ' . __('add new ticket') . '',
                    '<b>' . __('ID') . ' : </b> <a>' . $tikets->insert_id() . '</a>',
                    '<b>' . __('Subject') . ' : </b>' . $this->DB->escape($subject, true),
                    '<b><a href="' . Site_URL . '/tickets/view/' . $tikets->insert_id() . '">' . __('View Ticket') . '</a></b>'
                ));
                $this->send_email(Activity_Email, get_session('email'), '' . __('You have new open ticket') . ' - ' . Site_Name, $msg);
                $this->stuff_send_email($department, $tikets->insert_id(), $subject);
                $this->model_msg = '<div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Success') . ' : </strong> ' . __('ticket has been added') . '
                                    </div><script>window.location.replace("'.Site_URL . '/tickets/view/' . $tikets->insert_id().'")</script>';
            } else {
                $this->model_msg = $this->uploadImage($attach);
            }
        } else {
            $data = array(
                'user_id' => $this->DB->escape($userID, true),
                'parent_id' => 0,
                'subject' => $this->DB->escape($subject, true),
                'department' => $this->DB->escape($department, true),
                'status' => 1,
                'priority' => $this->DB->escape($type, true),
                'content' => $this->DB->escape($content, true),
                'attach_file' => '',
                'time' => time()
            );
            $tikets = DB::table('tickets');
            $tikets->insert($data);
            $this->push_notification_admin($userID, $department, 'new_ticket', array(
                'department' => $department,
                'user_name' => $userName,
                'text' => 'تیکت جدیدی ارسال کرد',
                'link' => Site_URL . '/tickets/view/' . $tikets->insert_id()
            ));
            $msg = email_template(array(
                '<b>' . $userName . '</b> ' . __('add new ticket') . '',
                '<b>' . __('ID') . ' : </b> <a>' . $tikets->insert_id() . '</a>',
                '<b>' . __('Subject') . ' : </b>' . $this->DB->escape($subject, true),
                '<b><a href="' . Site_URL . '/tickets/view/' . $tikets->insert_id() . '">' . __('View Ticket') . '</a></b>'
            ));
            $this->send_email(Activity_Email, get_session('email'), '' . __('You have new open ticket') . ' - ' . Site_Name, $msg);
            $this->stuff_send_email($department, $tikets->insert_id(), $subject);
            $this->model_msg = '<div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Success') . ' : </strong> ' . __('ticket has been added') . '
                                    </div><script>window.location.replace("'.Site_URL . '/tickets/view/' . $tikets->insert_id().'")</script>';
        }
    }

    function replyTicket($erply_id, $content, $attach) {
        $filename = isset($_FILES[$attach]) ? $_FILES[$attach]['name'] : NULL;
        $attach_file = $this->uploadImage($attach);
        if (!empty($filename)) {
            if ($attach_file != 'error_type' and $attach_file != 'error_size') {
                $data = array(
                    'user_id' => $this->DB->escape(get_session('user_id'), true),
                    'parent_id' => $this->DB->escape($erply_id, true),
                    'status' => 1,
                    'content' => $this->DB->escape($content, true),
                    'attach_file' => $attach_file,
                    'time' => time()
                );
                $tikets = DB::table('tickets');
                $tikets->insert($data);
                $tikets->where('t_id', $erply_id);
                $get_ticket = $tikets->get_one();
                if (get_session('is_admin') == 1 or get_session('is_admin') == 2) {
                    $tikets->update(array('is_answer' => 1));
                    $this->push_notification_user(get_session('user_id'), $get_ticket['user_id'], 'new_reply', array(
                        'department' => $get_ticket['department'],
                        'user_name' => user_data_byID(get_session('user_id'), 'name'),
                        'text' => 'پاسخ جدیدی به تیکت شما داد',
                        'link' => Site_URL . '/tickets/view/' . $erply_id
                    ));
                    $msg = email_template(array(
                        '<b> ' . __('Hello') . ' </b> ' . user_data_byID($get_ticket['user_id'], 'name'),
                        '<b>' . __('ID') . ' : </b> <a>' . $erply_id . '</a>',
                        '<b>' . __('Subject') . ' : </b>' . $get_ticket['subject'],
                        '<b><a href="' . Site_URL . '/tickets/view/' . $erply_id . '">' . __('View Ticket') . '</a></b>'
                    ));
                    $this->send_email(user_data_byID($get_ticket['user_id'], 'email'), Site_Email, '' . __('Your ticket has new reply') . ' - ' . Site_Name, $msg);
                } else if (get_session('is_admin') == 0) {
                    $tikets->update(array('is_answer' => 0, 'is_read' => 0));
                    $this->push_notification_admin(get_session('user_id'), $get_ticket['department'], 'new_reply', array(
                        'department' => $get_ticket['department'],
                        'user_name' => user_data_byID(get_session('user_id'), 'name'),
                        'text' => 'پاسخ جدیدی اضافه کرد',
                        'link' => Site_URL . '/tickets/view/' . $erply_id
                    ));
                    $msg = email_template(array(
                        '<b> ' . __('Hello') . ' </b> ' . Site_Name . ' ' . __('Administrator') . '',
                        '<b>' . __('ID') . ' : </b> <a>' . $erply_id . '</a>',
                        '<b>' . __('Subject') . ' : </b>' . $get_ticket['subject'],
                        '<b><a href="' . Site_URL . '/tickets/view/' . $erply_id . '">' . __('View Ticket') . '</a></b>'
                    ));
                    $this->send_email(Activity_Email, get_session('email'), '' . __('You have reply from customer') . ' [' . get_session('name') . '] - ' . Site_Name, $msg);
                    $this->stuff_email_reply($get_ticket['department'], $erply_id, $get_ticket['subject']);
                }
            } else {
                $this->model_msg = $attach_file;
            }
        } else {
            $data = array(
                'user_id' => $this->DB->escape(get_session('user_id'), true),
                'parent_id' => $this->DB->escape($erply_id, true),
                'status' => 1,
                'content' => $this->DB->escape($content, true),
                'attach_file' => '',
                'time' => time()
            );
            $tikets = DB::table('tickets');
            $tikets->insert($data);
            $tikets->where('t_id', $erply_id);
            $get_ticket = $tikets->get_one();
            if (get_session('is_admin') == 1 or get_session('is_admin') == 2) {
                $tikets->update(array('is_answer' => 1));
                $this->push_notification_user(get_session('user_id'), $get_ticket['user_id'], 'new_reply', array(
                    'department' => $get_ticket['department'],
                    'user_name' => user_data_byID(get_session('user_id'), 'name'),
                    'text' => 'پاسخ جدیدی به تیکت شما داد',
                    'link' => Site_URL . '/tickets/view/' . $erply_id
                ));
                $msg = email_template(array(
                    '<b> ' . __('Hello') . ' </b> ' . user_data_byID($get_ticket['user_id'], 'name'),
                    '<b>' . __('ID') . ' : </b> <a>' . $erply_id . '</a>',
                    '<b>' . __('Subject') . ' : </b>' . $get_ticket['subject'],
                    '<b><a href="' . Site_URL . '/tickets/view/' . $erply_id . '">' . __('View Ticket') . '</a></b>'
                ));
                $this->send_email(user_data_byID($get_ticket['user_id'], 'email'), Site_Email, '' . __('Your ticket has new reply') . ' - ' . Site_Name, $msg);
				if(Allow_SMS_Inform_User_Reply == TRUE){
					//$this->send_sms(user_data_byID($get_ticket['user_id'], 'phone'),'به تیکت شما در سامانه '."\n".Site_URL."\n".'پاسخ داده شد');
					$send_content = "کاربر گرامی " . user_data_byID($get_ticket['user_id'],'name') . "\n تیکت شما در سامانه \n" . Site_URL . "\n پاسخ داده شد";
					$sms_data['status'] =  $this->send_sms(user_data_byID($get_ticket['user_id'],'phone'),$send_content);
					$sms_data['sent_to'] =  user_data_byID($get_ticket['user_id'], 'name');
					$sms_data['subject'] = $this->DB->escape('اطلاع رسانی پاسخ تیکت', true);
					$sms_data['content'] = $this->DB->escape($send_content, true);
					$sms_data['time'] = time();
					$sms_tbl = DB::table('sms');
					$sms_tbl->insert($sms_data);
				}
            } else if (get_session('is_admin') == 0) {
                $tikets->update(array('is_answer' => 0, 'is_read' => 0));
                $this->push_notification_admin(get_session('user_id'), $get_ticket['department'], 'new_reply', array(
                    'department' => $get_ticket['department'],
                    'user_name' => user_data_byID(get_session('user_id'), 'name'),
                    'text' => 'پاسخ جدیدی اضافه کرد',
                    'link' => Site_URL . '/tickets/view/' . $erply_id
                ));
                $msg = email_template(array(
                    '<b> ' . __('Hello') . ' </b> ' . ' ' . Site_Name . ' ' . __('Administrator') . '',
                    '<b>' . __('ID') . ' : </b> <a>' . $erply_id . '</a>',
                    '<b>' . __('Subject') . ' : </b>' . $get_ticket['subject'],
                    '<b><a href="' . Site_URL . '/tickets/view/' . $erply_id . '">' . __('View Ticket') . '</a></b>'
                ));
                $this->send_email(Activity_Email, get_session('email'), '' . __('You have reply from customer') . ' [' . get_session('name') . '] - ' . Site_Name, $msg);
                $this->stuff_email_reply($get_ticket['department'], $erply_id, $get_ticket['subject']);
            }
        }
    }

    public function addDepartment($name) {
        $department = DB::table('departments');
        $department->where('d_name', $this->DB->escape($name, true));
        $check_name = $department->get_one();
        if (empty($check_name)) {
            $data = array(
                'd_name' => $this->DB->escape($name, true),
                'd_time' => time()
            );
            $department->insert($data);
        } else {
            $this->model_msg = alert_message(__('Warning'), __('duplicate department name'), 'warning');
        }
    }

    public function editDepartment($name, $id) {
        $department = DB::table('departments');
        $department->where('d_name', $this->DB->escape($name, true));
        $check_name = $department->get_one();
        if (empty($check_name)) {
            $department->where('d_id', $this->DB->escape($id, true));
            $department->update(array('d_name' => $this->DB->escape($name, true)));
        } else {
            if ($check_name['d_id'] == $id) {
                $department->where('d_id', $this->DB->escape($id, true));
                $department->update(array('d_name' => $this->DB->escape($name, true)));
            } else {
                $this->model_msg = alert_message(__('Warning'), __('duplicate department name'), 'warning');
            }
        }
    }

    public function deleteDepartment($id) {
        $department = DB::table('departments');
        $department->where('d_id', $this->DB->escape($id, true));
        $department->delete();
    }

    public function getDepartmets($num) {
        $departments = DB::table('departments');
        if ($num == null) {
            return $departments->get();
        } elseif ($num != null and is_numeric($num)) {
            return $departments->get($num);
        }
    }

    public function addRate($rate, $id, $parent_id) {
        $tikets = DB::table('tickets');
        if (get_session('user_id')) {
            $tikets->where('t_id', $this->DB->escape($id, true))->and_where('parent_id', $this->DB->escape($parent_id, true));
            $get = $tikets->get_one();
            if ($get['rating'] <= 0) {
                $tikets->update(array('rating' => $this->DB->escape($rate, true)));
            }
        }
    }

    public function closeTicket($id) {
        $tikets = DB::table('tickets');
        $tikets->where('t_id', $this->DB->escape($id, true))->and_where('parent_id', 0);
        $get = $tikets->get_one();
        if ($get['status'] == 1) {
            $tikets->update(array('status' => 0, 'is_answer' => 0));
        }
    }

    public function deleteReply($id, $parent_id) {
        $reply = DB::table('tickets');
        $reply->where('t_id', $this->DB->escape($id, true))->and_where('parent_id', $parent_id)->and_where('user_id', $this->DB->escape(get_session('user_id'), true));
        $reply->delete();
    }

    public function changeDepartment($ticket_id, $department_id) {
        $tikets = DB::table('tickets');
        $tikets->where('t_id', $this->DB->escape($ticket_id, true));
        $tikets->update(array(
            'department' => $this->DB->escape($department_id, true),
            'is_read' => 0
        ));
    }

}
