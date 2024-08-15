<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

function pupblic_send_email($send_title, $user_email, $sender_email, $msg) {
    if (!empty($user_email) and ! empty($sender_email)) {
        if (Allow_SMTP == TRUE) {
            $mail_smtp = new PHPMailer;
            $mail_smtp->isSMTP();
            $mail_smtp->Host = SMTP_Server;
            $mail_smtp->SMTPAuth = true;
	    	$mail_smtp->CharSet = 'UTF-8';
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

function get_url() {
    return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function redirect_file($path) {
    header("location: " . $path);
    exit();
}

function is_webUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (curl_exec($ch) !== FALSE) {
        return true;
    } else {
        return false;
    }
}

function theme_name() {
    global $Run_Theme;
    return $Run_Theme->get_themeNme();
}

function theme_assets($file) {
    echo Site_URL . '/views/themes/' . theme_name() . '/assets/' . $file;
}

function get_theme_assets($file) {
    return Site_URL . '/views/themes/' . theme_name() . '/assets/' . $file;
}

function theme_path($file) {
    return dirname(__file__) . '/../views/themes/' . theme_name() . '/' . $file;
}

function theme_template($file) {
    $url = theme_path("pages/templates/$file.php");
    if (file_exists($url)) {
        include ($url);
    } else {
        echo('<div class="sdba-error" style="padding:15px;color:red;margin:10px;border:1px solid red;border-radius:2px;">' . __('Template not found') . '</div>');
    }
}

function theme_page() {
    global $httpRequest;
    if ($httpRequest->http_isset('page', 'get')) {
        if (file_exists(theme_path('pages/' . $httpRequest->http_get('page') . '.php'))) {
            include (theme_path('pages/' . $httpRequest->http_get('page') . '.php'));
        } else {
            include (theme_path('pages/404.php'));
        }
    } else {
        if (file_exists(theme_path('pages/index.php'))) {
            include (theme_path('pages/index.php'));
        } else {
            include (theme_path('pages/404.php'));
        }
    }
}

function theme_main_page() {
    global $httpRequest;
    if ($httpRequest->http_isset('main', 'get')) {
        if ($httpRequest->http_isset('sub_page', 'get')) {
            if (file_exists(theme_path('main-pages/' . $httpRequest->http_get('sub_page') . '.php'))) {
                include (theme_path('main-pages/' . $httpRequest->http_get('sub_page') . '.php'));
            } else {
                include (theme_path('main-pages/404.php'));
            }
        } else {
            if (file_exists(theme_path('main-pages/home.php'))) {
                include (theme_path('main-pages/home.php'));
            } else {
                include (theme_path('main-pages/404.php'));
            }
        }
    }
}

function is_user_login() {
    global $Users;
    return $Users->isset_login();
}

function is_home() {
    global $httpRequest;
    return $httpRequest->http_notset('page', 'get');
}

function is_main() {
    global $httpRequest;
    if ($httpRequest->http_isset('main', 'get') and $httpRequest->http_notset('sub_page', 'get'))
        return TRUE;
}

function is_page($page = NULL) {
    global $httpRequest;
    if ($httpRequest->http_isset('page', 'get')) {
        if (empty($page)) {
            return TRUE;
        } else {
            if ($httpRequest->http_get('page') == $page) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    } else {
        return FALSE;
    }
}

function theme_ajax() {
    global $httpRequest;
    if ($httpRequest->http_isset('get-ajax', 'get')) {
        if (file_exists(theme_path('ajax-pages/' . $httpRequest->http_get('get-ajax') . '.php')))
            include (theme_path('ajax-pages/' . $httpRequest->http_get('get-ajax') . '.php'));
        else
            exit('<div class="sdba-error" style="padding:15px;color:red;margin:10px;border:1px solid red;border-radius:2px;">' . __('Page not found') . '</div>');
    }
}

function ajax_modal_upload() {
    $AH_Model = new AH_Model();
    $AH_Model->ajaxUpload();
}

add_action('ajax', 'ajax_modal_upload');

function ajax_contact() {
    global $httpRequest;
    if ($httpRequest->http_isset('contact_us', 'post')) {
        if ($httpRequest->http_not_empty('name', 'post') and $httpRequest->http_not_empty('email', 'post') and $httpRequest->http_not_empty('phone', 'post') and $httpRequest->http_not_empty('content', 'post')) {
            $name = $httpRequest->http_post('name');
            $email = $httpRequest->http_post('email');
            $phone = $httpRequest->http_post('phone');
            $content = $httpRequest->http_post('content');
            $msg = email_template(
                    array(
                        '<b>' . __('Name') . ' : </b> ' . $name,
                        '<b>' . __('Email') . ' : </b> ' . $email,
                        '<b>' . __('Phone') . ' : </b> ' . $phone,
                        '<b>' . __('Message') . ' : </b> ' . nl2br($content)
                    )
            );
            pupblic_send_email(__('You have contact from') . '[ ' . Site_Name . ' ]', get_option('contact_email'), Site_Email, $msg);

            echo alert_message(__('Success'), sprintf(__('Thank you %s for contact us'), $name), 'success');
        } else {
            echo alert_message(__('Error'), __('inputs value empty'), 'danger');
        }
    }
}

add_action('ajax', 'ajax_contact');

function get_header() {
    $header = theme_path('header.php');
    if (file_exists($header)) {
        include($header);
    } else {
        die('Error : header.php not found on your theme !');
    }
}

function get_footer() {
    $header = theme_path('footer.php');
    if (file_exists($header)) {
        include($header);
    } else {
        die('Error : footer.php not found on your theme !');
    }
}

function get_session($key, $secondKey = false) {
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

function page_content($title, $content) {
    echo '<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="ah-panel">
            <h2>' . $title . '</h2>
            <div class="ah-panel-body">
                ' . $content . '
            </div>
        </div>
    </div>
</div>';
}

function time_redirect($time, $url) {
    return '<script type="text/javascript">
    setTimeout(function () {
        window.location.href = "' . $url . '";
    }, ' . $time . ');
</script>';
}

function time_count($time) {
    return;
}

function formatSize($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' ' . __('bytes');
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' ' . __('byte');
    } else {
        $bytes = '0 ' . __('bytes');
    }

    return $bytes;
}

function selected($value, $selected) {
    if ($value == $selected) {
        return 'selected="selected"';
    }
}

function checked($value, $selected) {
    if ($value == $selected) {
        return 'checked="checked"';
    }
}

function array_checked($haystack, $current) {
    if (is_array($haystack) && in_array($current, $haystack)) {
        $current = $haystack = 1;
    }
    return checked($haystack, $current);
}

function formatSize_int($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2);
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2);
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2);
    }
    return $bytes;
}

