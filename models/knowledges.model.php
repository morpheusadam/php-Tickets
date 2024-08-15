<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class M_Knowledges extends AH_Model {

    public $model_msg;

    public function send_email($to, $from, $subject, $data = array()) {
        $msg = email_template($data);
        if (Allow_SMTP == TRUE) {
            $mail_smtp = new PHPMailer;
            $mail_smtp->isSMTP();
            $mail_smtp->CharSet = 'UTF-8';
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
            $mail = new Mail($to, $from, $subject, '', $msg);
            $mail->send();
        }
    }

    public function uploadImage($name) {
        if (isset($_FILES[$name])) {
            $filename = $_FILES[$name]['name'];
            $filesize = $_FILES[$name]['size'];
            $tmpname = $_FILES[$name]['tmp_name'];
            $filetype = $_FILES[$name]['type'];
            $types = explode(',', Attach_Type);
            $size = Attach_Size;
            $Str = '-/@/-1234567891011121314151617181920-(&&^%#$%#$!%&)';
            $new_name = 'ah-' . md5(substr(str_shuffle($Str), 0, 5)) . '_';
            $folder = 'controller/files/';
            if (!empty($filename)) {
                if (!in_array($filetype, $types)) {
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

    public function addKnowledges($title, $is_public, $department, $content) {
        $knowledges = DB::table('posts');
        $knowledges->where('post_title', $this->DB->escape($title, true));
        $check_title = $knowledges->get_one();
        if (empty($check_title)) {
            $data = array(
                'post_title' => $this->DB->escape($title, true),
                'post_slug' => $this->DB->escape(str_replace(' ', '-', $title), true),
                'post_type' => 'knowledge',
                'post_department' => $this->DB->escape($department, true),
                'post_content' => $this->DB->escape($content, true),
                'post_time' => time(),
                'is_public' => $this->DB->escape($is_public, true)
            );
            $knowledges->insert($data);
        } else {
            $this->model_msg = alert_message(__('Warning'), __('this title used in another post'), 'warning');
        }
    }

    public function editKnowledges($id, $title, $is_public, $department, $content) {
        $knowledges = DB::table('posts');
        $knowledges->where('post_title', $this->DB->escape($title, true));
        $check_title = $knowledges->get_one();
        $data = array(
            'post_title' => $this->DB->escape($title, true),
            'post_slug' => $this->DB->escape(str_replace(' ', '-', $title), true),
            'post_department' => $this->DB->escape($department, true),
            'post_content' => $this->DB->escape($content, true),
            'is_public' => $this->DB->escape($is_public, true)
        );
        if (empty($check_title)) {
            $knowledges->where('post_id', $this->DB->escape($id, true));
            $knowledges->update($data);
        } else {
            if ($check_title['post_id'] == $id) {
                $knowledges->where('post_id', $this->DB->escape($id, true));
                $knowledges->update($data);
            } else {
                $this->model_msg = alert_message(__('Warning'), __('this title used in another post'), 'warning');
            }
        }
    }

    public function deleteKnowledges($id) {
        if (get_session('user_id')) {
            $knowledges = DB::table('posts');
            $knowledges->where('post_id', $this->DB->escape($id, true));
            $knowledges->delete();
        }
    }

    public function likeKnowledges($id, $type) {
        if (get_session('user_id')) {
            $knowledges = DB::table('posts');
            $knowledges->where('post_id', $this->DB->escape($id, true));
            $post = $knowledges->get_one();
            $expire = time() + 60 * 60 * 24 * 30 * 12; // one year
            if (!isset($_COOKIE['is_post_' . $id . '_like'])) {
                if ($post) {
                    $like_count = $post['post_like'];
                    if ($type == '+1') {
                        $knowledges->update(array('post_like' => $like_count + 1));
                        setcookie('is_post_' . $id . '_like', $this->DB->escape($id, true), $expire, '');
                    } elseif ($type == '-1') {
                        $knowledges->update(array('post_like' => $like_count - 1));
                        setcookie('is_post_' . $id . '_like', $this->DB->escape($id, true), $expire, '');
                    }
                }
            }
        }
    }

    public function getKnowledges($num, $is_public) {
        $knowledges = DB::table('posts');
        if ($is_public != NULL) {
            $knowledges->where('post_type', 'knowledge')->and_where('is_public', $is_public);
        } else {
            $knowledges->where('post_type', 'knowledge');
        }
        if ($num == null) {
            return $knowledges->get();
        } elseif ($num != null and is_numeric($num)) {
            return $knowledges->get($num);
        }
    }

    public function get_popularKnowledges($num, $is_public) {
        $knowledges = DB::table('posts');
        if ($is_public != NULL) {
            $knowledges->where('post_type', 'knowledge')->and_where('post_like >=', 1)->and_where('is_public', $is_public);
            $knowledges->sort_by('post_like', 'desc');
        } else {
            $knowledges->where('post_type', 'knowledge')->and_where('post_like >=', 1);
            $knowledges->sort_by('post_like', 'desc');
        }
        if ($num == null) {
            return $knowledges->get();
        } elseif ($num != null and is_numeric($num)) {
            return $knowledges->get($num);
        }
    }

}
