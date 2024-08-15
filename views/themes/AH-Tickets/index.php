<?php
global $Users;
if (Allow_Landing and isset($_GET['main'])) {
    include (dirname(__file__) . '/main.php');
    exit();
}
?>
<?php get_header() ?>
<div class="container-fluid">
    <div class="container">
        <?php
        if(Allow_Landing){
            $Users->show_landing_is_not_login();
        }else{
            $Users->is_login();
        }
        if ($Users->is_admin()) {
            include (dirname(__file__) . '/pages/admin-home.php');
        } elseif ($Users->is_stuff()) {
            include (dirname(__file__) . '/pages/stuff-home.php');
        } else {
            include (dirname(__file__) . '/pages/users-home.php');
        }
        ?>
    </div>
</div>
<?php get_footer() ?>