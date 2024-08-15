<div class="main-body">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading"><h3><?php _e("Contact US") ?></h3></div>
            <div class="panel-body">
                <?php if (get_option('allow_map') == 'on') { ?>
                    <div id="Map"></div>
                    <div class="clear-15"></div>
                <?php } ?>
                <div class="clear-15"></div>
                <form action="<?php echo Site_URL . '/ajax'; ?>" method="post" id="contactForm">
                    <div class="show-alerts"></div>
                    <input type="hidden" id="contact_us" name="contact_us" value="true">
                    <div class="form-group form-group-lg row">
                        <div class="col-md-4">
                            <input type="text" name="name" id="name" class="form-control" placeholder="<?php _e('Name'); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php _e('Email'); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="<?php _e('Phone'); ?>" required>
                        </div>
                    </div>
                    <div class="clear-15"></div>
                    <div class="form-group form-group-lg">
                        <textarea name="content" id="content" class="form-control" rows="6" placeholder="<?php _e('Message'); ?>" required></textarea>
                    </div>
                    <div class="clear-15"></div>
                    <button type="submit" class="btn btn-lg btn-success"><?php _e('Submit'); ?> <em class="form-loading"><i class="fa fa-refresh"></i></em></button>
                </form>
            </div>
        </div>
    </div>
</div>