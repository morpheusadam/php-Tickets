<div class="main-body">
    <div class="container">
        <div class="panel panel-default">

            <?php if (isset($_GET['id'])) { ?>
                <?php
                $view_knowledge = view_knowledge();
                if ($view_knowledge) {
                    ?>
                    <div class="panel-heading"><h3><?php echo __("Knowledges") . ' &gg; ' . $view_knowledge['post_title']; ?></h3></div>
                    <div class="panel-body">
                        <?php
                        if (is_user_login()) {
                            echo stripcslashes(stripcslashes($view_knowledge['post_content']));
                        } else {
                            if ($view_knowledge['is_public'] != 1) {
                                echo alert_message(__('Warning'), __('register or login to read this post') . ' ', 'warning');
                            } else {
                                echo stripcslashes(stripcslashes($view_knowledge['post_content']));
                            }
                        }
                        ?>
                    </div>
                    <div class="panel-footer post_single">
                        <i class="fa fa-folder"></i> <?php echo get_department_byID($view_knowledge['post_department'], 'd_name'); ?> &nbsp; 
                        <i class="fa fa-clock-o"></i> <?php echo time_ago($view_knowledge['post_time']); ?> &nbsp; 
                        <span><em <?php echo($view_knowledge['post_like'] >= 0) ? '' : 'class="error"'; ?>><i class="fa <?php echo($view_knowledge['post_like'] >= 0) ? 'fa-thumbs-o-up' : 'fa-thumbs-o-down'; ?>"></i> <em class="like_count"><?php echo $view_knowledge['post_like']; ?></em></em></span>
                        <div class="pull-right">
                            <label class="control-label pull-left"><?php _e('Helpful'); ?> &nbsp;</label>
                            <?php
                            global $Users;
                            if ($Users->isset_login()) {
                                ?>
                                <div class="btn-group add_like" data-url="<?php echo Site_URL . '/ajax'; ?>">
                                    <button class="btn btn-sm btn-success" <?php echo(check_like($view_knowledge['post_id'])) ? 'disabled' : ''; ?> data-type="+1" data-id="<?php echo $view_knowledge['post_id']; ?>"><i class="fa fa-thumbs-o-up"></i></button>
                                    <button class="btn btn-sm btn-danger" <?php echo(check_like($view_knowledge['post_id'])) ? 'disabled' : ''; ?> data-type="-1" data-id="<?php echo $view_knowledge['post_id']; ?>"><i class="fa fa-thumbs-o-down"></i></button>
                                </div>
                            <?php } else { ?>
                                <div class="btn-group n_title" title="<?php _e('must be login'); ?>">
                                    <button class="btn btn-sm btn-success" disabled><i class="fa fa-thumbs-o-up"></i></button>
                                    <button class="btn btn-sm btn-danger" disabled><i class="fa fa-thumbs-o-down"></i></button>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="panel-heading"><h3><?php echo __("Knowledges") . ' &gg; ' . __("Not Found"); ?></h3></div>
                    <div class="panel-body">
                        <?php echo alert_message(__('Error'), __('Not Found'), 'danger'); ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="panel-heading"><h3><?php _e("Knowledges") ?></h3></div>
                <div class="panel-body" style="padding-bottom:0px">
                    <div class="row">
                        <?php
                        global $Knowledges;
                        if ($Knowledges->get_knowledges()) {
                            $knowledges = $Knowledges->get_knowledges();
                            foreach ($knowledges as $knowledge) {
                                ?>
                                <div class="col-md-6">
                                    <p class="post">
                                        <a href="<?php echo Site_URL . '/main/knowledge&id=' . $knowledge['post_id']; ?>"><?php echo $knowledge['post_title']; ?></a>
                                        <b><?php echo get_department_byID($knowledge['post_department'], 'd_name'); ?> &gg; <?php echo time_ago($knowledge['post_time']); ?></b>
                                        <span><?php _e('Helpful'); ?> <em <?php echo($knowledge['post_like'] >= 0) ? '' : 'class="error"'; ?>><i class="fa <?php echo($knowledge['post_like'] >= 0) ? 'fa-thumbs-o-up' : 'fa-thumbs-o-down'; ?>"></i> <?php echo $knowledge['post_like']; ?></em></span>
                                    </p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>