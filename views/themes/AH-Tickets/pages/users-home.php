<div class="row">
    <div class="col-md-12">
        <div class="ah-panel">
            <h2 class="has-menu">
                <?php _e('Profile'); ?>
                <?php include (dirname(__file__) . '/menu-links.php'); ?>
            </h2>
            <div class="ah-panel-body">
                <h3 class="tickets-number">
                    <?php echo my_tickets_num('all'); ?> <?php _e('Tickets'); ?>
                    <span class="pull-right">
                        <label class="label label-success"><?php echo my_tickets_num('opened'); ?> <?php _e('Opened'); ?></label>
                        <label class="label label-default"><?php echo my_tickets_num('closed'); ?> <?php _e('Closed'); ?></label>
                    </span>
                </h3>
                <div class="my-tickets users" data-ajaxurl="<?php echo Site_URL . '/get-ajax/tickets-filter'; ?>">
                    <table id="data-tables" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php _e('ID'); ?></th>
                                <th><?php _e('Subject'); ?></th>
                                <th><?php _e('Department'); ?></th>
                                <th><?php _e('Status'); ?></th>
                                <th><?php _e('Customer'); ?></th>
                                <th><?php _e('Date'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $get_tikects = get_my_tickets();
                            if ($get_tikects):
                                foreach ($get_tikects as $ticket) :
                                    ?>
                                    <tr <?php echo ticket__user_is_answer('class', $ticket['is_answer']); ?>>
                                        <td><a href="<?php echo Site_URL . '/tickets/view/' . $ticket['t_id']; ?>"><?php echo $ticket['t_id']; ?></a></td>
                                        <td>
                                            <a href="<?php echo Site_URL . '/tickets/view/' . $ticket['t_id']; ?>">
                                                <?php echo stripcslashes($ticket['subject']); ?>
                                            </a>
                                            <p class="margin-0 style="margin-top:10px !important;"">
                                                <?php echo ticket_is_answer('label', $ticket['is_answer'], $ticket['is_read'],$ticket['status']); ?>
                                                <label class="label label-default text-lowercase">
                                                    <?php echo get_priority($ticket['priority']); ?>
                                                </label>
                                            </p>
                                        </td>
                                        <td><?php echo $ticket['d_name']; ?></td>
                                        <td><?php echo ticket_status('status', $ticket['status']); ?></td>
                                        <td><?php echo $ticket['name']; ?></td>
                                        <td><?php echo time_ago($ticket['time']); ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>