function time_ago($time) {
    $time_limit = time() - $time;
    $days = array(
        __('Sunday'),
        __('Monday'),
        __('Tuesday'),
        __('Wednesday'),
        __('Thursday'),
        __('Friday'),
        __('Saturday')
    );
    $months = array(
        '',
        __('January'),
        __('February'),
        __('March'),
        __('April'),
        __('May'),
        __('June'),
        __('July'),
        __('August'),
        __('September'),
        __('October'),
        __('November'),
        __('December')
    );
    $date = getdate($time);
    if ($time < 1) {
        return __('Seconds') . ' ' . __('ago');
    }
    $tokens = array(
        31536000 => __('Years'),
        2592000 => __('Months'),
        604800 => __('Weeks'),
        86400 => __('Days'),
        3600 => __('Hours'),
        60 => __('Minutes'),
        1 => __('Seconds'),
    );
    foreach ($tokens as $unit => $text) {
        if ($time_limit < $unit)
            continue;
        $numberOfUnits = floor($time_limit / $unit);
        if ($unit <= 86400) {
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? '' : '') . ' ' . __('ago');
        } else {
            return jdate('d F Y',$time);
        }
    }
}

function replace_img_src($img_tag) {
    $doc = new DOMDocument();
    $doc->loadHTML($img_tag);
    $tags = $doc->getElementsByTagName('img');
    foreach ($tags as $tag) {
        $old_src = $tag->getAttribute('src');
        $new_src_url = str_replace('../views', '../../views', $old_src);
        $tag->setAttribute('src', $new_src_url);
    }
    $html = $doc->saveHTML();
    $html = substr($html, strpos($html, '<html><body>') + 12);
    $html = substr($html, 0, -15);
    return str_replace('%5C%22', '', $html);
}

