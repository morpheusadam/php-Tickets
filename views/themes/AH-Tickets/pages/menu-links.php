<div class="hidden-xs hidden-sm col-md-9 pull-right">
<a href="<?php echo Site_URL . '/logout'; ?>"><i class="fa fa-power-off"></i> <?php _e('Logout'); ?></a>
<a href="#edit-profile" data-toggle="modal" data-target="#edit-profile"><i class="fa fa-user-plus"></i>  <?php _e('Edit Profile'); ?></a>
<?php
global $Users;
if ($Users->is_admin() or $Users->is_stuff()) {
    if (Allow_Admin_Create) {
        ?>
        <a <?php echo(is_page('create-ticket')) ? 'class="active"' : ''; ?> href="<?php echo Site_URL . '/tickets/create'; ?>"><i class="fa fa-pencil-square-o"></i> <?php _e('Create Ticket'); ?></a>
    <?php
    }
} else {
    ?>
    <a <?php echo(is_page('create-ticket')) ? 'class="active"' : ''; ?> href="<?php echo Site_URL . '/tickets/create'; ?>"><i class="fa fa-pencil-square-o"></i> <?php _e('Create Ticket'); ?></a>
<?php } ?>
<a <?php echo(is_home()) ? 'class="active"' : ''; ?> href="<?php echo Site_URL; ?>"><i class="fa fa-dashboard"></i> <?php _e('Dashboard'); ?></a>
<?php if (Allow_Landing) { ?>
    <a href="<?php echo Site_URL . '/main'; ?>"><i class="fa fa-home"></i> <?php _e('Home'); ?></a>
<?php } ?>
</div>
<button class="menu-btn hidden-lg hidden-md btn btn-primary pull-right">
<span class="fa fa-bars"></span>
</button>
<div id="menu-sm-links" class="hidden hidden-lg hidden-md">
<ul>
<li>
<?php if ($Users->is_admin() or $Users->is_stuff()) {
    if (Allow_Admin_Create) {
        ?>
        <a <?php echo(is_page('create-ticket')) ? 'class="active"' : ''; ?> href="<?php echo Site_URL . '/tickets/create'; ?>"><i class="fa fa-pencil-square-o"></i> <?php _e('Create Ticket'); ?><?php
    }
} else {
    ?>
    <a <?php echo(is_page('create-ticket')) ? 'class="active"' : ''; ?> href="<?php echo Site_URL . '/tickets/create'; ?>"><i class="fa fa-pencil-square-o"></i> <?php _e('Create Ticket'); ?></a>
<?php } ?></a>
</li>
<li>
<a <?php echo(is_home()) ? 'class="active"' : ''; ?> href="<?php echo Site_URL; ?>"><i class="fa fa-dashboard"></i> <?php _e('Dashboard'); ?></a>
<?php if (Allow_Landing) { ?>
    <a href="<?php echo Site_URL . '/main'; ?>"><i class="fa fa-home"></i> <?php _e('Home'); ?></a>
<?php } ?>
</li>
<li><a href="#edit-profile" data-toggle="modal" data-target="#edit-profile"><i class="fa fa-user-plus"></i>  <?php _e('Edit Profile'); ?></a></li>
<li><a href="<?php echo Site_URL . '/logout'; ?>"><i class="fa fa-power-off"></i> <?php _e('Logout'); ?></a></li>
</ul>
</div>