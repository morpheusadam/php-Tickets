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
    <body data-page="home" data-url="<?php echo Site_URL; ?>" data-site-name="<?php echo Site_Name; ?>" data-facebook-app-key="<?php echo Facebook_APP_KEY; ?>" data-allow-notifications="<?php echo Allow_Notifications; ?>">
        <div id="Wrapper">
            <div class="container-fluid" id="Header" <?php echo (get_theme_option('dashboard_background')) ? 'style="background-image: url(' . get_theme_option('dashboard_background') . ')"' : '' ?>>
                <div class="container">
                    <div class="text-center">
                        <div class="logo">
                            <?php if (get_theme_option('site_logo_img') != '') { ?>
                                <img src="<?php echo get_theme_option('site_logo_img'); ?>" alt="<?php echo Site_Name; ?>">
                            <?php } else { ?>
                                <span><i class="fa fa-cog"></i></span>
                                <h2><?php echo Site_Logo; ?></h2>
                            <?php } ?>
                            <?php
                            global $Users;
                            if (!$Users->isset_login()) {
                                ?>
                                <div class="line"></div>
                                <p><?php echo Site_Logo_Description; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    if ($Users->isset_login()) {
                        if (Allow_Notifications) {
                            ?>
                            <div class="dropdown notifications">
                                <a data-toggle="dropdown" class="btn notification">
                                    <i class="fa fa-bell"></i>
                                    <span></span>
                                </a>
                                <ul class="dropdown-menu">
                                </ul>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>