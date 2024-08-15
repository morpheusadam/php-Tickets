<?php
global $httpRequest;
?>
<form action="<?php echo Site_URL . '/ajax'; ?>" method="post" id="create-ticket" data-toggle="validator">
    <div class="show-alerts"></div>
    <input type="hidden" name="send_sms" id="sms_create" value="<?php echo $httpRequest->http_get('user-id'); ?>">
    <input type="hidden" name="sms_is_user_create" id="sms_is_user_create" value="<?php echo user_data_byID($httpRequest->http_get('user-id'), 'name'); ?>">
    <input type="hidden" name="sms_redirect" id="sms_redirect" value="<?php echo Site_URL . '/#sms'; ?>">
    <div class="row">
        <div class="col-sm-6 form-group">
            <label for="user-name" class="control-label"><?php _e('Customer'); ?></label>
            <input class="form-control input-lg" id="user-name" name="user-name" type="text" disabled value="<?php echo user_data_byID($httpRequest->http_get('user-id'), 'name'); ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label for="subject" class="control-label"><?php _e('Subject'); ?></label>
            <input class="form-control input-lg" id="subject" name="subject" type="text" required data-error="<?php _e('empty subject'); ?>">
            <div class="help-block with-errors"></div>
        </div>
    </div>
     
    <div class="form-group">
        <label for="content" class="control-label"><?php _e('Content'); ?></label>
        <textarea rows="5" class="form-control input-lg" id="content" name="content" data-error="<?php _e('empty sms content'); ?>"></textarea>
    </div>  
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg">
            <span><?php _e('Send SMS'); ?></span>
            <em><i class="fa fa-refresh"></i></em>
        </button>
    </div>
</form>