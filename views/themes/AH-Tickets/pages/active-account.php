<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="ah-panel">
            <h2><?php _e('Active Account'); ?></h2>
            <div class="ah-panel-body">
                <?php
                global $Users;
                $Users->is_not_login();
                $users_msg = users_msg;
                if (!empty($users_msg)) {
                    echo $users_msg;
                }
                ?>
            </div>
        </div>
    </div>
</div>