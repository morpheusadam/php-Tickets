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
                $Users->active_by_sms();
                ?>
                <form method="post" action="">
                <div class="form-group">
                        <label for="activate_code" class="control-label"><?php _e('Your Code'); ?></label>
                        <div class="has-feedback">
                        <input type="hidden" name="active_user" value="true" />
                            <input class="form-control input-lg input-padding" id="activate_code" name="activate_code" type="text" required />
                            <span class="fa fa-barcode form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                <button type="submit" class="btn  btn-success btn-lg">فعالسازی</button>
                </form>
            </div>
        </div>
    </div>
</div>