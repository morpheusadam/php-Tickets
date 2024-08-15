<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AHsetup page</title>
        <link rel="stylesheet" type="text/css" href="controller/setup/assets/css/style.css">
        <link rel="stylesheet/less" type="text/css" href="controller/setup/assets/css/main.less">
        <script type="text/javascript">
            var url = window.location.href;
            //setTimeout(function () {}, 3000);
<?php
if ($this->is_setup()) {
    echo "window.location.href = url.replace(/\/setup/g, '')";
}
?>
        </script>
    </head>
    <body>
        <?php
        if (isset($_GET['update'])) {
            ?>
            <div id="Wrapper">
                <div class="container">
                    <div class="logo">
                        <span>AH</span> Tickets
                        <p>Update</p>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="Content">
                                <div class="content-body">
                                    <?php
                                    if (isset($_POST['run_update'])) {
                                        $this->update_tables();
                                    }
                                    echo '<ul>';
                                    echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "users" Updated</li>';
                                    echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "tickets" Updated</li>';
                                    echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "posts" Created</li>';
                                    echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Table "options" Created</li>';
                                    echo '<li><label class="label label-success"><i class="fa fa-check"></i></label> Insert Default Data IN "options" Table</li>';
                                    echo '</ul><div class="clear-30"></div>';
                                    ?>
                                </div>
                                <ul class="list-unstyled">
                                    <li>
                                        <?php
                                        if (phpversion() >= 5.4) {
                                            echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                            $this->run_setup_1 = TRUE;
                                        } else {
                                            echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                            $this->run_setup_1 = FALSE;
                                        }
                                        ?>
                                        PHP version >= 5.4
                                    </li>
                                    <li>
                                        <?php
                                        if (function_exists('curl_version')) {
                                            echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                            $this->run_setup_2 = TRUE;
                                        } else {
                                            echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                            $this->run_setup_2 = FALSE;
                                        }
                                        ?>
                                        PHP curl
                                    </li>
                                    <li>
                                        <?php
                                        if (function_exists('mysqli_connect')) {
                                            echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                            $this->run_setup_3 = TRUE;
                                        } else {
                                            echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                            $this->run_setup_3 = FALSE;
                                        }
                                        ?>
                                        PHP mysqli
                                    </li>
                                    <li>
                                        <?php
                                        if (function_exists('gettext')) {
                                            echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                            $this->run_setup_4 = TRUE;
                                        } else {
                                            echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                            $this->run_setup_4 = FALSE;
                                        }
                                        ?>
                                        PHP gettext
                                    </li>
                                    <li>
                                        <?php
                                        if (function_exists('mail')) {
                                            echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                            $this->run_setup_5 = TRUE;
                                        } else {
                                            echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                            $this->run_setup_5 = FALSE;
                                        }
                                        ?>
                                        PHP mail();
                                    </li>
                                    <?php if (function_exists('apache_get_modules')) { ?>
                                        <li>
                                            <?php
                                            if (in_array('mod_rewrite', apache_get_modules())) {
                                                echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                            } else {
                                                echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                            }
                                            ?>
                                            Apache mod_rewrite (.htaccess files)
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="clear-30"></div>
                                <form action="" method="post">
                                    <input type="hidden" name="run_update" id="run_update" value="true">
                                    <table class="table table-bordered table_vertical">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Setup Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width:140px;"><label for="option_site_name">Site Name</label></td>
                                                <td>
                                                    <input type="text" class="form-control" name="site_name" id="option_site_name" value="AH Support Tickets">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:140px;"><label for="option_site_logo">Site Logo</label></td>
                                                <td>
                                                    <input type="text" class="form-control" name="site_logo" id="option_site_logo" value="AH Tickets">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:140px;"><label for="option_site_url">Site URL</label></td>
                                                <td>
                                                    <input type="text" class="form-control" name="site_url" id="option_site_url" value="<?php echo str_replace("/setup?update=true", '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:140px;"><label for="option_site_description">Site Description</label></td>
                                                <td>
                                                    <textarea class="form-control" name="site_description" id="option_site_description"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:140px;"><label for="option_site_email">Site Email</label></td>
                                                <td>
                                                    <input type="text" class="form-control" name="site_email" id="option_site_email" value="no-reply@domain.com">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:140px;"><label for="option_activity_email">Activity Email</label></td>
                                                <td>
                                                    <input type="text" class="form-control" name="activity_email" id="option_activity_email" value="name@domain.com">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-bitbucket">Run Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div id="Wrapper">
                <div class="container">
                    <div class="logo">
                        <span>AH</span> Tickets
                        <p>Setup</p>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="Content">
                                <?php if (isset($_GET['step'])) { ?>
                                    <div class="top-btns">
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group">
                                                <a class="btn btn-lg  <?php echo($_GET['step'] == '1') ? 'active' : ''; ?>">Create Tables</a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn btn-lg <?php echo($_GET['step'] == '2') ? 'active' : ''; ?>">Site Options</a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn btn-lg <?php echo($_GET['step'] == '3') ? 'active' : ''; ?>">Admin Account</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($_GET['step'] == '1') { ?>
                                        <div class="content-body">
                                            <?php $this->create_tables(); ?>
                                            <div class="text-center">
                                                <a href="<?php echo '?step=2'; ?>" class="btn btn-lg btn-bitbucket">Next Step</a>
                                            </div>
                                            <script type="text/javascript">
                                                setTimeout(function () {
                                                    window.location.href = '<?php echo '?step=2'; ?>';
                                                }, 15000)
                                            </script>
                                        </div>
                                    <?php } ?>
                                    <?php if ($_GET['step'] == '2') { ?>
                                        <div class="content-body">
                                            <form action="<?php echo '?step=3'; ?>" method="post">
                                                <input type="hidden" name="save_options" id="save_options" value="true">
                                                <table class="table table-bordered table_vertical">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:140px;"><label for="option_site_name">Site Name</label></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="site_name" id="option_site_name" value="AH Support Tickets">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:140px;"><label for="option_site_logo">Site Logo</label></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="site_logo" id="option_site_logo" value="AH Tickets">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:140px;"><label for="option_site_url">Site URL</label></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="site_url" id="option_site_url" value="<?php echo str_replace("/setup?step=2", '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:140px;"><label for="option_site_description">Site Description</label></td>
                                                            <td>
                                                                <textarea class="form-control" name="site_description" id="option_site_description"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:140px;"><label for="option_site_email">Site Email</label></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="site_email" id="option_site_email" value="no-reply@domain.com">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:140px;"><label for="option_activity_email">Activity Email</label></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="activity_email" id="option_activity_email" value="name@domain.com">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-lg btn-bitbucket">Next Step</button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                    <?php if ($_GET['step'] == '3') { ?>
                                        <div class="content-body">
                                            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                                <input type="hidden" name="save_admin" id="save_admin" value="true">
                                                <table class="table table-bordered table_vertical">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:140px;"><label for="register_name">User Name</label></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="register_name" id="register_name" value="admin" required>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:140px;"><label for="register_email">Email</label></td>
                                                            <td>
                                                                <input type="email" class="form-control" name="register_email" id="register_email" value="admin@domain.com" required>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:140px;"><label for="register_password">Password</label></td>
                                                            <td>
                                                                <input type="password" minlength="6" class="form-control validate_strong_pass" name="register_password" id="register_password" required>
                                                                <div class="label password_validate font-14"></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-lg btn-twitter">Create Account</button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="content-body">
                                        <ul class="list-unstyled">
                                            <li>
                                                <?php
                                                if (phpversion() >= 5.4) {
                                                    echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                                    $this->run_setup_1 = TRUE;
                                                } else {
                                                    echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                                    $this->run_setup_1 = FALSE;
                                                }
                                                ?>
                                                PHP version >= 5.4
                                            </li>
                                            <li>
                                                <?php
                                                if (function_exists('curl_version')) {
                                                    echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                                    $this->run_setup_2 = TRUE;
                                                } else {
                                                    echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                                    $this->run_setup_2 = FALSE;
                                                }
                                                ?>
                                                PHP curl
                                            </li>
                                            <li>
                                                <?php
                                                if (function_exists('mysqli_connect')) {
                                                    echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                                    $this->run_setup_3 = TRUE;
                                                } else {
                                                    echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                                    $this->run_setup_3 = FALSE;
                                                }
                                                ?>
                                                PHP mysqli
                                            </li>
                                            <li>
                                                <?php
                                                if (function_exists('gettext')) {
                                                    echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                                    $this->run_setup_4 = TRUE;
                                                } else {
                                                    echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                                    $this->run_setup_4 = FALSE;
                                                }
                                                ?>
                                                PHP gettext
                                            </li>
                                            <li>
                                                <?php
                                                if (function_exists('mail')) {
                                                    echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                                    $this->run_setup_5 = TRUE;
                                                } else {
                                                    echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                                    $this->run_setup_5 = FALSE;
                                                }
                                                ?>
                                                PHP mail();
                                            </li>
                                            <?php if (function_exists('apache_get_modules')) { ?>
                                                <li>
                                                    <?php
                                                    if (in_array('mod_rewrite', apache_get_modules())) {
                                                        echo '<label class="label label-success"><i class="fa fa-check"></i></label>';
                                                    } else {
                                                        echo '<label class="label label-danger"><i class="fa fa-times"></i></label>';
                                                    }
                                                    ?>
                                                    Apache mod_rewrite (.htaccess files)
                                                    <ul>
                                                        <?php
                                                        $appache = apache_get_modules();
                                                        foreach ($appache as $key => $value) {
                                                            echo "<li><label class=\"label label-success\"><i class=\"fa fa-check\"></i></label> $value</li>";
                                                        }
                                                        ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="clear-15"></div>
                                        <div class="text-center">
                                            <?php if ($this->run_setup_1 == TRUE and $this->run_setup_2 == TRUE and $this->run_setup_3 == TRUE and $this->run_setup_4 == TRUE and $this->run_setup_5 == TRUE) { ?>
                                                <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?step=1'; ?>" class="btn btn-lg btn-bitbucket">Start Setup</a>
                                            <?php } else { ?>
                                                <button type="button" disabled d class="btn btn-lg btn-google">Can't Setup</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </body>
    <script type="text/javascript" src="controller/setup/assets/js/jquery/jquery.js"></script>
    <script type="text/javascript" src="controller/setup/assets/js/less/less.js"></script>
    <script type="text/javascript" src="controller/setup/assets/js/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="controller/setup/assets/js/jquery/jquery.custom.js"></script>
</html>