function strip_html_tags($text) {
    // PHP's strip_tags() function will remove tags, but it
    // doesn't remove scripts, styles, and other unwanted
    // invisible text between tags.  Also, as a prelude to
    // tokenizing the text, we need to insure that when
    // block-level tags (such as <p> or <div>) are removed,
    // neighboring words aren't joined.
    $text = preg_replace(
            array(
        // Remove invisible content
        '@<head[^>]*?>.*?</head>@siu',
        '@<style[^>]*?>.*?</style>@siu',
        '@<script[^>]*?.*?</script>@siu',
        '@<object[^>]*?.*?</object>@siu',
        '@<embed[^>]*?.*?</embed>@siu',
        '@<applet[^>]*?.*?</applet>@siu',
        '@<noframes[^>]*?.*?</noframes>@siu',
        '@<noscript[^>]*?.*?</noscript>@siu',
        '@<noembed[^>]*?.*?</noembed>@siu',
        /* '@<input[^>]*?>@siu', */
        '@<form[^>]*?.*?</form>@siu',
        // Add line breaks before & after blocks
        '@<((br)|(hr))>@iu',
        '@</?((address)|(blockquote)|(center)|(del))@iu',
        '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
        '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
        '@</?((table)|(th)|(td)|(caption))@iu',
        '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
        '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
        '@</?((frameset)|(frame)|(iframe))@iu',
            ), array(
        " ", " ", " ", " ", " ", " ", " ", " ", " ", " ",
        " ", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
        "\n\$0", "\n\$0",
            ), $text);
    // remove empty lines
    $text = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);
    // remove leading spaces
    $text = preg_replace("/\n( )*/", "\n", $text);

    // Remove all remaining tags and comments and return.
    return strip_tags($text);
}

function makeLinks($text) {
    $text = preg_replace('%(((f|ht){1}tp://)[-a-zA-^Z0-9@:\%_\+.~#?&//=]+)%i', '<a href="\\1">\\1</a>', $text);
    $text = preg_replace('%([[:space:]()[{}])(www.[-a-zA-Z0-9@:\%_\+.~#?&//=]+)%i', '\\1<a href="http://\\2">\\2</a>', $text);
    return $text;
}

function alert_message($title = '', $msg = '', $type = '') {
    $content = '<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>' . __($title) . ' : </strong> ' . __($msg) . ' 
                </div>';
    return $content;
}

