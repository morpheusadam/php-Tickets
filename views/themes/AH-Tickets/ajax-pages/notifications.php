<?php
/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

global $Users;
global $httpRequest;
if (!$Users->isset_login())
    exit('Error');

$notifications = get_notification_bUser(get_session('user_id'), 'all');

if ($httpRequest->http_isset('get_notification_count', 'post')) {
    echo count(get_notification_bUser(get_session('user_id'), 'unread'));
}

if ($httpRequest->http_isset('get_notification_list', 'post')) {
    if ($notifications) {
        foreach ($notifications as $value) {
            $data = unserialize($value['n_data']);
            ?>
            <li data-href="<?php echo $data['link']; ?>" data-id="<?php echo $value['n_id']; ?>" <?php echo($value['n_user_read'] == 0) ? 'class="unread"' : ''; ?>>
                <img src="<?php echo get_user_photo_byID($value['n_user_from']); ?>" alt=""><b><?php echo $data['user_name']; ?></b> : <?php echo __($data['text']) . ' <em>' . time_ago($value['n_time']) . '</em>'; ?>
                <?php if ($value['n_user_read'] == 0) { ?>
                    <label class="unread"><?php _e('unread'); ?></label>
                <?php } ?>
            </li>
            <?php
        }
    } else {
        echo '<li class="text-center">' . __('No Data Found') . '</li>';
    }
}

if ($httpRequest->http_isset('read_notification', 'post')) {
    $id = $httpRequest->http_post('n_id');
    update_notification_read($id);
}

if ($httpRequest->http_isset('browser_notification_list', 'get')) {
    $data = [];
    $x = 0;
    $notifications = get_browser_notification_bUser(get_session('user_id'), 'unread');
    if ($notifications) {
        foreach ($notifications as $value) {
            $x++;
            $data[$x]['n_id'] = $value['n_id'];
            $data[$x]['n_user_from'] = $value['n_user_from'];
            $data[$x]['n_user_to'] = $value['n_user_to'];
            $data[$x]['n_type'] = $value['n_type'];
            $data[$x]['n_browser_read'] = $value['n_browser_read'];
            $data[$x]['n_user_read'] = $value['n_user_read'];
            $data[$x]['n_time'] = $value['n_time'];
            $data[$x]['n_data'] = unserialize($value['n_data']);
            $data[$x]['n_data']['photo'] = get_user_photo_byID($value['n_user_from']);
        }
        echo json_encode($data);
    }
}

if ($httpRequest->http_isset('read_boewser_notification', 'post')) {
    browser_notification_read($httpRequest->http_post('n_id'));
}

if (Allow_Delete_Notifications)
    delete_notification_read(get_custom_option('delete_notifications_time'));
