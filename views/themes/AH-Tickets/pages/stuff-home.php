<?php
$stuff = get_stuff_byID(get_session('user_id'));
?>
<div class="row">
    <div class="col-md-12">
        <div class="ah-panel">
            <h2 class="has-menu">
                <?php _e('Dashboard'); ?>
                <?php include (dirname(__file__) . '/menu-links.php'); ?>
            </h2>
            <div class="ah-panel-body">
                <ul class="nav nav-tabs add_hash">
                    <li class="active">
                        <a href="#tickets" aria-controls="tickets" data-toggle="tab">
                            <i class="fa fa-ticket"></i> <?php _e('Tickets'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#customers" aria-controls="customers" data-toggle="tab">
                            <i class="fa fa-users"></i> <?php _e('Customers'); ?>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane my-tickets admin active" id="tickets" data-ajaxurl="<?php echo Site_URL . '/get-ajax/tickets-filter'; ?>">
                        <h3 class="tickets-number">
                            <?php echo tickets_num('all', access_departments(get_session('user_id'), 'array')); ?> <?php _e('Tickets'); ?> &nbsp; 
                            <label class="label label-warning"><?php echo tickets_num('unread', access_departments(get_session('user_id'), 'array')); ?> <?php _e('Unread'); ?></label>
                            <span class="pull-right">
                                <label class="label label-success"><?php echo tickets_num('opened', access_departments(get_session('user_id'), 'array')); ?> <?php _e('Opened'); ?></label>
                                <label class="label label-default"><?php echo tickets_num('closed', access_departments(get_session('user_id'), 'array')); ?> <?php _e('Closed'); ?></label>
                            </span>
                        </h3>
                        <table class="table table-striped table-bordered">
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
                                $get_tikects = get_stuff_tickets(access_departments(get_session('user_id'), 'array'));
                                foreach ($get_tikects as $ticket) :
                                    ?>
                                    <tr <?php echo ticket_is_answer('class', $ticket['is_answer'], $ticket['is_read'],$ticket['status']); ?>>
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
                                        <td><a href="#" data-ajaxurl="<?php echo Site_URL . '/get-ajax/user-data&u_id=' . $ticket['id']; ?>" class="user_data" data-toggle="modal" data-target="#User-Data"><?php echo $ticket['name']; ?></a></td>
                                        <td><?php echo time_ago($ticket['time']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!--/tickets(tab)-->
                    <div role="tabpanel" class="tab-pane my-customers" id="customers">
                        <h3 class="tickets-number">
                            <?php echo users_num(); ?> <?php _e('Customers'); ?>
                            <?php if ($stuff['edit_customers'] == 1) { ?>
                                <span class="pull-right">
                                    <button type="button" data-toggle="modal" data-target="#add-user" class="btn btn-success btn-u-add">
                                        <i class="fa fa-plus"></i> <?php _e('Add New'); ?>
                                    </button>
                                </span>
                            <?php } ?>
                        </h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php _e('Photo'); ?></th>
                                    <th><?php _e('Name'); ?></th>
                                    <th><?php _e('Country'); ?></th>
                                    <th><?php _e('Gender'); ?></th>
                                    <th><?php _e('Active'); ?></th>
                                    <?php if ($stuff['edit_customers'] == 1) { ?>
                                        <th><?php _e('Options'); ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                global $Users;
                                if ($Users->get_users()) {
                                    $users = $Users->get_users();
                                    foreach ($users as $user) {
                                        ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo get_user_photo($user['photo']); ?>" class="table_photo" alt="">
                                            </td>
                                            <td>
                                                <a class="n_title" title="<?php _e('Email'); ?> : <?php echo $user['email']; ?>"><?php echo $user['name']; ?></a> 
                                            </td>
                                            <td class="capitalize"><?php echo $user['country_name']; ?></td>
                                            <td class="capitalize"><?php echo $user['gender']; ?></td>
                                            <td><?php active_label($user['active']) ?></td>
                                            <?php if ($stuff['edit_customers'] == 1) { ?>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" data-toggle="modal" data-target="#add-user"
                                                                data-id="<?php echo $user['id']; ?>" 
                                                                data-name="<?php echo $user['name']; ?>" 
                                                                data-photo="<?php echo $user['photo']; ?>"
                                                                data-email="<?php echo $user['email']; ?>" 
                                                                data-country="<?php echo $user['location']; ?>" 
                                                                data-gender="<?php echo $user['gender']; ?>" 
                                                                data-activate="<?php echo $user['active']; ?>" 
                                                                data-bio="<?php echo str_replace('\n', "\n", stripcslashes($user['bio'])); ?>" 
                                                                data-title-lang="<?php _e('Edit'); ?>"
                                                                data-password-lang="<?php _e('leave it empty for not change password'); ?>"
                                                                data-phone-lang="<?php _e('leave it empty for not change phone'); ?>"
                                                                class="btn btn-primary btn-u-edit">
                                                            <i class="fa fa-edit"></i> <?php _e('Edit'); ?>
                                                        </button>
                                                        <button type="button" data-id="<?php echo $user['id']; ?>" class="btn btn-danger btn-u-delete">
                                                            <i class="fa fa-trash"></i> <?php _e('Delete'); ?>
                                                        </button>
                                                        <div class="dropdown inline-block">
                                                            <button type="button"  class="btn btn-default" data-toggle="dropdown">
                                                                <i class="fa fa-ticket"></i> <?php _e('Tickets'); ?> <i class="fa fa-angle-down"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#" class="btn-u-tickets" data-id="<?php echo $user['id']; ?>" data-toggle="modal" data-target="#user-tickets"><?php _e('Tickets'); ?></a></li>
                                                                <li><a href="<?php echo Site_URL . '/tickets/create/user-id/' . $user['id']; ?>"><?php _e('Add Ticket'); ?></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!--/customers(tab)-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="User-Data" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-user"></i> <?php _e('User Data'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="ajax-loader"><span><i class="fa fa-refresh"></i></span></div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><?php _e('ID'); ?> : </td>
                            <td class="id"><p class="text-primary"></p></td>
                        </tr>
                        <tr>
                            <td><?php _e('Name'); ?> : </td>
                            <td class="name"><p class="text-primary"></p></td>
                        </tr>
                        <tr>
                            <td><?php _e('Email'); ?> : </td>
                            <td class="email"><p class="text-primary"></p></td>
                        </tr>
                        <tr>
                            <td><?php _e('Gender'); ?> : </td>
                            <td class="gender"><p class="text-primary"></p></td>
                        </tr>
                        <tr>
                            <td><?php _e('Country'); ?> : </td>
                            <td class="country"><p class="text-primary"></p></td>
                        </tr>
                        <tr>
                            <td><?php _e('Bio'); ?> : </td>
                            <td class="bio"><p class="text-primary"></p></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php if ($stuff['edit_customers'] == 1) { ?>
    <div class="modal fade" id="add-user" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php _e('Add User'); ?></h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo Site_URL . '/ajax'; ?>" data-href="<?php echo Site_URL . '#customers'; ?>" method="post" data-toggle="validator">
                        <div class="show-alerts"></div>
                        <input type="hidden" name="user_add" id="user_add" value="">
                        <input type="hidden" name="u_id" id="u_id" value="">
                        <div class="form-group">
                            <img src="" alt="" class="modal_photo">
                            <button type="button" onclick="$(this).next().click();" class="btn btn-default"><i class="fa fa-upload"></i> <?php _e('Upload'); ?></button>
                            <input type="file" name="photo">
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label"><?php _e('Your Name'); ?></label>
                            <input class="form-control input-lg" id="name" name="name" type="text" required data-error="<?php _e('this input required'); ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label"><?php _e('Email'); ?></label>
                            <input class="form-control input-lg" id="email" name="email" type="email" required data-error="<?php _e('this input required'); ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label"><?php _e('Password'); ?></label>
                            <input class="form-control input-lg" id="password" name="password" type="password">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="control-label"><?php _e('Phone'); ?></label>
                            <input class="form-control input-lg" id="phone" name="phone" type="text">
                        </div>
                        <div class="row">
                            <div class="col-xs-6 form-group">
                                <label for="country" class="control-label"><?php _e('Country'); ?></label>
                                <select class="custom-select" id="country" name="country">
                                    <?php
                                    $countries = get_countries();
                                    foreach ($countries as $country) {
                                        ?>
                                        <option value="<?php echo $country['country_code']; ?>"><?php echo $country['country_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-3 form-group">
                                <label for="gender" class="control-label"><?php _e('Gender'); ?></label>
                                <select class="custom-select" id="gender" name="gender">
                                    <option value="hidden"><?php _e('Hidden'); ?></option>
                                    <option value="Male"><?php _e('Male'); ?></option>
                                    <option value="Female"><?php _e('Female'); ?></option>
                                </select>
                            </div>
                            <div class="col-xs-3 form-group">
                                <label for="gender" class="control-label"><?php _e('Activate'); ?></label>
                                <select class="custom-select" id="activate" name="activate">
                                    <option value="0"><?php _e('No'); ?></option>
                                    <option value="1"><?php _e('Yes'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bio" class="control-label"><?php _e('Bio'); ?></label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success">
                                <span><?php _e('Save'); ?></span>
                                <em class="form-loading"><i class="fa fa-refresh"></i></em>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="modal fade" id="user-tickets" data-ajaxurl="<?php echo Site_URL . '/get-ajax/get-tikects'; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg"></div>
</div>