function dump_r($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function is_allow($value) {
    if ($value == 1) {
        echo '<label class="label label-success"><i class="fa fa-check"></i></label> ';
    } else if ($value == 0) {
        echo '<label class="label label-danger"><i class="fa fa-times"></i></label> ';
    }
}

function email_template($body = array()) {
    require_once('jdf.php');
    $direction = '';
    $color = '#17b976';
    if (site_lang() == 'ar' or site_lang() == 'fa') {
        $direction = ' direction:rtl';
    }
    if (get_theme_option('color')) {
        $color = get_theme_option('color');
    }
    $html = '<div style="background: #f5f5f5; border: 1px solid #ddd; font-family: tahoma; font-size: 14px; color: #555;' . $direction . '">
    <div style="background: ' . $color . '; font-size: 25px; text-transform: capitalize; font-weight: bold; padding: 15px;">
        <a href="' . Site_URL . '" style="color: #fff; text-decoration:none;">' . Site_Name . '</a>
    </div>
    <div style="background: #fff; border: 1px solid #eaeaea; padding: 15px 15px 5px 15px; margin: 15px;">';
    if (is_array($body)) {
        foreach ($body as $b) {

            $html.= '<p style="margin: 0px 0px 10px 0px; font-family: tahoma; font-size: 14px; color: #555; line-height: 21px;">
        ' . $b . '</p>';
        }
    }
    $html.='<b> ' . __('Time') . ' : </b> ' . jdate('d F Y - h:i A', time());
    $html.=' </div>
    <div style="text-align: center; margin-bottom: 15px;">
        ' . __('Powered By') . ' <a href="http://www.rtl-theme.com/?p=28605" target="_blank">AH-Tickets</a> &nbsp; ' . __('Copyright') . ' 2016
    </div>
</div>
';
    return $html;
}

function ticket_status($type, $value) {
    if ($type == 'status') {
        if ($value == 1) {
            echo '<label class="label label-success">' . __('open') . '</label> ';
        } else if ($value == 0) {
            echo '<label class="label label-danger">' . __('closed') . '</label> ';
        }
    } else if ($type == 'is_read') {
        if ($value == 1) {
            echo '<label class="label label-success">' . __('open') . '</label> ';
        } else if ($value == 0) {
            echo '<label class="label label-warning">' . __('pending') . '</label> ';
        }
    }
}
function ticket_is_answer($type, $value, $value2,$status) {
    if ($type == 'class') {
        if ($value2 == 0) {
            echo 'class="unread"';
        } elseif ($value2 == 1) {
            echo '';
        } elseif ($value2 == '') {
            echo '';
        }
        if ($value == 1) {
            echo 'class="answered"';
        }
    } elseif ($type == 'label') {
        if ($value2 == 0) {
            echo '<label class="label label-warning">' . __('unread') . '</label>';
        } elseif ($value2 == 1) {
			if($value != 1 and $status != 0){
           		echo '<label class="label label-info">' . __('pending') . '</label>';
			}
			elseif($status == 0) echo '';
        } elseif ($value2 == '') {
            echo '';
        }
        if ($value == 1) {
            echo '<label class="label label-primary">' . __('answered') . '</label>';
        }
        
    }
}
function ticket__user_is_answer($type, $value) {
    if ($type == 'class') {
        if ($value == 1) {
            echo 'class="answered"';
        }
    } elseif ($type == 'label') {
        if ($value == 1) {
            echo '<label class="label label-primary">' . __('answered') . '</label>';
        }
    }
}

function get_priority($priority) {
    if ($priority == 'low') {
        return __('Low');
    } elseif ($priority == 'medium') {
        return __('Medium');
    } elseif ($priority == 'high') {
        return __('High');
    }
}

function get_last_id($table) {
    $get = DB::table($table);
    return $get->max('t_id') + 1;
}
function get_last_sms_id($table) {
    $get = DB::table($table);
    return $get->max('id') + 1;
}

function last_reply_id($id) {
    $get = DB::table('tickets');
    $get->where('parent_id', $id);
    $count = $get->total();
    if (!empty($count)) {
        return $count = $count + 1;
    } else {
        return 1;
    }
}

function tickets_num($type, $d_array = array()) {
    global $Users;
    if ($type == 'all') {
        $get = DB::table('tickets');
        if ($Users->is_stuff()) {
            $get->where('parent_id', 0)->and_in('department', $d_array);
        } else {
            $get->where('parent_id', 0);
        }
        return $get->total();
    } elseif ($type == 'opened') {
        $get = DB::table('tickets');
        $get->where('status', 1)->and_where('parent_id', 0);
        if ($Users->is_stuff()) {
            $get->where('status', 1)->and_where('parent_id', 0)->and_in('department', $d_array);
        } else {
            $get->where('status', 1)->and_where('parent_id', 0);
        }
        return $get->total();
    } elseif ($type == 'closed') {
        $get = DB::table('tickets');
        if ($Users->is_stuff()) {
            $get->where('status', 0)->and_where('parent_id', 0)->and_in('department', $d_array);
        } else {
            $get->where('status', 0)->and_where('parent_id', 0);
        }
        return $get->total();
    } elseif ($type == 'unread') {
        $get = DB::table('tickets');
        if ($Users->is_stuff()) {
            $get->where('is_read', 0)->and_where('parent_id', 0)->and_in('department', $d_array);
        } else {
            $get->where('is_read', 0)->and_where('parent_id', 0);
        }
        return $get->total();
    } elseif ($type == 'answered') {
        $get = DB::table('tickets');
        if ($Users->is_stuff()) {
            $get->where('is_answer', 1)->and_where('parent_id', 0)->and_in('department', $d_array);
        } else {
            $get->where('is_answer', 1)->and_where('parent_id', 0);
        }
        return $get->total();
    }
}

function my_tickets_num($type) {
    if ($type == 'all') {
        $get = DB::table('tickets');
        $get->where('parent_id', 0)->and_where('user_id', get_session('user_id'));
        return $get->total();
    } elseif ($type == 'opened') {
        $get = DB::table('tickets');
        $get->where('status', 1)->and_where('parent_id', 0)->and_where('user_id', get_session('user_id'));
        return $get->total();
    } elseif ($type == 'closed') {
        $get = DB::table('tickets');
        $get->where('status', 0)->and_where('parent_id', 0)->and_where('user_id', get_session('user_id'));
        return $get->total();
    } elseif ($type == 'unread') {
        $get = DB::table('tickets');
        $get->where('is_read', 0)->and_where('parent_id', 0)->and_where('user_id', get_session('user_id'));
        return $get->total();
    }
}

function departments_num() {
    $get = DB::table('departments');
    return $get->total();
}

function users_num() {
    $get = DB::table('users');
    $get->where('is_admin', 0);
    return $get->total();
}

function stuff_num() {
    $get = DB::table('users');
    $get->where('is_admin', 2);
    return $get->total();
}

function stuff_data_byDepartment($id) {
    $db = DB::db();
    $users = DB::table('stuff_relations');
    $users->where('stuff_departments', $db->escape($id, true));
    $users->left_join('stuff_id', 'users', 'id');
    $users->group_by('stuff_id');
    return $users->get();
}

function get_notification_bUser($id, $type = 'all') {
    $db = DB::db();
    $notifications = DB::table('notifications');
    if ($type == 'unread') {
        $notifications->where('n_user_read', 0);
    } elseif ($type == 'read') {
        $notifications->where('n_user_read', 1);
    }
    $notifications->where('n_user_to', $db->escape($id, true));
    //$notifications->left_join('n_user_from', 'users', 'id');
    $notifications->order_by('n_time', 'desc');
    return $notifications->get();
    $notifications->reset();
}

function get_browser_notification_bUser($id, $type = 'all') {
    $db = DB::db();
    $notifications = DB::table('notifications');
    if ($type == 'unread') {
        $notifications->where('n_browser_read', 0);
    } elseif ($type == 'read') {
        $notifications->where('n_browser_read', 1);
    }
    $notifications->where('n_user_to', $db->escape($id, true));
    //$notifications->left_join('n_user_from', 'users', 'id');
    $notifications->order_by('n_time', 'desc');
    return $notifications->get();
    $notifications->reset();
}

function update_notification_read($id) {
    $db = DB::db();
    $notifications = DB::table('notifications');
    $notifications->where('n_user_read', 0)->and_where('n_user_to', get_session('user_id'))->and_where('n_id', $db->escape($id, true));
    $notifications->update(array('n_user_read' => $db->escape(1, true)));
}

function browser_notification_read($id) {
    $db = DB::db();
    $notifications = DB::table('notifications');
    $notifications->where('n_browser_read', 0)->and_where('n_user_to', get_session('user_id'))->and_where('n_id', $db->escape($id, true));
    $notifications->update(array('n_browser_read' => $db->escape(1, true)));
}

function delete_notification_read($time) {
    $db = DB::db();
    $notifications = DB::table('notifications');
    $notifications->where('n_time <=', time() - $time)->and_where('n_user_read', 1)->and_where('n_user_to', get_session('user_id'));
    $notifications->delete();
}

function get_countries() {
    $get = DB::table('countries');
    return $get->get();
}

function get_departments($num = NULL) {
    $get = DB::table('departments');
    $get->reset();
    if ($num) {
        return $get->get($num);
    } else {
        return $get->get();
    }
}

function get_department_byID($id, $value) {
    $db = DB::db();
    $get = DB::table('departments');
    $get->where('d_id', $db->escape($id, true));
    $data = $get->get_one();
    $get->reset();
    return $data[$value];
}

function get_user_photo($photo) {
    if (!empty($photo)) {
        if (is_webUrl($photo)) {
            return $photo;
        } else {
            return get_theme_assets('images/avatar.jpeg');
        }
    } else {
        return get_theme_assets('images/avatar.jpeg');
    }
}

function get_user_photo_byID($id) {
    $user = get_user_byID($id);
    $photo = $user['photo'];
    if (!empty($photo)) {
        if (is_webUrl($photo)) {
            return $photo;
        } else {
            return get_theme_assets('images/avatar.jpeg');
        }
    } else {
        return get_theme_assets('images/avatar.jpeg');
    }
}

function active_label($value) {
    if ($value == 1) {
        echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
    } elseif ($value == 0) {
        echo '<label class="label label-warning"><i class="fa fa-times"></i></label>';
    }
}

function access_add_edit($id) {
    $db = DB::db();
    $department_access = DB::table('stuff_relations');
    $department_access->where('stuff_id', $db->escape($id, true));
    $department_access->fields('edit_customers');
    $value = $department_access->get_one();
    return $value['edit_customers'];
}

function access_departments($id, $type = 'label') {
    $value = '';
    $db = DB::db();
    $department_access = DB::table('stuff_relations');
    $department_access->where('stuff_id', $db->escape($id, true));
    $department_access->fields('stuff_departments');
    $array = $department_access->get();
    foreach ($array as $key) {
        $value.=$key['stuff_departments'] . ',';
    }
    if ($type == 'label') {
        $new_array = explode(',', $value);
        $label = '';
        $get = DB::table('departments');
        $get->where_in('d_id', $new_array);
        $departments = $get->get();
        $get->reset();
        foreach ($departments as $department) {
            $label .='<label class="label label-primary" style="margin:5px; display:block;">' . $department['d_name'] . '</label>';
        }
        return $label;
    } elseif ($type == 'implode') {
        return $value;
    } elseif ($type == 'array') {
        return explode(',', $value);
    }
}

function deplode($array) {
    if (is_array($array)) {
        $value = '';
        $x = -1;
        $count = count($array);
        foreach ($array as $item) {
            $value.= $item . ',';
        }
        echo $value;
    }
}

function add_option($name, $value) {
    $db = DB::db();
    $options = DB::table('options');
    $options->where('option_name', $db->escape($name, true));
    $get = $options->get_one();
    if (!$get) {
        $options->insert(array('option_name' => $db->escape($name, true), 'option_value' => $db->escape($value, true)));
    }
}

function update_option($name, $value) {
    $db = DB::db();
    $options = DB::table('options');
    $options->where('option_name', $db->escape($name, true));
    $get = $options->get_one();
    if ($get) {
        $options->update(array('option_value' => $db->escape($value, true)));
    }
}

function view_ticket() {
    if (isset($_GET['id']) and ! empty($_GET['id']) and is_numeric($_GET['id'])) {
        $db = DB::db();
        $id = $db->escape($_GET['id'], true);
        $ticket = DB::table('tickets');
        $ticket->where('t_id', $id)->and_where('parent_id', 0);
        $ticket->left_join('department', 'departments', 'd_id');
        $ticket->left_join('user_id', 'users', 'id');
        $get = $ticket->get_one();
        if (get_session('is_admin') == 1 or get_session('is_admin') == 2) {
            $ticket->update(array('is_read' => 1));
        }
        unset(
                $get['password'], $get['facebook_id'], $get['twitter_id'], $get['location'], $get['bio'], $get['access_token'], $get['active'], $get['active_key'], $get['register_time'], $get['is_admin']
        );
        return $get;
    } else {
        return null;
    }
}

function view_knowledge() {
    if (isset($_GET['id']) and ! empty($_GET['id']) and is_numeric($_GET['id'])) {
        $db = DB::db();
        $id = $db->escape($_GET['id'], true);
        $ticket = DB::table('posts');
        $ticket->where('post_id', $id);
        $ticket->left_join('post_department', 'departments', 'd_id');
        $get = $ticket->get_one();
        return $get;
    }
}

function get_knowledge_byDepartment($id) {
    if (is_numeric($id)) {
        $db = DB::db();
        $id = $db->escape($id, true);
        $ticket = DB::table('posts');
        $ticket->where('post_department', $id);
        $ticket->left_join('post_department', 'departments', 'd_id');
        $get = $ticket->get();
        return $get;
    }
}

function search_knowledges($query) {
    if (!is_array($query)) {
        $query = str_replace('+', ' ', $query);
        $db = DB::db();
        $text = $db->escape($query, true);
        $ticket = DB::table('posts');
        $ticket->like('post_title', $text)->or_like('post_content', $text);
        $ticket->left_join('post_department', 'departments', 'd_id');
        $get = $ticket->get();
        return $get;
    }
}

function query_search($query) {
    if (isset($query)) {
        if (!is_array($query))
            return htmlspecialchars(htmlentities($query));
    }
}

function get_tickets() {
    $ticket = DB::table('tickets');
    $ticket->left_join('department', 'departments', 'd_id');
    $ticket->left_join('user_id', 'users', 'id');
    $ticket->order_by('t_id', 'desc');
    $ticket->where('parent_id', 0);
    $get = $ticket->get();
    return $get;
}
function get_sms() {
    $sms = DB::table('sms');
    $sms->order_by('id', 'asc');
    $get = $sms->get();
    return $get;
}
function get_sms_status($sms_status){
	if(strlen($sms_status) > 2){
		$sms_status = 1;
	}
	switch ($sms_status){
		case 0:
		$sms_status = 'نام کاربری یا رمز عبور اشتباه می باشد';
		break;
		case 1:
		$sms_status = 'ارسال شده';
		break;
		case 2:
		$sms_status = 'اعتبار کافی نمی باشد';
		break;
		case 3:
		$sms_status = 'محدودیت در ارسال روزانه';
		break;
		case 4:
		$sms_status = 'محدودیت در حجم ارسال';
		break;
		case 5:
		$sms_status = 'شماره فرستنده معتبر نمی باشد';
		break;
		case 6:
		$sms_status = 'سامانه در حال بروزرسانی می باشد';
		break;
		case 7:
		$sms_status = 'متن حاوی کلمه فیلتر شده می باشد';
		break;
		case 9:
		$sms_status = 'ارسال از خطوط عمومی از طریق وب سرویس امکان پذیر نمی باشد';
		break;
		case 10:
		$sms_status = 'کاربر مورد نظر فعال نمی باشد';
		break;
		case 11:
		$sms_status = 'ارسال نشده';
		break;
		case 12:
		$sms_status = 'مدارک کاربر کامل نمی باشد';
		break;
		case 13:
		$sms_status = 'ارسال به همۀ کاربران';
		break;
		default:
		$sms_status = 'دلیل نامشخص';
		break;
	}
	return $sms_status;
}
function get_sms_content($content){
	$db = DB::db();
	$content = $db->escape($content, true);
	$content = trim(stripslashes(str_replace('\n'," ",$content)));
	$content = trim(stripslashes(str_replace('\r'," ",$content)));
	return $content;
}
function get_my_tickets() {
    $ticket = DB::table('tickets');
    $ticket->left_join('department', 'departments', 'd_id');
    $ticket->left_join('user_id', 'users', 'id');
    $ticket->order_by('t_id', 'desc');
    $ticket->where('parent_id', 0)->and_where('user_id', get_session('user_id'));
    $get = $ticket->get();
    return $get;
}

function get_byUser_tickets($id) {
    $db = DB::db();
    $ticket = DB::table('tickets');
    $ticket->left_join('department', 'departments', 'd_id');
    $ticket->left_join('user_id', 'users', 'id');
    $ticket->order_by('t_id', 'desc');
    $ticket->where('parent_id', 0)->and_where('user_id', $db->escape($id, true));
    $get = $ticket->get();
    return $get;
}

function get_stuff_tickets($d_array) {
    $ticket = DB::table('tickets');
    $ticket->left_join('department', 'departments', 'd_id');
    $ticket->left_join('user_id', 'users', 'id');
    $ticket->order_by('t_id', 'desc');
    $ticket->where('parent_id', 0)->and_in('department', $d_array);
    $get = $ticket->get();
    return $get;
}

function get_replies($id) {
    $db = DB::db();
    $ticket = DB::table('tickets');
    $ticket->left_join('department', 'departments', 'd_id');
    $ticket->left_join('user_id', 'users', 'id');
    $ticket->order_by('time', 'asc');
    $ticket->where('parent_id', $db->escape($id, true));
    $get = $ticket->get();
    return $get;
}

function get_user_byID($id) {
    $db = DB::db();
    $get = DB::table('users');
    $get->where('id', $db->escape($id, true));
    return $get->get_one();
}

function get_stuff_byID($id) {
    $db = DB::db();
    $get = DB::table('users');
    $get->left_join('id', 'stuff_relations', 'stuff_id');
    $get->where('id', $db->escape($id, true));
    return $get->get_one();
}

function user_data_byID($id, $value) {
    $db = DB::db();
    $get = DB::table('users');
    $get->where('id', $db->escape($id, true));
    $data = $get->get_one();
    return $data[$value];
}

function country_by_code($code) {
    $db = DB::db();
    $get = DB::table('countries');
    $get->where('country_code', $db->escape($code, true));
    $country = $get->get_one();
    return $country['country_name'];
}

function is_active_customer($id) {
    $db = DB::db();
    $get = DB::table('users');
    $get->where('id', $db->escape($id, true));
    $data = $get->get_one();
    if (!empty($data))
        if ($data['active'] == 1 and $data['is_admin'] == 0) {
            return TRUE;
        }
}
