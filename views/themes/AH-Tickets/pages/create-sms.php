<?php
global $Users;
global $httpRequest;
?>
<div class="row">
    <div class="col-md-12">
        <div class="ah-panel">
            <h2 class="has-menu">
                <?php _e('New SMS'); ?>
                <?php
                if ($httpRequest->http_isset('user-id', 'get') and $httpRequest->http_not_empty('user-id', 'get') and $httpRequest->http_is_int('user-id', 'get')) {
                    if (is_active_customer($httpRequest->http_get('user-id'))) {
                        echo '| <small> ' . user_data_byID($httpRequest->http_get('user-id'), 'name') . '</small>';
                    }
                }
                ?>
                <?php include (dirname(__file__) . '/menu-links.php'); ?>
            </h2>
            <div class="ah-panel-body">
                <?php
				if(Allow_Send_SMS == FALSE) {
				  echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('creating sms is disabled') . '
                                    </div>';
                            return;
			  }
                $Users->is_login();
                echo users_msg;
                if ($Users->is_admin()) {
                    if ($httpRequest->http_isset('user-id', 'get') and $httpRequest->http_not_empty('user-id', 'get') and $httpRequest->http_is_int('user-id', 'get')) {
                        if (is_active_customer($httpRequest->http_get('user-id'))) {
                            theme_template('user-send-sms');
                            return;
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('Not Found') . '
                                    </div>';
                            return;
                        }
                    } 
                }
				else {
                        echo '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Warning') . ' : </strong> ' . __('you not has access to create sms') . '
                                    </div>';
                        return;
                    }
                ?>
                <form action="<?php echo Site_URL . '/ajax'; ?>" method="post" id="create-ticket" data-toggle="_validator">
                    <div class="show-alerts"></div>
                    <input type="hidden" name="send_sms" id="tickets_create" value="true">
                    <input type="hidden" name="tickets_redirect" id="tickets_redirect" value="<?php echo Site_URL . '/sms/view/' . get_last_sms_id('sms'); ?>">
                        <div class="row">
                        <div class="alert alert-warning"><?php _e('Please check if your SMS will be sent by sending a single-user SMS') ?></div>
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
            </div>
        </div>
    </div>
</div>
