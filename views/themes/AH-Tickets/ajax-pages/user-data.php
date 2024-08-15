<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */
global $Users;
$Users->is_login();
header('Content-type: application/json');
$user = DB::table('users');
$db = DB::db();
$id = $db->escape($_GET['u_id'], true);
$user->where('id', $id);
$user->left_join('location', 'countries', 'country_code');
$get = $user->get_one();
if (!empty($get)) {
    echo '{
    "id": ' . $get['id'] . ',
    "photo": "' . get_user_photo($get['photo']) . '",
    "name": "' . $get['name'] . '",
    "email": "' . $get['email'] . '",
    "gender": "' . __($get['gender']) . '",
    "country": "' . $get['country_name'] . '",
    "bio": "' . str_replace('\n', '<br>', $get['bio']) . '",
    "active": "' . $get['active'] . '",
	"phone": "'. $get['phone'] . '"
    }';
} else {
    echo '{}';
}