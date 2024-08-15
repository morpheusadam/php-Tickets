<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

// SMTP Mailer Setting
# this for allow when your server not support 'mail();' function
define('Allow_SMTP', (get_option('SMTP_allow') == 'on') ? TRUE : FALSE); //-> to allow SMTP replace 'FALSE' with 'TRUE'
define('SMTP_Server', get_option('SMTP_server'));
define('SMTP_User', get_option('SMTP_user'));
define('SMTP_Password', get_option('SMTP_password'));
define('SMTP_Port', get_option('SMTP_port'));
define('SMTP_Secure', 'tls');

// Allow Show Landing Page
define('Allow_Landing', (get_theme_option('allow_landing') == 'on') ? TRUE : FALSE); //-> to hide or show landing page replace between [TRUE , FALSE]
//
// Social Login API
define('Facebook_APP_KEY', get_option('facebook_APP_KEY'));
define('Linkedin_APP_KEY', get_option('linkedin_APP_KEY'));
define('Google_Client_ID', get_option('google_Client_ID'));

define('Attach_Size', get_option('attach_file_size')); //->Uploading Attach File Size = 2.5 MB 
//->Uploading Attach File Types (add from this types into Attach_Type)
/*
  - application/zip
  - application/x-zip-compressed
  - multipart/x-zip
  - application/x-compressed'
  - image/jpeg
  - image/jpg
  - image/gif
  - image/png
  - text/plain
  - audio/mpeg
  - application/mp4
  - video/mp4
  - video/flv
  - video/x-flv
 */
define('Allow_Attach', (get_option('allow_attach_file') == 'on') ? TRUE : FALSE);


$get_types = get_option('attach_file_type');
$Attach_Type = '';
if ($get_types) {
    $types = @unserialize($get_types);
    if (is_array($types)) {
        foreach ($types as $type) {
            $Attach_Type.=$type . ',';
        }
    }
}
define('Attach_Type', $Attach_Type);

define('Allow_Delete_Replies', (get_option('allow_delete_replies') == 'on') ? TRUE : FALSE); //->Allow Customer Delete Reply On His Ticket

define('Allow_Admin_Delete', (get_option('allow_delete_tickets') == 'on') ? TRUE : FALSE); //->Allow Administrator Delete Ticket

define('Allow_Admin_Close', (get_custom_option('allow_admin_close_tickets') == 'on') ? TRUE : FALSE); //->Allow Administrator Close Ticket

define('Allow_Customer_Close', (get_custom_option('allow_customer_close_tickets') == 'on') ? TRUE : FALSE); //->Allow Customer Delete Ticket

define('Allow_Change_Department', (get_custom_option('allow_admin_change_department') == 'on') ? TRUE : FALSE); //->Allow Admin Change Department

define('Allow_Notifications', (get_custom_option('allow_notifications') == 'on') ? TRUE : FALSE); //->Allow Notifications

define('Allow_Delete_Notifications', (get_custom_option('allow_delete_notifications') == 'on') ? TRUE : FALSE); //->Allow Delete Notifications

define('Allow_Admin_Create', FALSE); //->Allow Administrator To Create Ticket

define('Site_URL', get_option('site_url')); //->Site URL

define('Site_Email', get_option('site_email')); //->Site Email

define('Activity_Email', get_option('activity_email')); //->When Customers Add New Ticks And Replies

define('Site_Name', get_option('site_name')); //->Site Title

define('Site_Description', get_option('site_description')); //->Your Site Description

$logo_text = '';
$logo = get_option('site_logo');
$logo = explode(' ', $logo);
if (count($logo) == 2) {
    $logo_text = '<em>' . $logo[0] . '</em> ' . $logo[1];
} elseif (count($logo) == 3) {
    $logo_text = '<em>' . $logo[0] . '</em> ' . $logo[1] . ' ' . $logo[2];
} elseif (count($logo) == 4) {
    $logo_text = '<em>' . $logo[0] . '</em> ' . $logo[1] . ' ' . $logo[2] . ' ' . $logo[3];
} else {
    $logo_text = get_option('site_logo');
}

define('Site_Logo', $logo_text); //-> Logo Text
//
//->Logo Description
define('Site_Logo_Description', get_option('site_description'));

//->Register Privacy Policy Content
$pr = str_replace('\n', "\n", get_option('privacy_policy'));


define('Privacy_Policy', nl2br($pr));


define('Theme_Name', 'AH-Tickets'); //->Activate Theme

define('Allow_Change_Language', TRUE); //Allow Change Language

define('Allow_Register', (get_option('allow_register') == 'on') ? TRUE : FALSE); //Allow Register

define('Allow_Login_Facebook', (get_option('allow_login_facebook') == 'on') ? TRUE : FALSE);
define('Allow_Login_Google', (get_option('allow_login_google') == 'on') ? TRUE : FALSE);
define('Allow_Login_Linkedin', (get_option('allow_login_linkedin') == 'on') ? TRUE : FALSE);
define('Allow_Send_SMS',(get_option('allow_sms') == 'on')? TRUE : FALSE);
define('Allow_SMS_Inform_User_Reply',(get_option('allow_sms_inform_reply') == 'on')? TRUE : FALSE);
define('Allow_SMS_Reg_Phone',(get_option('allow_sms_reg_phone') == 'on')? TRUE : FALSE);
define('Allow_SMS_Auth',(get_option('allow_sms_auth') == 'on')? TRUE : FALSE);

