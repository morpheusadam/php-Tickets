<?php
/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

global $Users, $httpRequest;
$Users->is_login();
$get_tikects = get_byUser_tickets($httpRequest->http_post('user_id'));
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php _e('Tikects'); ?> [ <?php echo count($get_tikects); ?> ]</h4>
    </div>
    <div class="modal-body" style="max-height:400px; overflow:auto;">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th><?php _e('ID'); ?></th>
                    <th><?php _e('Subject'); ?></th>
                    <th><?php _e('Department'); ?></th>
                    <th><?php _e('Status'); ?></th>
                    <th><?php _e('Date'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($httpRequest->http_isset('user_tikects', 'post')) {
                    if (!$get_tikects)
                        die('<tr><td colspan="5"><div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('No Data Found') . '
                                    </div></td></tr>');
                    foreach ($get_tikects as $ticket) :
                        ?>
                        <tr <?php echo ticket_is_answer('class', $ticket['is_answer'], $ticket['is_read'], $ticket['status']); ?>>
                            <td><a href="<?php echo Site_URL . '/tickets/view/' . $ticket['t_id']; ?>"><?php echo $ticket['t_id']; ?></a></td>
                            <td>
                                <a href="<?php echo Site_URL . '/tickets/view/' . $ticket['t_id']; ?>"><?php echo stripcslashes($ticket['subject']); ?></a>
                                <?php echo ticket_is_answer('label', $ticket['is_answer'], $ticket['is_read'], $ticket['status']); ?>
                            </td>
                            <td><?php echo $ticket['d_name']; ?></td>
                            <td><?php echo ticket_status('status', $ticket['status']); ?></td>
                            <td><?php echo time_ago($ticket['time']); ?></td>
                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>