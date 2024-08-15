<div class="row">
    <div class="col-md-12">
        <div class="ah-panel">
            <h2 class="has-menu">
                <?php _e('View Ticket'); ?>
                <?php include (dirname(__file__) . '/menu-links.php'); ?>
            </h2>
            <div class="ah-panel-body">
                <?php
                global $Users;
                $Users->is_login();
                echo tickets_msg;
                $get_ticket = view_ticket();
                //var_dump($get_ticket);
                if ($get_ticket) {
                    if ($get_ticket['user_id'] == get_session('user_id') or get_session('is_admin') == 1 or get_session('is_admin') == 2) {
                        
                    } else {
                        ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong><?php _e('Error'); ?> : </strong> <?php _e('ticket id not found'); ?>
                        </div>
                        <?php
                        return;
                    }
                    ?>
                    <div class="panel panel-default panel-ticket">
                        <div class="panel-heading">
                            <h3>
                                <?php echo ticket_status('status', $get_ticket['status']) . (htmlentities(stripcslashes($get_ticket['subject']))); ?>
                                <span class="pull-right label label-default">
                                    <?php echo get_priority($get_ticket['priority']); ?>
                                </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="wrapword">
                                <?php echo (stripcslashes(stripcslashes((htmlspecialchars_decode($get_ticket['content']))))); ?>
                            </div>
                            <?php if (!empty($get_ticket['attach_file'])) { ?>
                                <div class="attach">
                                    <a href="<?php echo (htmlentities($get_ticket['attach_file'])); ?>">
                                        <i class="fa fa-file-archive-o"></i>
                                        <?php _e('Attachment'); ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="panel-footer">
                            <i class="fa fa-clock-o"></i> <?php echo jdate('d F Y - h:i A', $get_ticket['time']); ?> &nbsp;
                            <i class="fa fa-user"></i> <?php echo $get_ticket['name']; ?> &nbsp;
                            <i class="fa fa-folder"></i> <?php echo $get_ticket['d_name']; ?> &nbsp;
                            <?php if ($get_ticket['status'] == 1) { ?>
                                <div class="pull-right">
                                    <?php
                                    if (get_session('is_admin') == 1 or get_session('is_admin') == 2) {
                                        if (Allow_Change_Department) {
                                            ?>
                                            <button type="button" data-id="<?php echo $get_ticket['t_id']; ?>" data-toggle="modal" data-target="#change-department" class="change-department text-primary">
                                                <i class="fa fa-cog"></i> <?php _e('Change Department'); ?>
                                            </button>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    if (get_session('is_admin') == 1 or get_session('is_admin') == 2) {
                                        if (Allow_Admin_Close) {
                                            ?>
                                            <button type="button" data-id="<?php echo $get_ticket['t_id']; ?>" data-alert-lang="<?php _e('Close Ticket ?'); ?>" class="colose-ticket text-danger">
                                                <i class="fa fa-times"></i> <?php _e('Close Ticket'); ?>
                                            </button>
                                            <?php
                                        }
                                    }
                                    if (get_session('is_admin') == 0) {
                                        if (Allow_Customer_Close) {
                                            ?>
                                            <button type="button" data-id="<?php echo $get_ticket['t_id']; ?>" data-alert-lang="<?php _e('Close Ticket ?'); ?>" class="colose-ticket text-danger">
                                                <i class="fa fa-times"></i> <?php _e('Close Ticket'); ?>
                                            </button>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="replies">
                        <ul>
                            <?php
                            $replies = get_replies($get_ticket['t_id']);
                            $x = 0;
                            if ($replies) {
                                foreach ($replies as $reply) {
                                    $x++;
                                    ?>
                                    <li id="reply-<?php echo $x; ?>" <?php echo ($reply['is_admin'] == 1 or $reply['is_admin'] == 2) ? 'class="admin"' : ''; ?>>
                                        <div class="reply" id="id-<?php echo $reply['t_id']; ?>">
                                            <div class="head">
                                                <i class="fa fa-user"></i> <?php echo ($reply['is_admin'] == 1 or $reply['is_admin'] == 2) ? $get_ticket['d_name'] . ' ( ' . $reply['name'] . ' ) ' : $reply['name']; ?> &nbsp;
                                                <i class="fa fa-clock-o"></i> <?php echo jdate('d F Y - h:i A', $reply['time']); ?> &nbsp;
                                                <?php reply_rate($reply['rating'], $reply['is_admin'], $reply['t_id'], get_session('is_admin')); ?>
                                                <?php
                                                if (Allow_Delete_Replies) {
                                                    if (get_session('user_id') == $reply['user_id']) {
                                                        ?>
                                                        <button type="button" class="btn-delete delete-reply" data-alert-lang="<?php _e('Delete Your Reply ?'); ?>" data-parentid="<?php echo $get_ticket['t_id']; ?>" data-id="<?php echo $reply['t_id']; ?>">
                                                            <i class="fa fa-trash"></i> <?php _e('Delete'); ?>
                                                        </button>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="content">
                                                <div class="wrapword">
                                                    <?php echo (stripcslashes(stripcslashes((htmlspecialchars_decode($reply['content']))))); ?>
                                                </div>
                                                <?php if (!empty($reply['attach_file'])) { ?>
                                                    <div class="attach">
                                                        <a href="<?php echo (htmlentities($reply['attach_file'])); ?>">
                                                            <i class="fa fa-file-archive-o"></i>
                                                            <?php _e('Attachment'); ?>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <?php if ($get_ticket['status'] == 1) { ?>
                        <div class="clear-30"></div>
                        <div class="panel panel-default panel-ticket">
                            <div class="panel-heading"><h3><?php _e('Add Reply'); ?></h3></div>
                            <div class="panel-body">
                                <form action="<?php echo Site_URL . '/ajax'; ?>" data-reply="<?php echo '#reply-' . last_reply_id($get_ticket['t_id']); ?>" method="post" id="create-ticket" enctype="multipart/form-data">
                                    <div class="show-alerts"></div>
                                    <input type="hidden" name="tickets_reply" id="tickets_reply" value="true_<?php echo $get_ticket['t_id']; ?>">
                                    <input type="hidden" name="tickets_redirect" id="tickets_redirect" value="<?php echo Site_URL . '/tickets/view/' . $get_ticket['t_id']; ?>">
                                    <input type="hidden" name="max_attach" id="max_attach" value="<?php echo formatSize_int(Attach_Size); ?>">
                                    <div class="form-group">
                                        <textarea rows="5" class="form-control input-lg tinymce" row="4" id="content" name="content" data-error="<?php _e('empty reply content'); ?>"></textarea>
                                        <div class="help-block"></div>
                                    </div>
                                    <?php if (Allow_Attach) { ?>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <span class="control-label">
                                                    <i class="fa fa-file-zip-o"></i>&nbsp; <?php _e('Attachment'); ?>
                                                </span>
                                                <div class="form-control file-input">
                                                    <label for="attachment">
                                                        <span class="btn btn-github">
                                                            <input type="file" id="attachment" data-types="<?php echo Attach_Type; ?>" name="attachment" onchange="this.parentNode.parentNode.nextElementSibling.value = this.value">
                                                            <?php _e('Choose File'); ?>
                                                        </span>
                                                    </label>
                                                    <input class="file-name" type="text" readonly placeholder="<?php _e('No file selected'); ?>">
                                                </div>
                                                <div class="help-block with-warning"><?php _e('maximum size'); ?> <?php echo formatSize(Attach_Size); ?></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <span><?php _e('Reply'); ?></span>
                                            <em><i class="fa fa-refresh"></i></em>
                                        </button>
                                    </div>
                                </form>
                                <div class="over_load" style="margin:-47px 0 25px 132px; display:none;">
                                    <div class="progress">
                                        <div class="bar"></div >
                                        <div class="percent">0%</div >
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong><?php _e('Error'); ?> : </strong> <?php _e('ticket id not found'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="change-department" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php _e('Change Department'); ?></h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Site_URL . '/ajax'; ?>" data-href="<?php echo Site_URL . '#tickets'; ?>" method="post">
                    <input type="hidden" name="change_department" id="change_department" value="<?php echo $get_ticket['t_id']; ?>">
                    <select class="custom-select" name="ticket-department" id="ticket-department">
                        <?php
                        global $Tickets;
                        if ($Tickets->get_departments()) {
                            $departments = $Tickets->get_departments();
                            foreach ($departments as $department) {
                                ?>
                                <option value="<?php echo $department['d_id']; ?>" <?php echo selected($department['d_id'], $get_ticket['d_id']) ?>><?php echo $department['d_name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="clear-15"></div>
                    <button type="submit" class="btn btn-block btn-bitbucket"><?php _e('Save'); ?> <em class="form-loading"><i class="fa fa-refresh"></i></em></button>
                </form>
            </div>
        </div>
    </div>
</div>