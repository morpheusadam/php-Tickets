<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="welcome-login">
            <h2><?php _e('Register'); ?></h2>
            <?php if (Allow_Register == TRUE) { ?>
                <form action="<?php echo Site_URL . '/register'; ?>" method="post" id="registerForm">
                    <?php
                    global $Users;
                    $Users->is_not_login();
                    $users_msg = users_msg;
                    if (!empty($users_msg)) {
                        echo $users_msg;
                    }
                    ?>
                    <input type="hidden" name="do_register" value="true">
                    <input type="hidden" name="country" value="IR" data-raw-value="IR">
                    <div class="form-group">
                        <label for="name" class="control-label"><?php _e('Your Name'); ?></label>
                        <div class="has-feedback">
                            <input class="form-control input-lg input-padding" id="name" name="name" type="text" required>
                            <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label"><?php _e('Email'); ?></label>
                        <div class="has-feedback">
                            <input class="form-control input-lg input-padding" id="email" name="email" type="email" required>
                            <span class="fa fa-envelope-o form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label"><?php _e('Password'); ?></label>
                        <div class="has-feedback">
                            <input class="form-control input-lg input-padding" id="regPassword" name="password" type="password" required>
                            <span class="fa fa-lock form-control-feedback" aria-hidden="true" style="width: 46px;height: 46px;line-height: 46px;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-sm-6 form-group"> 
                            <div class="form-group">
                        <label for="phone" class="control-label"><?php _e('Phone'); ?></label>
                        <div class="has-feedback">
                            <input class="form-control input-lg input-padding" id="phone" name="phone" type="text" required>
                            <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                        </div>
                        <div class="col-md-5 col-sm-6 form-group">
                            <label for="gender" class="control-label"><?php _e('Gender'); ?></label>
                            <select class="custom-select" id="gender" name="gender">
                                <option value="hidden"><?php _e('Hidden'); ?></option>
                                <option value="male"><?php _e('Male'); ?></option>
                                <option value="female"><?php _e('Female'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label class="custom-option toggle" data-off="<?php _e('No'); ?>" data-on="<?php _e('Yes'); ?>">
                                <input id="agree" name="agree" value="true" type="checkbox">
                                <span class="button-checkbox"></span>
                            </label>
                            <label for="agree"><?php _e('Agree For Privacy Policy'); ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg"><?php _e('Create Account'); ?></button>
                        <a class="btn btn-lg btn-link" href="privacy" data-toggle="modal" data-target="#Show-Privacy">
                            <?php _e('Privacy Policy'); ?>
                        </a>
                    </div>
                </form>
                <?php
            } else {
                echo '<div style="padding:30px 30px 10px 30px;">' . alert_message(__('Warning'), __('Register Disabled'), 'warning') . '</div>';
            }
            ?>
        </div>
    </div>
</div>
<div class="modal fade" id="Show-Privacy" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-info"></i> <?php _e('Privacy Policy'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo Privacy_Policy; ?>
            </div>
        </div>
    </div>
</div>