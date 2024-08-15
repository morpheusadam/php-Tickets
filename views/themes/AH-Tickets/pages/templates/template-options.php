<div class="options-page">
    <div class="options-menu">
        <ul>
            <li class="active"><a href="#general-options" aria-controls="general-options" data-toggle="tab"><?php _e('General Setting'); ?></a></li>
            <li><a href="#tickets-options" aria-controls="social-options" data-toggle="tab"><?php _e('Tickets Setting'); ?></a></li>
            <li><a href="#login-options" aria-controls="social-options" data-toggle="tab"><?php _e('Login and Register'); ?></a></li>
            <li><a href="#social-options" aria-controls="social-options" data-toggle="tab"><?php _e('Social Links and API'); ?></a></li>
            <li><a href="#theme-options" aria-controls="theme-options" data-toggle="tab"><?php _e('Theme and Design'); ?></a></li>
            <li><a href="#home-options" aria-controls="home-options" data-toggle="tab"><?php _e('Home Page'); ?></a></li>
            <li><a href="#about-options" aria-controls="about-options" data-toggle="tab"><?php _e('About Page'); ?></a></li>
            <li><a href="#contact-options" aria-controls="contact-options" data-toggle="tab"><?php _e('Contact Page'); ?></a></li>
             <li><a href="#sms-options" aria-controls="sms-options" data-toggle="tab"><?php _e('SMS Setting'); ?></a></li>
        </ul>
    </div>
    <div class="options-content">
        <form action="<?php echo Site_URL . '/ajax'; ?>" method="post" id="options-form">
            <div class="show-alerts"></div>
            <input type="hidden" id="save_options" name="save_options" value="true">
            <div class="tab-content">
                <div class="tab-head text-right">
                    <button type="submit" class="btn btn-success"><?php _e('Save Options'); ?> <em class="form-loading"><i class="fa fa-refresh"></i></em></button>
                </div>
                <div class="tab-pane active" id="general-options">
                    <fieldset>
                        <legend><?php _e('Site Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_site_name"><?php _e('Site Name'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_site_name" name="option[site_name]" class="form-control" value="<?php echo get_option('site_name'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_site_logo"><?php _e('Site Logo'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_site_logo" name="option[site_logo]" class="form-control" value="<?php echo get_option('site_logo'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_site_url"><?php _e('Site URL'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_site_url" name="option[site_url]" disabled class="form-control" value="<?php echo get_option('site_url'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_script_version"><?php _e('Script Version'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_script_version" name="option[script_version]" disabled class="form-control" value="<?php echo get_option('script_version'); ?>">
                            </div>
                        </div>
                        <!--                        <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                                        <label class="control-label" for="option_site_language"><?php _e('Site Language'); ?></label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-8 col-sm-12">
                                                        <select id="option_site_language" name="option[site_language]" class="custom-select">
                        <?php
                        $languages = languages_list();
                        foreach ($languages as $key => $value) {
                            ?>
                                                                                                                                                        <option value="<?php _e($key); ?>" <?php echo selected($key, 'ah_' . Language) ?>><?php _e($value); ?></option>
                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>-->
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_site_description"><?php _e('Site Description'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <textarea id="option_site_description" name="option[site_description]" class="form-control" rows="3"><?php echo str_replace('\n', "\n", get_option('site_description')); ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_site_logo_img"><?php _e('Site Logo'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="input-upload">
                                    <input type="text" id="option_site_logo_img" name="option[theme][site_logo_img]" class="form-control" value="<?php echo get_theme_option('site_logo_img'); ?>" placeholder="url">
                                    <img src="<?php echo get_theme_option('site_logo_img'); ?>" alt="">
                                    <button type="button" data-toggle="modal" data-target="#Upload-Modal" class="btn btn-default upload-btn"><i class="fa fa-upload"></i> <?php _e('Upload') ?></button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend><?php _e('Contact Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_site_email"><?php _e('Site Email'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_site_email" name="option[site_email]" class="form-control" value="<?php echo get_option('site_email'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_site_phone"><?php _e('Site Phone'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_site_phone" name="option[site_phone]" class="form-control" value="<?php echo get_option('site_phone'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_activity_email"><?php _e('Activity Email'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_activity_email" name="option[activity_email]" class="form-control" value="<?php echo get_option('activity_email'); ?>">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend><?php _e('SMTP Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_SMTP_allow"><?php _e('Allow SMTP'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_SMTP_allow" name="option[SMTP_allow]" value="<?php echo (get_option('SMTP_allow')) ? get_option('SMTP_allow') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_SMTP_server"><?php _e('SMTP Server'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_SMTP_server" name="option[SMTP_server]" class="form-control" value="<?php echo get_option('SMTP_server'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_SMTP_user"><?php _e('SMTP User'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_SMTP_user" name="option[SMTP_user]" class="form-control" value="<?php echo get_option('SMTP_user'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_SMTP_password"><?php _e('SMTP Password'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="password" id="option_SMTP_password" name="option[SMTP_password]" class="form-control" value="<?php echo get_option('SMTP_password'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_SMTP_port"><?php _e('SMTP Port'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_SMTP_port" name="option[SMTP_port]" class="form-control" value="<?php echo get_option('SMTP_port'); ?>">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="tickets-options">
                    <fieldset>
                        <legend><?php _e('Tickets Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_delete_replies"><?php _e('Allow Delete Replies'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_delete_replies" name="option[allow_delete_replies]" value="<?php echo (get_option('allow_delete_replies')) ? get_option('allow_delete_replies') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_admin_close_tickets"><?php _e('Allow Admin Close Tickets'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_admin_close_tickets" name="option[custom_options][allow_admin_close_tickets]" value="<?php echo (get_custom_option('allow_admin_close_tickets')) ? get_custom_option('allow_admin_close_tickets') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_customer_close_tickets"><?php _e('Allow Customer Close Tickets'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_customer_close_tickets" name="option[custom_options][allow_customer_close_tickets]" value="<?php echo (get_custom_option('allow_customer_close_tickets')) ? get_custom_option('allow_customer_close_tickets') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_admin_change_department"><?php _e('Allow Change Department'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_admin_change_department" name="option[custom_options][allow_admin_change_department]" value="<?php echo (get_custom_option('allow_admin_change_department')) ? get_custom_option('allow_admin_change_department') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_attach_file"><?php _e('Allow Attach File'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_attach_file" name="option[allow_attach_file]" value="<?php echo (get_option('allow_attach_file')) ? get_option('allow_attach_file') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_attach_file_type"><?php _e('Attach File Type'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <?php $types = array("jpg", "jpeg", "png", "txt", "html", "css", "js", "json", "xml", "pdf", "psd", "ai", "doc", "rtf", "ppt", "odt", "ods", "zip", "rar"); ?>                                    
                                <div class="row">
                                    <?php
                                    $checked = '';
                                    $get_types = @unserialize(get_option('attach_file_type'));
                                    foreach ($types as $type) {
                                        if (is_array($get_types)) {
                                            if (in_array($type, $get_types))
                                                $checked = 'checked';
                                            else
                                                $checked = '';
                                        }
                                        ?>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label class="custom-option button">
                                                    <input type="checkbox" <?php echo $checked; ?> id="<?php echo 'option_' . $type; ?>" name="option[attach_file_type][]" value="<?php echo $type; ?>">
                                                    <span class="button-checkbox"></span>
                                                </label>
                                                <label for="<?php echo 'option_' . $type; ?>" class="text-uppercase"><?php echo $type; ?></label>
                                            </div>
                                        </div>
                                    <?php } ?>    
                                </div>
<!--                                <input type="text" disabled id="option_attach_file_type" name="option[attach_file_type]" class="form-control" value="<?php echo get_option('attach_file_type'); ?>">-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_attach_file_size"><?php _e('Attach File Size'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <select id="option_attach_file_size" name="option[attach_file_size]" class="custom-select">
                                    <?php for ($x = 1; $x <= 45; $x++) { ?>
                                        <option value="<?php echo(1048576 * $x); ?>" <?php echo selected((1048576 * $x), get_option('attach_file_size')) ?>><?php echo "$x " . __(' MB'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend><?php _e('Notifications Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_notifications"><?php _e('Allow Notifications'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_notifications" name="option[custom_options][allow_notifications]" value="<?php echo (get_custom_option('allow_notifications')) ? get_custom_option('allow_notifications') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_delete_notifications"><?php _e('Allow Delete Notifications'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_delete_notifications" name="option[custom_options][allow_delete_notifications]" value="<?php echo (get_custom_option('allow_delete_notifications')) ? get_custom_option('allow_delete_notifications') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_delete_notifications_time"><?php _e('Delete Notifications Time'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <select id="option_delete_notifications_time" name="option[custom_options][delete_notifications_time]" class="custom-select">
                                    <?php for ($x = 1; $x <= 10; $x++) { ?>
                                        <option value="<?php echo(86400 * $x); ?>" <?php echo selected((86400 * $x), get_custom_option('delete_notifications_time')) ?>><?php echo "$x " . __('Days'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="login-options">
                    <fieldset>
                        <legend><?php _e('Allow Social Login'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_login_facebook"><?php _e('Facebbok'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_login_facebook" name="option[allow_login_facebook]" value="<?php echo (get_option('allow_login_facebook')) ? get_option('allow_login_facebook') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_login_google"><?php _e('Google'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_login_google" name="option[allow_login_google]" value="<?php echo (get_option('allow_login_google')) ? get_option('allow_login_google') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_login_linkedin"><?php _e('Linkedin'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_login_linkedin" name="option[allow_login_linkedin]" value="<?php echo (get_option('allow_login_linkedin')) ? get_option('allow_login_linkedin') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend><?php _e('Register Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_register"><?php _e('Allow Register'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_register" name="option[allow_register]" value="<?php echo (get_option('allow_register')) ? get_option('allow_register') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_privacy_policy"><?php _e('Privacy Policy'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <textarea id="option_privacy_policy" name="option[privacy_policy]" class="form-control" rows="6"><?php echo str_replace('\n', "\n", get_option('privacy_policy')); ?></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="social-options">
                    <fieldset>
                        <legend><?php _e('Social Links'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_facebook_url"><?php _e('Facebook URL'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_facebook_url" name="option[theme][facebook_url]" class="form-control" value="<?php echo get_theme_option('facebook_url'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_twitter_url"><?php _e('Twitter URL'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_twitter_url" name="option[theme][twitter_url]" class="form-control" value="<?php echo get_theme_option('twitter_url'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_linkedin_url"><?php _e('Linkedin URL'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_linkedin_url" name="option[theme][linkedin_url]" class="form-control" value="<?php echo get_theme_option('linkedin_url'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_google_url"><?php _e('Google URL'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_google_url" name="option[theme][google_url]" class="form-control" value="<?php echo get_theme_option('google_url'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_youtube_url"><?php _e('Youtube URL'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_youtube_url" name="option[theme][youtube_url]" class="form-control" value="<?php echo get_theme_option('youtube_url'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_instagram_url"><?php _e('Instagram URL'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_instagram_url" name="option[theme][instagram_url]" class="form-control" value="<?php echo get_theme_option('instagram_url'); ?>">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend><?php _e('Social API'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_facebook_APP_KEY"><?php _e('Facebook APP Key'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_facebook_APP_KEY" name="option[facebook_APP_KEY]" class="form-control" value="<?php echo get_option('facebook_APP_KEY'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_linkedin_APP_KEY"><?php _e('Linkedin APP Key'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_linkedin_APP_KEY" name="option[linkedin_APP_KEY]" class="form-control" value="<?php echo get_option('linkedin_APP_KEY'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_google_Client_ID"><?php _e('Google Client ID'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_google_Client_ID" name="option[google_Client_ID]" class="form-control" value="<?php echo get_option('google_Client_ID'); ?>">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend><?php _e('Subscribe Form Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_MailChimp_API_KEY"><?php _e('MailChimp API Key'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_MailChimp_API_KEY" name="option[MailChimp_API_KEY]" class="form-control" value="<?php echo get_option('MailChimp_API_KEY'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_MailChimp_List_ID"><?php _e('MailChimp List ID'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_MailChimp_List_ID" name="option[MailChimp_List_ID]" class="form-control" value="<?php echo get_option('MailChimp_List_ID'); ?>">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="theme-options">
                    <fieldset>
                        <legend><?php _e('Theme Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_theme_allow_landing"><?php _e('Allow Landing Page'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_theme_allow_landing" name="option[theme][allow_landing]" value="<?php echo (get_theme_option('allow_landing')) ? get_theme_option('allow_landing') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_theme_is_boxed"><?php _e('Boxed Theme'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_theme_is_boxed" name="option[theme][is_boxed]" value="<?php echo (get_theme_option('is_boxed')) ? get_theme_option('is_boxed') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_theme_color"><?php _e('Theme Color'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_theme_color" name="option[theme][color]" class="form-control minicolors" value="<?php echo get_theme_option('color'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_dashboard_background"><?php _e('Dashboard Background'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="input-upload">
                                    <input type="text" id="option_dashboard_background" name="option[theme][dashboard_background]" class="form-control" value="<?php echo get_theme_option('dashboard_background'); ?>" placeholder="url">
                                    <img src="<?php echo get_theme_option('dashboard_background'); ?>" alt="">
                                    <button type="button" data-toggle="modal" data-target="#Upload-Modal" class="btn btn-default upload-btn"><i class="fa fa-upload"></i> <?php _e('Upload') ?></button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="home-options">
                    <div class="clear-15"></div>
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a href="#service-section" data-toggle="tab"><?php _e('Services Section'); ?></a></li>
                        <li><a href="#team-section" data-toggle="tab"><?php _e('Team Section'); ?></a></li>
                    </ul>
                    <div class="tab-content padding-0">
                        <div class="tab-pane active" id="service-section">
                            <fieldset>
                                <legend><?php _e('What We Have'); ?></legend>
                                <?php for ($x = 1; $x <= 3; $x++) { ?>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <label class="control-label" for="option_service_icon_<?php echo $x; ?>"><?php echo __('Block Icon') . " [$x]"; ?></label>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-12">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-7 col-sm-7">
                                                    <input type="text" id="option_service_icon_<?php echo $x; ?>" name="option[theme][service_icon_<?php echo $x; ?>]" class="form-control" value="<?php echo get_theme_option('service_icon_' . $x); ?>" placeholder="fa-icon-name">
                                                </div>
                                                <div class="col-lg-1 col-md-1 col-sm-1">
                                                    <label class="control-label"><i class="fa fa-2x <?php echo get_theme_option('service_icon_' . $x); ?>"></i></label>
                                                </div>
                                                <div class=" col-lg-3 col-md-4 col-sm-4">
                                                    <a href="http://fontawesome.io/icons/#icons" target="_blank" class="btn btn-block btn-bitbucket"><?php _e('Chose Icon'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <label class="control-label" for="option_service_title_<?php echo $x; ?>"><?php echo __('Block Title') . " [$x]"; ?></label>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-12">
                                            <input type="text" id="option_service_title_<?php echo $x; ?>" name="option[theme][service_title_<?php echo $x; ?>]" class="form-control" value="<?php echo get_theme_option('service_title_' . $x); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <label class="control-label" for="option_service_description_<?php echo $x; ?>"><?php echo __('Block Description') . " [$x]"; ?></label>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-12">
                                            <textarea id="option_service_description_<?php echo $x; ?>" name="option[theme][service_description_<?php echo $x; ?>]" class="form-control" rows="5"><?php echo get_theme_option('service_description_' . $x); ?></textarea>
                                        </div>
                                    </div>
                                    <?php if ($x < 3) echo '<hr>'; ?>
                                <?php } ?>
                            </fieldset>
                        </div>
                        <div class="tab-pane" id="team-section">
                            <fieldset>
                                <legend><?php _e('Our Support Team'); ?></legend>
                                <?php for ($x = 1; $x <= 4; $x++) { ?>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <label class="control-label" for="option_team_name_<?php echo $x; ?>"><?php echo __('Team Name') . " [$x]"; ?></label>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-12">
                                            <input type="text" id="option_team_name_<?php echo $x; ?>" name="option[theme][team_name_<?php echo $x; ?>]" class="form-control" value="<?php echo get_theme_option('team_name_' . $x); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <label class="control-label" for="option_team_job_<?php echo $x; ?>"><?php echo __('Job Title') . " [$x]"; ?></label>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-12">
                                            <input type="text" id="option_team_job_<?php echo $x; ?>" name="option[theme][team_job_<?php echo $x; ?>]" class="form-control" value="<?php echo get_theme_option('team_job_' . $x); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <label class="control-label" for="option_team_about_<?php echo $x; ?>"><?php echo __('Team About') . " [$x]"; ?></label>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-12">
                                            <textarea id="option_team_about_<?php echo $x; ?>" name="option[theme][team_about_<?php echo $x; ?>]" class="form-control" rows="5"><?php echo get_theme_option('team_about_' . $x); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <label class="control-label" for="option_team_photo_<?php echo $x; ?>"><?php echo __('Team Photo') . " [$x]"; ?></label>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-12">
                                            <div class="input-upload">
                                                <input type="text" id="option_team_photo_<?php echo $x; ?>" name="option[theme][team_photo_<?php echo $x; ?>]" class="form-control" value="<?php echo get_theme_option('team_photo_' . $x); ?>" placeholder="url">
                                                <img src="<?php echo get_theme_option('team_photo_' . $x); ?>" alt="">
                                                <button type="button" data-toggle="modal" data-target="#Upload-Modal" class="btn btn-default upload-btn"><i class="fa fa-upload"></i> <?php _e('Upload') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($x < 4) echo '<hr>'; ?>
                                <?php } ?>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="about-options">
                    <fieldset>
                        <legend><?php _e('About Page Content'); ?></legend>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea id="option_about_content" name="option[theme][about_content]" class="form-control options_textarea" rows="6"><?php echo get_theme_option('about_content'); ?></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="contact-options">
                    <fieldset>
                        <legend><?php _e('Contact Page'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_map"><?php _e('Allow Map'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_map" name="option[allow_map]" value="<?php echo (get_option('allow_map')) ? get_option('allow_map') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_map_latitude"><?php echo __('Map Latitude'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_map_latitude" name="option[map_latitude]" class="form-control" value="<?php echo get_option('map_latitude'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_map_longitude"><?php echo __('Map Longitude'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_map_longitude" name="option[map_longitude]" class="form-control" value="<?php echo get_option('map_longitude'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_contact_email"><?php echo __('Contact Email'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_contact_email" name="option[contact_email]" class="form-control" value="<?php echo get_option('contact_email'); ?>">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="sms-options">
                	<fieldset>
                    	<legend><?php _e('SMS Setting'); ?></legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_sms"><?php _e('Allow SMS'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_sms" name="option[allow_sms]" value="<?php echo (get_option('allow_sms')) ? get_option('allow_sms') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_allow_sms"><?php _e('Allow Inform User Ticket Reply'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="option_allow_sms_inform_reply" name="option[allow_sms_inform_reply]" value="<?php echo (get_option('allow_sms_inform_reply')) ? get_option('allow_sms_inform_reply') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="allow_sms_auth"><?php _e('Allow Authenticate By SMS'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="allow_sms_auth" name="option[allow_sms_auth]" value="<?php echo (get_option('allow_sms_auth')) ? get_option('allow_sms_auth') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_sms_username"><?php _e('SMS Username'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_sms_username" name="option[sms_username]" class="form-control" value="<?php echo get_option('sms_username'); ?>">
                            </div>
                        </div>  
                        <div class="row"> 
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_sms_password"><?php _e('SMS Password'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_sms_password" name="option[sms_password]" class="form-control" value="<?php echo get_option('sms_password'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_sms_number"><?php _e('SMS Number'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_sms_number" name="option[sms_number]" class="form-control" value="<?php echo get_option('sms_number'); ?>">
                            </div>
                    	</div>
                         <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="allow_sms_reg_phone"><?php _e('Allow Register Phones In WS'); ?></label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="checkbox margin-0">
                                    <label class="custom-option toggle custom" data-off="<?php _e('OFF'); ?>" data-on="<?php _e('ON'); ?>">
                                        <input type="hidden" id="allow_sms_reg_phone" name="option[allow_sms_reg_phone]" value="<?php echo (get_option('allow_sms_reg_phone')) ? get_option('allow_sms_reg_phone') : 'off'; ?>">
                                        <span class="button-checkbox"></span>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <label class="control-label" for="option_sms_groupIds"><?php _e('SMS GroupIds'); ?></label>
                            </div>  
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <input type="text" id="option_sms_groupIds" class="form-control" name="option[sms_groupIds]" value="<?php echo get_option('sms_groupIds'); ?>">
                            </div>
                    	</div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
</div>