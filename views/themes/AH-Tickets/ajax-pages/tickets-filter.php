<?php
/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */
global $Users;
$Users->is_login();
?>
<label style="margin: 0px 15px;">
    <select class="tickets-filter form-control input-sm">
        <option value=""><?php _e('all'); ?></option>
        <option value="<?php _e('open'); ?>"><?php _e('open'); ?></option>
        <option value="<?php _e('closed'); ?>"><?php _e('closed'); ?></option>
        <option value="<?php _e('answered'); ?>"><?php _e('answered'); ?></option>
        <option value="<?php _e('unread'); ?>"><?php _e('unread'); ?></option>
        <option value="<?php _e('low'); ?>"><?php _e('low'); ?></option>
        <option value="<?php _e('medium'); ?>"><?php _e('medium'); ?></option>
        <option value="<?php _e('high'); ?>"><?php _e('high'); ?></option>
    </select>
</label>