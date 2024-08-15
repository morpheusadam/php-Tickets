<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" lang="<?php echo site_lang(); ?>"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="<?php echo site_lang(); ?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="<?php echo site_lang(); ?>"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="description" content="<?php echo Site_Description; ?>">
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="<?php echo Google_Client_ID ?>.apps.googleusercontent.com">
        <!--mobile-meta-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- FontLicense-meta-->
        <meta name="fontiran.com:license" content="WT3TY">
        <title><?php echo siteTitle(); ?> </title>
        <!--main-style-->
        <link rel="stylesheet" href="<?php theme_assets('css/style.css'); ?>" type="text/css">
        <link rel="stylesheet/less" href="<?php echo Site_URL . '/ajax/main-style'; ?>" type="text/css">
        <!--responsive-style-->
        <link rel="stylesheet/less" href="<?php theme_assets('css/responsive.less'); ?>" type="text/css">
        <?php if (site_lang() == 'ar' or site_lang() == 'fa') { ?>
            <link rel="stylesheet" href="<?php theme_assets('css/bootstrap/bootstrap.rtl.css'); ?>" type="text/css">
            <link rel="stylesheet/less" href="<?php theme_assets('css/rtl.less'); ?>" type="text/css">
        <?php } ?>
        <!--site-icon-->
        <link rel="shortcut icon" href="<?php theme_assets('images/favicon.ico'); ?>" type="image/x-icon">
        <!--jQuery-->
        <script type="text/javascript" src="<?php theme_assets('js/jquery/jquery.js'); ?>"></script>
    </head>
    <body
        data-page="home"
        data-site-name="<?php echo Site_Name; ?>"
        data-url="<?php echo Site_URL; ?>"
        data-facebook-app-key="<?php echo Facebook_APP_KEY; ?>"
        data-allow-notifications="<?php echo Allow_Notifications; ?>"
        <?php echo ( get_theme_option('is_boxed') == 'on') ? 'class="boxed"' : ''; ?>>
        <div id="Wrapper" <?php echo ( get_theme_option('is_boxed') == 'on') ? 'class="boxed"' : ''; ?>>
            <div id="Main">
                <div class="main-header">
                    <div class="nav-top hidden-sm hidden-xs">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-6">
                                    <span><i class="fa fa-mobile"></i> <?php echo get_option('site_phone'); ?></span>
                                    <span><i class="fa fa-envelope-o"></i> <?php echo get_option('site_email'); ?></span>
                                </div>
                                <div class="col-xs-6">
                                    <?php if (get_theme_option('instagram_url')) { ?>
                                        <a href="<?php echo get_theme_option('instagram_url'); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                                    <?php } ?>
                                    <?php if (get_theme_option('youtube_url')) { ?>
                                        <a href="<?php echo get_theme_option('youtube_url'); ?>" target="_blank"><i class="fa fa-youtube"></i></a>
                                    <?php } ?>
                                    <?php if (get_theme_option('linkedin_url')) { ?>
                                        <a href="<?php echo get_theme_option('linkedin_url'); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                                    <?php } ?>
                                    <?php if (get_theme_option('twitter_url')) { ?>
                                        <a href="<?php echo get_theme_option('twitter_url'); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                    <?php } ?>
                                    <?php if (get_theme_option('google_url')) { ?>
                                        <a href="<?php echo get_theme_option('google_url'); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                                    <?php } ?>
                                    <?php if (get_theme_option('facebook_url')) { ?>
                                        <a href="<?php echo get_theme_option('facebook_url'); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-menu">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="logo">
                                        <?php if (get_theme_option('site_logo_img') != '') { ?>
                                            <img src="<?php echo get_theme_option('site_logo_img'); ?>" alt="<?php echo Site_Name; ?>">
                                        <?php } else { ?>
                                            <i class="fa fa-cog"></i>
                                            <?php echo Site_Logo; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="menu hidden-xs hidden-sm">
                                        <?php
                                        // active pages in main
                                        $d_active = '';
                                        $kn_active = '';
                                        $ab_active = '';
                                        $co_active = '';
                                        $home_active = '';
                                        if (isset($_GET['sub_page'])) {
                                            if (isset($_GET['sub_page'])) {
                                                if ($_GET['sub_page'] == 'department') {
                                                    $d_active = 'class="active"';
                                                } else if ($_GET['sub_page'] == 'knowledge') {
                                                    $kn_active = 'class="active"';
                                                } else if ($_GET['sub_page'] == 'about') {
                                                    $ab_active = 'class="active"';
                                                } else if ($_GET['sub_page'] == 'contact') {
                                                    $co_active = 'class="active"';
                                                }
                                            } else {
                                                $home_active = 'class="active"';
                                            }
                                        } else {
                                            $home_active = 'class="active"';
                                        }
                                        ?>
                                        <ul>
                                            <li <?php echo $home_active; ?>><a href="<?php echo Site_URL . '/main'; ?>"><?php _e('Home'); ?></a></li>
                                            <li <?php echo $kn_active; ?>><a href="<?php echo Site_URL . '/main/knowledge'; ?>"><?php _e('Knowledge Base'); ?></a></li>
                                            <li <?php echo $ab_active ?>><a href="<?php echo Site_URL . '/main/about'; ?>"><?php _e('About'); ?></a></li>
                                            <li <?php echo $co_active ?>><a href="<?php echo Site_URL . '/main/contact'; ?>"><?php _e('Contact US'); ?></a></li>
                                        </ul>
                                        <?php
                                        global $Users;
                                        if ($Users->isset_login()) {
                                            ?>
                                            <div class="dropdown">
                                                <a data-toggle="dropdown" class="btn btn-default">
                                                    <img src="<?php echo get_user_photo_byID(get_session('user_id')); ?>" alt="<?php echo get_session('name'); ?>">
                                                    <span><?php echo get_session('name'); ?></span>
                                                    <i class="fa fa-sort-down"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <?php
                                                    global $Users;
                                                    if ($Users->is_admin() or $Users->is_stuff()) {
                                                        ?>
                                                        <li><a href="<?php echo Site_URL; ?>"><?php _e('Dashboard'); ?></a></li>
                                                    <?php } else { ?>
                                                        <li><a href="<?php echo Site_URL; ?>"><?php _e('Your Tickets'); ?></a></li>
                                                        <li><a href="<?php echo Site_URL . '/tickets/create'; ?>"><?php _e('Create Ticket'); ?></a></li>
                                                    <?php } ?>
                                                    <li><a href="#edit-profile" data-toggle="modal" data-target="#edit-profile"><?php _e('Edit Profile'); ?></a></li>
                                                    <li><a href="<?php echo Site_URL . '/logout'; ?>"><?php _e('Logout'); ?></a></li>
                                                </ul>
                                            </div>
                                            <?php if (Allow_Notifications) { ?>
                                                <div class="dropdown">
                                                    <a data-toggle="dropdown" class="btn notification">
                                                        <i class="fa fa-bell"></i>
                                                        <span></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a href="<?php echo Site_URL . '/login'; ?>" class="login"><i class="fa fa-user"></i> <?php _e('Login'); ?></a>
                                            <a href="<?php echo Site_URL . '/register'; ?>" class="register"><i class="fa fa-user-plus"></i> <?php _e('Register'); ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row main-menu-sm">
                                  <button class="menu-btn hidden-lg hidden-md btn btn-primary pull-right"><span class="fa fa-bars"></span></button>
                                  <div id="menu-sm-links" class="hidden hidden-lg hidden-md">
                                    <ul>
                                      <li><span><i class="fa fa-mobile"></i> <?php echo get_option('site_phone'); ?></span> </li>
                                      <li><span><i class="fa fa-envelope-o"></i> <?php echo get_option('site_email'); ?></span></li>
                                      <?php global $Users;
                                        if ($Users->isset_login()) { ?>
                                                    <?php global $Users;
                                                    if ($Users->is_admin() or $Users->is_stuff()) {
                                                        ?>
                                                        <li><a href="<?php echo Site_URL; ?>"><?php _e('Dashboard'); ?></a></li>
                                                    <?php } else { ?>
                                                        <li><a href="<?php echo Site_URL; ?>"><?php _e('Your Tickets'); ?></a></li>
                                                        <li><a href="<?php echo Site_URL . '/tickets/create'; ?>"><?php _e('Create Ticket'); ?></a></li>
                                                    <?php } ?>
                                                    <li><a href="#edit-profile" data-toggle="modal" data-target="#edit-profile"><?php _e('Edit Profile'); ?></a></li>
                                                    <li><a href="<?php echo Site_URL . '/logout'; ?>"><?php _e('Logout'); ?></a></li>
                                                    <?php } else { ?>
                                            <li><a href="<?php echo Site_URL . '/login'; ?>" class="login"><i class="fa fa-user"></i> <?php _e('Login'); ?></a></li>
                                           <li> <a href="<?php echo Site_URL . '/register'; ?>" class="register"><i class="fa fa-user-plus"></i> <?php _e('Register'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                  </div>
                          </div> 
                        </div>
                    </div>
                    <?php if (is_main()) { ?>
                        <div class="main-search">
                            <div class="container">
                                <h2><?php _e('Simple Customer Support System'); ?></h2>
                                <p><?php _e('Find your own question right now'); ?></p>
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <form action="<?php echo Site_URL . '/main/search&query='; ?>" method="post">
                                            <div class="input-group input-group-lg">
                                                <input type="text" class="form-control input-lg typeahead" id="question" name="question" placeholder="<?php _e('What do you looking for ?'); ?>" required>
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn"><?php _e('Search'); ?></button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="main-search single">
                            <div class="container">
                                <span class="breadcrumb_title"></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php theme_main_page(); ?>
                <div class="main-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="footer-widget">
                                    <h2><?php _e('Departments'); ?></h2>
                                    <ul <?php echo(count(get_departments()) > 5) ? 'class="grid"' : ''; ?>>
                                        <?php
                                        if (get_departments()) {
                                            $departments = get_departments(5);
                                            foreach ($departments as $department) {
                                                ?>
                                                <li><a href="<?php echo Site_URL . '/main/department&id=' . $department['d_id']; ?>"><?php echo $department['d_name']; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-1">
                                <div class="footer-widget">
                                    <h2><?php _e('Recent Knowledge'); ?></h2>
                                    <ul>
                                        <?php
                                        global $Knowledges;
                                        if ($Knowledges->get_knowledges()) {
                                            $knowledges = $Knowledges->get_knowledges(5);
                                            foreach ($knowledges as $knowledge) {
                                                ?>
                                                <li><a href="<?php echo Site_URL . '/main/knowledge&id=' . $knowledge['post_id']; ?>"><?php echo $knowledge['post_title']; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="footer-widget">
                                    <h2><?php _e('Stay Friends'); ?></h2>
                                    <p><?php _e('subscribe email paragraph'); ?></p>
                                    <form action="<?php echo Site_URL . '/ajax'; ?>" method="post" id="subscribe">
                                        <div class="input-group input-group-lg">
                                            <input type="hidden" id="add_subscribe" name="add_subscribe" value="true">
                                            <input type="email" class="form-control" name="email" placeholder="<?php _e('Your Email'); ?>" required>
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn"><?php _e('Start'); ?> <em class="form-loading"><i class="fa fa-refresh"></i></em></button>
                                            </span>
                                        </div>
                                        <div class="show-alerts"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="copyright">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="text-left">
                                        <?php _e('All Right Reserved'); ?>
                                        <a href="<?php echo Site_URL; ?>">&nbsp;<?php echo Site_Name; ?></a>
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <?php if (Debug) { ?>
                                        <p class="text-right">
                                            <?php _e('Powered By'); ?> <a href="http://www.rtl-theme.com/?p=28605" target="_blank">راست چین</a>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            <?php } ?>
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
        <script type="text/javascript" src="<?php theme_assets('js/jquery/jquery-notify.js'); ?>"></script>
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
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCKukjg-U7FnOrAisW6kIP8xXSKEYAhztI"></script>
        <script type="text/javascript" src="<?php theme_assets('js/gmap/gmap.min.js'); ?>"></script>
        <script type="text/javascript">
                                            $(window).load(function () {
                                                var lat = <?php echo get_option('map_latitude '); ?>;
                                                var lng = <?php echo get_option('map_longitude'); ?>;
                                                var title = "<?php echo Site_Name; ?>";
                                                if ($('#Map').length) {
                                                    map = new GMaps({
                                                        el: '#Map',
                                                        lat: lat,
                                                        lng: lng,
                                                        zoomControl: true,
                                                        scrollwheel: false,
                                                        panControl: true,
                                                        streetViewControl: true,
                                                        mapTypeControl: true,
                                                        overviewMapControl: true,
                                                        zoomControlOpt: {
                                                            style: 'SMALL',
                                                            position: 'TOP_LEFT'
                                                        }
                                                    });
                                                    map.addMarker({
                                                        lat: lat,
                                                        lng: lng,
                                                        title: title,
                                                        details: {
                                                            database_id: 42,
                                                            author: 'HPNeo'
                                                        },
                                                        click: function (e) {
                                                        },
                                                        mouseover: function (e) {

                                                        }
                                                    });
                                                }
                                            });
        </script>
        <!--/java scripts file-->
    </body>
</html>