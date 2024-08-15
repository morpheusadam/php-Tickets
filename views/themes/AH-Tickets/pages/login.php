<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="welcome-login">
            <h2><?php _e('Login'); ?></h2>
            <form action="<?php echo Site_URL . '/login'; ?>" method="post">
                <?php
                global $Users;
                $Users->is_not_login();
                echo users_msg;
                ?>
                <div class="form-group">
                    <input type="hidden" name="do_login" value="true">
                    <input type="hidden" name="login_redirect" value="<?php echo get_session('login_redirect'); ?>">
                    <label for="email" class="control-label"><?php _e('Email'); ?></label>
                    <div class="has-feedback">
                        <input class="form-control input-lg input-padding" id="email" name="email" type="email" required>
                        <span class="fa fa-envelope-o form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label"><?php _e('Password'); ?></label>
                    <div class="has-feedback">
                        <input class="form-control input-lg input-padding" id="password" name="password" type="password" required>
                        <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox margin-0">
                        <label class="custom-option toggle" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                            <input id="remember" name="remember" value="true" type="checkbox">
                            <span class="button-checkbox"></span>
                        </label>
                        <label for="remember"><?php _e('Remember Me'); ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg"><?php _e('Login'); ?></button>
                    <div class="clear-15"></div>
                    <a class="btn btn-lg btn-link pull-right" href="<?php echo Site_URL . '/forgot-password'; ?>">
                        <?php _e('Forgot Your Password ?'); ?>
                    </a>
                    <?php if (Allow_Register == TRUE) { ?>
                        <a href="<?php echo Site_URL . '/register'; ?>" class="btn btn-lg btn-social btn-bitbucket">
                            <i class="fa fa-user-plus"></i>
                            <?php _e('Create New Account'); ?>
                        </a>
                    <?php } ?>
                </div>
            </form>
            <div class="social-login">
                <span class="or_text"><?php _e('OR'); ?></span>
                <div class="row">
                    <?php if (Allow_Login_Facebook == TRUE) { ?>
                        <div class="col-md-4">
                            <button onclick="facebook_login(this);" data-ajaxurl="<?php echo Site_URL . '/get-ajax/social-login'; ?>" class="btn btn-lg btn-social btn-facebook">
                                <i class="fa fa-facebook-square"></i>
                                <?php _e('Login'); ?>
                                <b class="fa fa-spin fa-refresh"></b>
                            </button>
                        </div>
                    <?php } ?>
                    <?php if (Allow_Login_Google == TRUE) { ?>
                        <div class="col-md-4">
                            <button onclick="google_login(this);" data-ajaxurl="<?php echo Site_URL . '/get-ajax/social-login'; ?>" class="btn btn-lg btn-social btn-google-plus">
                                <i class="fa fa-google-plus-square"></i>
                                <?php _e('Login'); ?>
                                <b class="fa fa-spin fa-refresh"></b>
                            </button>
                            <div class="g-signin2" data-onsuccess="onSignIn"></div>
                        </div>
                    <?php } ?>
                    <?php if (Allow_Login_Linkedin == TRUE) { ?>
                        <div class="col-md-4">
                            <button onclick="linkedin_login(this);" data-ajaxurl="<?php echo Site_URL . '/get-ajax/social-login'; ?>" class="btn btn-lg btn-social btn-linkedin">
                                <i class="fa fa-linkedin-square"></i>
                                <?php _e('Login'); ?>
                                <b class="fa fa-spin fa-refresh"></b>
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>