<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="welcome-login">
            <h2><?php _e('Forgot Password'); ?></h2>
            <form action="<?php echo Site_URL . '/forgot-password'; ?>" method="post">
                <?php
                global $Users;
                $Users->is_not_login();
                echo users_msg;
                ?>
                <div class="form-group">
                    <input type="hidden" name="do_forgot" value="true">
                    <div class="input-group">
                        <div class="has-feedback has-left-icon">
                            <input class="form-control input-lg input-padding" name="email" id="email" placeholder="<?php _e('Your Email'); ?>" type="email" required>
                            <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-lg btn-success"><?php _e('Send Email'); ?></button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>