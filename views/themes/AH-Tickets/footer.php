<?php
global $Users;
if ($Users->isset_login()) {
    ?>
    <div class="modal fade" id="edit-profile" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php _e('Edit Profile'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php
                    $get_user = get_user_byID(get_session('user_id'));
                    ?>
                    <form action="<?php echo Site_URL . '/ajax'; ?>" data-href="<?php echo Site_URL; ?>" method="post" data-toggle="validator">
                        <div class="show-alerts"></div>
                        <input type="hidden" name="edit-profile" id="edit-profile" value="true">
                        <div class="form-group">
                            <img src="<?php echo $get_user['photo']; ?>" alt="" class="modal_photo">
                            <button type="button" onclick="$(this).next().click();" class="btn btn-default"><i class="fa fa-upload"></i> <?php _e('Upload'); ?></button>
                            <input type="file" name="photo">
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label"><?php _e('Your Name'); ?></label>
                            <input class="form-control input-lg" id="name" name="name" type="text" required value="<?php echo $get_user['name']; ?>" data-error="<?php _e('this input required'); ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label"><?php _e('Email'); ?></label>
                            <input class="form-control input-lg" id="email" name="email" type="email" required value="<?php echo $get_user['email']; ?>" data-error="<?php _e('this input required'); ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                        <?php if (empty($get_user['social_id'])) { ?>
                            <div class="form-group">
                                <label for="password" class="control-label"><?php _e('Password'); ?></label>
                                <input class="form-control input-lg" id="password" name="password" type="password">
                                <p class="text-warning"><?php _e('leave it empty for not change password'); ?></p>
                            </div>
                        <?php } ?>
						<div class="form-group">
                                <label for="phone" class="control-label"><?php _e('Phone'); ?></label>
                                <input class="form-control input-lg" id="phone" name="phone" type="text">
                                <p class="text-warning"><?php _e('leave it empty for not change phone'); ?></p>
                            </div>
                        <div class="row">
                            <div class="col-xs-6 form-group">
                                <label for="country" class="control-label"><?php _e('Country'); ?></label>
                                <select class="custom-select" id="country" name="country">
                                    <?php
                                    $countries = get_countries();
                                    foreach ($countries as $country) {
                                        ?>
                                        <option <?php echo selected($country['country_code'], $get_user['location']); ?> value="<?php echo $country['country_code']; ?>"><?php echo $country['country_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-6 form-group">
                                <label for="gender" class="control-label"><?php _e('Gender'); ?></label>
                                <select class="custom-select" id="gender" name="gender">
                                    <option <?php echo selected('hidden', $get_user['gender']); ?> value="hidden"><?php _e('Hidden'); ?></option>
                                    <option <?php echo selected('male', $get_user['gender']); ?> value="male"><?php _e('Male'); ?></option>
                                    <option <?php echo selected('female', $get_user['gender']); ?> value="female"><?php _e('Female'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bio" class="control-label"><?php _e('Bio'); ?></label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo str_replace('\n', "\n", $get_user['bio']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success">
                                <span><?php _e('Update Profile'); ?></span>
                                <em class="form-loading"><i class="fa fa-refresh"></i></em>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Upload-Modal" tabindex="-1" data-button="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php _e('Upload File'); ?></h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo Site_URL . '/ajax'; ?>" method="post" enctype="">
                        <div class="show-alerts"></div>
                        <input type="hidden" name="ajax-upload-file" id="ajax-upload-file" value="true">
                        <label class="file-drag" data-title="<?php _e('Click to upload / Drag file her') ?>"><span></span><input type="file" name="file-name" id="file-name"></label>
                    </form>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="container-fluid" id="Footer">
    <div class="container">
        <p>
            <span class="text-left">
                <?php _e('All Right Reserved'); ?>
                <a href="<?php echo Site_URL; ?>" id="siteURL">&nbsp;<?php echo Site_Name; ?></a>
                <?php if (Debug) { ?>
                    &nbsp; - &nbsp; <?php _e('Powered By'); ?> <a href="http://www.rtl-theme.com/?p=28605" target="_blank">راستچین</a>
                <?php } ?>
            </span>
            <?php if (Allow_Change_Language) { ?>
                <select id="change_lang" class="form-control input-sm">
                    <?php
                    $languages = languages_list();
                    foreach ($languages as $key => $value) {
                        ?>
                        <option value="<?php _e($key); ?>" <?php echo selected($key, isset($_COOKIE['ah_tickets_lang']) ? $_COOKIE['ah_tickets_lang'] : 'ah_fa') ?>><?php _e($value); ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </p>
    </div>
</div>
</div>
<!--/Wrapper-->
<div class="loading_window">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<!--java scripts file-->
<script type="text/javascript" src="<?php theme_assets('js/less/less.js'); ?>"></script>
<script type="text/javascript" src="<?php theme_assets('js/bootstrap/bootstrap.min.js'); ?>"></script> 
<script type="text/javascript" src="<?php theme_assets('js/bootstrap/bootstrap-validator.js'); ?>"></script> 
<script type="text/javascript" src="<?php theme_assets('js/jquery/jquery.tipsy.js'); ?>"></script>
<script type="text/javascript" src="<?php theme_assets('js/datatables/dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php theme_assets('js/datatables/dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?php theme_assets('js/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript" src="<?php theme_assets('js/ajax-form/ajax_form.min.js'); ?>"></script>
<script type="text/javascript" src="<?php theme_assets('js/knob/jquery.knob.js'); ?>"></script>
<script type="text/javascript" src="<?php theme_assets('js/mini-colors/minicolors.min.js'); ?>"></script>
<?php if (is_page('login')) { ?>
    <script type="text/javascript" src="//platform.linkedin.com/in.js">
                                api_key:<?php echo Linkedin_APP_KEY; ?>
    </script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script type="text/javascript" src="<?php theme_assets('js/jquery/fb-api.js'); ?>"></script>
    <script type="text/javascript" src="<?php theme_assets('js/jquery/social-login.js'); ?>"></script>
    <script>
                                (function (d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) {
                                        return;
                                    }
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = "//connect.facebook.net/en_US/sdk.js";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));
    </script>
<?php } ?>
<script type="text/javascript" src="<?php theme_assets('js/strength/strength.js'); ?>"></script>
<script type="text/javascript" src="<?php theme_assets('js/jquery/jquery.custom.js'); ?>"></script>
<!--/java scripts file-->
</body>
</html>