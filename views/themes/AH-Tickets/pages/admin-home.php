<?php
$departments = get_departments();
?>
<div class="row">
    <div class="col-md-12">
        <div class="ah-panel">
            <h2 class="has-menu">
                <?php _e('Dashboard'); ?>
                <?php include (dirname(__file__) . '/menu-links.php'); ?>
            </h2>
            <div class="ah-panel-body">
                <?php if (Update_MSG) echo Update_MSG; ?>
                <ul class="nav nav-tabs add_hash">
                    <li class="active">
                        <a href="#dashboard" aria-controls="dashboard" data-toggle="tab">
                            <i class="fa fa-dashboard"></i> <?php _e('Dashboard'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#tickets" aria-controls="tickets" data-toggle="tab">
                            <i class="fa fa-ticket"></i> <?php _e('Tickets'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#departments" aria-controls="departments" data-toggle="tab">
                            <i class="fa fa-folder"></i> <?php _e('Departments'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#customers" aria-controls="customers" data-toggle="tab">
                            <i class="fa fa-user"></i> <?php _e('Customers'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#stuff" aria-controls="customers" data-toggle="tab">
                            <i class="fa fa-user-secret"></i> <?php _e('Staff'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#knowledge" aria-controls="knowledge" data-toggle="tab">
                            <i class="fa fa-cubes"></i> <?php _e('Knowledge'); ?>
                        </a>
                    </li>
                    <?php if(Allow_Send_SMS == TRUE) { ?>
                    <li>
                        <a href="#sms" aria-controls="sms" data-toggle="tab">
                            <i class="fa fa-paper-plane"></i> <?php _e('SMS'); ?>
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="#setting" aria-controls="setting" data-toggle="tab">
                            <i class="fa fa-cog"></i> <?php _e('Setting'); ?>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane my-tickets admin active" id="dashboard">
                        <div class="ah_rang">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="stats_block">
                                        <p><?php echo tickets_num('all'); ?></p>
                                        <span><?php _e('Tickets'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stats_block">
                                        <p><?php echo departments_num(); ?></p>
                                        <span><?php _e('Departments'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stats_block">
                                        <p><?php echo stuff_num(); ?></p>
                                        <span><?php _e('Staff'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stats_block">
                                        <p><?php echo users_num(); ?></p>
                                        <span><?php _e('Customers'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <h4><?php _e('Tickets'); ?></h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="rang">
                                        <input type="text"
                                               disabled="disabled"
                                               class="status"
                                               data-width="160"
                                               data-min="0"
                                               data-max="100" 
                                               data-cursor=false
                                               data-thickness="0.3"
                                               data-fgColor="#24ca82"
                                               data-bgColor="#ccc"
                                               data-displayInput="false"
                                               data-readOnly=true
                                               value="<?php echo (tickets_num('opened') and tickets_num('all')) ? (tickets_num('opened') / tickets_num('all')) * 100 : ''; ?>">
                                        <h5 style="color:#24ca82;"><?php _e('open'); ?> [ <?php echo tickets_num('opened'); ?> ]</h5>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="rang">
                                        <input type="text"
                                               disabled="disabled"
                                               class="status"
                                               data-width="160"
                                               data-min="0"
                                               data-max="100" 
                                               data-cursor=false
                                               data-thickness="0.3"
                                               data-fgColor="#ed4256"
                                               data-bgColor="#ccc"
                                               data-displayInput="false"
                                               data-readOnly=true
                                               value="<?php echo (tickets_num('closed') and tickets_num('all')) ? (tickets_num('closed') / tickets_num('all')) * 100 : ''; ?>">
                                        <h5 style="color:#ed4256;"><?php _e('closed'); ?> [ <?php echo tickets_num('closed'); ?> ]</h5>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="rang">
                                        <input type="text"
                                               disabled="disabled"
                                               class="status"
                                               data-width="160"
                                               data-min="0"
                                               data-max="100" 
                                               data-cursor=false
                                               data-thickness="0.3"
                                               data-fgColor="#1e84da"
                                               data-bgColor="#ccc"
                                               data-displayInput="false"
                                               data-readOnly=true
                                               value="<?php echo (tickets_num('answered') and tickets_num('opened')) ? (tickets_num('answered') / tickets_num('opened')) * 100 : ''; ?>">
                                        <h5 style="color:#1e84da;"><?php _e('answered'); ?> [ <?php echo tickets_num('answered'); ?> ]</h5>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="rang">
                                        <input type="text"
                                               disabled="disabled"
                                               class="status"
                                               data-width="160"
                                               data-min="0"
                                               data-max="100" 
                                               data-cursor=false
                                               data-thickness="0.3"
                                               data-fgColor="#e19614"
                                               data-bgColor="#ccc"
                                               data-displayInput="false"
                                               data-readOnly=true
                                               value="<?php echo (tickets_num('unread') and tickets_num('opened')) ? (tickets_num('unread') / tickets_num('opened')) * 100 : ''; ?>">
                                        <h5 style="color:#e19614;"><?php _e('unread'); ?> [ <?php echo tickets_num('unread'); ?> ]</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/dashboard(tab)-->
                    <div role="tabpane2" class="tab-pane my-tickets admin" id="tickets" data-ajaxurl="<?php echo Site_URL . '/get-ajax/tickets-filter'; ?>">
                        <h3 class="tickets-number">
                            <?php echo tickets_num('all'); ?> <?php _e('Tickets'); ?> &nbsp; 
                            <label class="label label-warning"><?php echo tickets_num('unread'); ?> <?php _e('unread'); ?></label>
                            <span class="pull-right">
                                <label class="label label-success"><?php echo tickets_num('opened'); ?> <?php _e('open'); ?></label>
                                <label class="label label-danger"><?php echo tickets_num('closed'); ?> <?php _e('closed'); ?></label>
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
                                $get_tikects = get_tickets();
                                foreach ($get_tikects as $ticket) :
                                    ?>
                                    <tr <?php echo ticket_is_answer('class', $ticket['is_answer'], $ticket['is_read'],$ticket['status']); ?>>
                                        <td><a href="<?php echo Site_URL . '/tickets/view/' . $ticket['t_id']; ?>"><?php echo $ticket['t_id']; ?></a></td>
                                        <td>
                                            <a href="<?php echo Site_URL . '/tickets/view/' . $ticket['t_id']; ?>">
                                                <?php echo stripcslashes($ticket['subject']); ?>
                                            </a>
                                            <p class="margin-0" style="margin-top:10px !important;">
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
                    <div role="tabpane3" class="tab-pane my-departments" id="departments">
                        <h3 class="tickets-number">
                            <?php echo departments_num(); ?> <?php _e('Departments'); ?>
                            <span class="pull-right">
                                <button type="button" data-toggle="modal" data-target="#add-department" class="btn btn-success btn-d-add" data-title-lang="<?php _e('Add New'); ?>">
                                    <i class="fa fa-plus"></i> <?php _e('Add New'); ?>
                                </button>
                            </span>
                        </h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php _e('ID'); ?></th>
                                    <th><?php _e('Name'); ?></th>
                                    <th><?php _e('Options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                global $Tickets;
                                if ($Tickets->get_departments()) {
                                    $departments = $Tickets->get_departments();
                                    foreach ($departments as $department) {
                                        ?>
                                        <tr>
                                            <td><a><?php echo $department['d_id']; ?></a></td>
                                            <td><a><?php echo $department['d_name']; ?></a></td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#add-department" data-id="<?php echo $department['d_id']; ?>" data-name="<?php echo $department['d_name']; ?>" data-title-lang="<?php _e('Edit'); ?>" class="btn btn-primary btn-d-edit">
                                                    <i class="fa fa-edit"></i> <?php _e('Edit'); ?>
                                                </button>
                                                <button type="button" data-id="<?php echo $department['d_id']; ?>" data-alert-lang="<?php _e('Do you want delete it ?'); ?>" class="btn btn-danger btn-d-delete">
                                                    <i class="fa fa-trash"></i> <?php _e('Delete'); ?>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!--/departments(tab)-->
                    <div role="tabpane4" class="tab-pane my-customers" id="customers">
                        <h3 class="tickets-number">
                            <?php echo users_num(); ?> <?php _e('Customers'); ?>
                            <span class="pull-right">
                                <button type="button" data-toggle="modal" data-target="#add-user" data-title-lang="<?php _e('Add New'); ?>" class="btn btn-success btn-u-add">
                                    <i class="fa fa-plus"></i> <?php _e('Add New'); ?>
                                </button>
                            </span>
                        </h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php _e('Photo'); ?></th>
                                    <th><?php _e('Name'); ?></th>
                                    <th><?php _e('Country'); ?></th>
                                    <th><?php _e('Gender'); ?></th>
                                    <th><?php _e('Active'); ?></th>
                                    <th><?php _e('Options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                global $Users;
                                $x = 0;
                                if ($Users->get_users()) {
                                    $users = $Users->get_users();
                                    foreach ($users as $user) {
                                        $x++;
                                        ?>
                                        <tr>
                                            <td><?php echo $x; ?></td>
                                            <td>
                                                <img src="<?php echo get_user_photo($user['photo']); ?>" class="table_photo" alt="">
                                            </td>
                                            <td>
                                                <a class="n_title" title="<?php _e('Email'); ?> : <?php echo $user['email']; ?>"><?php echo $user['name']; ?></a> 
                                            </td>
                                            <td class="capitalize"><?php echo $user['country_name']; ?></td>
                                            <td class="capitalize"><?php _e($user['gender']); ?></td>
                                            <td><?php active_label($user['active']) ?></td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#add-user"
                                                        data-id="<?php echo $user['id']; ?>" 
                                                        data-name="<?php echo $user['name']; ?>" 
                                                        data-photo="<?php echo $user['photo']; ?>"
                                                        data-email="<?php echo $user['email']; ?>" 
                                                        data-country="<?php echo $user['location']; ?>" 
                                                        data-gender="<?php echo $user['gender']; ?>" 
                                                        data-activate="<?php echo $user['active']; ?>" 
                                                        data-bio="<?php echo str_replace('\n', "\n", $user['bio']); ?>" 
                                                        data-title-lang="<?php _e('Edit'); ?>"
                                                        data-password-lang="<?php _e('leave it empty for not change password'); ?>"
                                                        data-phone-lang="<?php _e('leave it empty for not change phone'); ?>"
                                                        class="btn btn-primary btn-u-edit">
                                                    <i class="fa fa-edit"></i> <?php _e('Edit'); ?>
                                                </button>
                                                <button type="button" data-id="<?php echo $user['id']; ?>" data-alert-lang="<?php _e('Do you want delete it ?'); ?>" class="btn btn-danger btn-u-delete">
                                                    <i class="fa fa-trash"></i> <?php _e('Delete'); ?>
                                                </button>
                                                <div class="dropdown inline-block">
                                                    <button type="button"  class="btn btn-default" data-toggle="dropdown">
                                                        <i class="fa fa-ticket"></i> <?php _e('Options'); ?> <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" class="btn-u-tickets" data-id="<?php echo $user['id']; ?>" data-toggle="modal" data-target="#user-tickets"><?php _e('User Tickets'); ?></a></li>
                                                        <li><a href="<?php echo Site_URL . '/tickets/create/user-id/' . $user['id']; ?>"><?php _e('Add Ticket'); ?></a></li>
                                                        <?php if(Allow_Send_SMS == TRUE) { ?><li><a href="<?php echo Site_URL . '/sms/create/user-id/' . $user['id']; ?>"><?php _e('Send SMS'); ?></a></li><?php } ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!--/customers(tab)-->
                    <div role="tabpane5" class="tab-pane my-customers" id="stuff">
                        <h3 class="tickets-number">
                            <?php echo stuff_num(); ?> <?php _e('Staff'); ?>
                            <span class="pull-right">
                                <button type="button" data-toggle="modal" data-target="#add-stuff" data-title-lang="<?php _e('Add New'); ?>" class="btn btn-success btn-stuff-add">
                                    <i class="fa fa-plus"></i> <?php _e('Add New'); ?>
                                </button>
                            </span>
                        </h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php _e('Photo'); ?></th>
                                    <th><?php _e('Name'); ?></th>
                                    <th class="hidden"><?php _e('Country'); ?></th>
                                    <th><?php _e('Gender'); ?></th>
                                    <th><?php _e('Departments'); ?></th>
                                    <th><?php _e('Add/Edit'); ?></th>
                                    <th><?php _e('Active'); ?></th>
                                    <th><?php _e('Options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                global $Users;
                                $x = 0;
                                if ($Users->get_stuff()) {
                                    $stuff = $Users->get_stuff();
                                    foreach ($stuff as $user) {
                                        $x++;
                                        ?>
                                        <tr>
                                            <td><?php echo $x; ?></td>
                                            <td>
                                                <img src="<?php echo get_user_photo($user['photo']); ?>" class="table_photo" alt="">
                                            </td>
                                            <td>
                                                <a class="n_title" title="<?php _e('Email'); ?> : <?php echo $user['email']; ?>"><?php echo $user['name']; ?></a> 
                                            </td>
                                            <td class="capitalize hidden"><?php echo $user['country_name']; ?></td>
                                            <td class="capitalize"><?php _e($user['gender']); ?></td>
                                            <td class="capitalize"><?php echo access_departments($user['id']); ?></td>
                                            <td><?php active_label(access_add_edit($user['id'])); ?></td>
                                            <td><?php active_label($user['active']); ?></td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#add-stuff"
                                                        data-id="<?php echo $user['id']; ?>" 
                                                        data-name="<?php echo $user['name']; ?>" 
                                                        data-photo="<?php echo $user['photo']; ?>" 
                                                        data-email="<?php echo $user['email']; ?>" 
                                                        data-country="<?php echo $user['location']; ?>" 
                                                        data-gender="<?php echo $user['gender']; ?>" 
                                                        data-activate="<?php echo $user['active']; ?>" 
                                                        data-addedits="<?php echo access_add_edit($user['id']); ?>" 
                                                        data-departments="<?php echo access_departments($user['id'], 'implode'); ?>" 
                                                        data-bio="<?php echo str_replace('\n', "\n", $user['bio']); ?>" 
                                                        data-title-lang="<?php _e('Edit'); ?>"
                                                        data-password-lang="<?php _e('leave it empty for not change password'); ?>"
                                                        data-phone-lang="<?php _e('leave it empty for not change phone'); ?>"
                                                        class="btn btn-primary btn-stuff-edit">
                                                    <i class="fa fa-edit"></i> <?php _e('Edit'); ?>
                                                </button>
                                                <button type="button" data-id="<?php echo $user['id']; ?>" data-alert-lang="<?php _e('Do you want delete it ?'); ?>" class="btn btn-danger btn-u-delete">
                                                    <i class="fa fa-trash"></i> <?php _e('Delete'); ?>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!--/stuff(tab)-->
                    <div role="tabpane6" class="tab-pane my-departments" id="knowledge">
                        <h3 class="tickets-number">
                            <?php _e('Knowledge'); ?>
                            <span class="pull-right">
                                <button type="button" data-toggle="modal" data-target="#add-knowledge" class="btn btn-success btn-kn-add" data-title-lang="<?php _e('Add New'); ?>">
                                    <i class="fa fa-plus"></i> <?php _e('Add New'); ?>
                                </button>
                            </span>
                        </h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php _e('Title'); ?></th>
                                    <th><?php _e('Departments'); ?></th>
                                    <th><?php _e('Allow Visitors'); ?></th>
                                    <th><?php _e('Time'); ?></th>
                                    <th><?php _e('Options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                global $Knowledges;
                                $x = 0;
                                if ($Knowledges->get_knowledges()) {
                                    $knowledges = $Knowledges->get_knowledges();
                                    foreach ($knowledges as $knowledge) {
                                        $x++;
                                        ?>
                                        <tr>
                                            <td><?php echo $x; ?></td>
                                            <td>
                                                <a><?php echo $knowledge['post_title']; ?></a> 
                                            </td>
                                            <td class="capitalize"><?php echo get_department_byID($knowledge['post_department'], 'd_name'); ?></td>
                                            <td><?php is_allow($knowledge['is_public']) ?></td>
                                            <td><?php echo time_ago($knowledge['post_time']); ?></td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#add-knowledge"
                                                        data-id="<?php echo $knowledge['post_id']; ?>" 
                                                        data-title="<?php echo $knowledge['post_title']; ?>" 
                                                        data-department="<?php echo $knowledge['post_department']; ?>" 
                                                        data-content="<?php echo stripcslashes(stripcslashes(htmlspecialchars($knowledge['post_content']))); ?>" 
                                                        data-public="<?php echo $knowledge['is_public']; ?>" 
                                                        data-title-lang="<?php _e('Edit'); ?>"
                                                        class="btn btn-primary btn-knowledge-edit">
                                                    <i class="fa fa-edit"></i> <?php _e('Edit'); ?>
                                                </button>
                                                <button type="button" data-id="<?php echo $knowledge['post_id']; ?>" data-alert-lang="<?php _e('Do you want delete it ?'); ?>" class="btn btn-danger btn-kn-delete">
                                                    <i class="fa fa-trash"></i> <?php _e('Delete'); ?>
                                                </button>
                                                <a href="<?php echo Site_URL . '/main/knowledge&id=' . $knowledge['post_id']; ?>" target="_blank" class="btn btn-default font-14"><i class="fa fa-link"></i> <?php _e('View'); ?></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!--/knowledge(tab)-->
                    <?php if(Allow_Send_SMS == TRUE) { ?>
                    <div role="tabpane7" class="tab-pane my-sms" id="sms">
                    	<table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php _e('ID'); ?></th>
                                    <th><?php _e('Subject'); ?></th>
                                    <th><?php _e('Content'); ?></th>
                                    <th><?php _e('Status'); ?></th>
                                    <th><?php _e('Customer'); ?></th>
                                    <th><?php _e('Date'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <h3 class="tickets-number">
                            <?php _e('SMS'); ?>
                            <span class="pull-right">
                            <a href="<?php echo Site_URL.'/sms/create/' ?>" class="btn btn-success btn-sms-add" title="<?php _e('Send New SMS') ?>"><i class="fa fa-plus"></i> <?php _e('Send New SMS') ?></a>
                            </span>
                        </h3>
                            
                                <?php
                                $get_sms = get_sms();
								
                                foreach ($get_sms as $sms) :
                                    ?>
                                    
                                    <tr>
                                        <td><a href="<?php echo Site_URL . '/sms/view/' . $sms['id']; ?>"><?php echo $sms['id']; ?></a></td>
                                        <td>
                                            <a href="<?php echo Site_URL . '/sms/view/' . $sms['id']; ?>">
                                                <?php echo stripcslashes($sms['subject']); ?>
                                            </a>
                                            
                                        </td>
                                        <td><?php echo get_sms_content($sms['content']); ?></td>
                                        <td><?php echo get_sms_status($sms['status']); ?></td>
                                        <td><?php  
										if(user_data_byID($sms['sent_to'], 'name') !== NULL){
											echo user_data_byID($sms['sent_to'], 'name');
										}		
										else echo $sms['sent_to'];
										?></td>
                                        <td><?php echo time_ago($sms['time']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                    <!--/sms tab -->
                    <div role="tabpane8" class="tab-pane my-departments" id="setting">
                        <?php theme_template('template-options'); ?>
                    </div>
                    <!--/setting(tab)-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-knowledge" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-cubes"></i> <?php _e('Add New'); ?></h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Site_URL . '/ajax'; ?>" data-href="<?php echo Site_URL . '#knowledge'; ?>" data-toggle="validator" method="post">
                    <div class="show-alerts"></div>
                    <input type="hidden" name="knowledge_add" id="knowledge_add" value="new">
                    <input type="hidden" name="knowledge_id" id="knowledge_id" value="">
                    <div class="form-group">
                        <label for="title" class="control-label"><?php _e('Title'); ?></label>
                        <input class="form-control input-lg" id="title" name="title" type="text" required data-error="<?php _e('this input required'); ?>">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="allow_visitors" class="control-label"><?php _e('Allow Visitors'); ?></label>
                            <select class="custom-select" id="allow_visitors" name="allow_visitors">
                                <option value="1"><?php _e('Show'); ?></option>
                                <option value="0"><?php _e('Hidden'); ?></option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="allow_visitors" class="control-label"><?php _e('Department'); ?></label>
                            <select class="custom-select" id="department" name="department">
                                <?php
                                if ($departments) {
                                    foreach ($departments as $department) {
                                        ?>
                                        <option value="<?php echo $department['d_id']; ?>"><?php echo $department['d_name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="control-label"><?php _e('Content'); ?></label>
                        <textarea rows="5" class="form-control input-lg tinymce" id="content" name="content"></textarea>
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
<div class="modal fade" id="User-Data" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-user"></i> <?php _e('User Data'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="ajax-loader"><span><i class="fa fa-refresh"></i></span></div>
                <table class="table table-bordered table_vertical">
                    <tbody>
                        <tr>
                            <td><?php _e('Photo'); ?> : </td>
                            <td class="photo"><img src="#" alt="" class="table_photo" style="width:110px;height: 100px;"></td>
                        </tr>
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
                            <td><?php _e('Phone'); ?> : </td>
                            <td class="phone"><p class="text-primary"></p></td>
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
<div class="modal fade" id="add-department" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php _e('Add Department'); ?></h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Site_URL . '/ajax'; ?>" data-href="<?php echo Site_URL . '#departments'; ?>" data-toggle="validator" method="post">
                    <div class="show-alerts"></div>
                    <input type="hidden" name="department_add" id="department_add" value="">
                    <input type="hidden" name="d_id" id="d_id" value="">
                    <div class="form-group">
                        <label for="d_name" class="control-label"><?php _e('Department Name'); ?></label>
                        <input class="form-control input-lg" id="d_name" name="d_name" type="text" required data-error="<?php _e('this input required'); ?>">
                        <div class="help-block with-errors"></div>
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
                        <label for="phone" class="control-label"><?php _e('Phone'); ?></label>
                        <input class="form-control input-lg" id="phone" name="phone" type="text">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label"><?php _e('Password'); ?></label>
                        <input class="form-control input-lg" id="password" name="password" type="password">
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
<div class="modal fade" id="add-stuff" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php _e('Add Staff'); ?></h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Site_URL . '/ajax'; ?>" data-href="<?php echo Site_URL . '#stuff'; ?>" method="post" data-toggle="validator">
                    <div class="show-alerts"></div>
                    <input type="hidden" name="stuff_add" id="stuff_add" value="">
                    <input type="hidden" name="u_id" id="u_id" value="">
                    <div class="form-group">
                        <img src="" alt="" class="modal_photo">
                        <button type="button" onclick="$(this).next().click();" class="btn btn-default"><i class="fa fa-upload"></i> <?php _e('Upload'); ?></button>
                        <input type="file" name="photo">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label"><?php _e('Name'); ?></label>
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
                        <label for="name" class="control-label"><?php _e('Phone'); ?></label>
                        <input class="form-control input-lg" id="phone" name="phone" type="text">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label for="country" class="control-label"><?php _e('Country'); ?></label>
                            <select class="custom-select" id="country" name="country">
                                <?php
                                $countries = get_countries();
                                if ($countries) {
                                    foreach ($countries as $country) {
                                        ?>
                                        <option value="<?php echo $country['country_code']; ?>"><?php echo $country['country_name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-4 form-group">
                            <label for="gender" class="control-label"><?php _e('Gender'); ?></label>
                            <select class="custom-select" id="gender" name="gender">
                                <option value="hidden"><?php _e('Hidden'); ?></option>
                                <option value="Male"><?php _e('Male'); ?></option>
                                <option value="Female"><?php _e('Female'); ?></option>
                            </select>
                        </div>
                        <div class="col-xs-4 form-group">
                            <label for="gender" class="control-label"><?php _e('Activate'); ?></label>
                            <select class="custom-select" id="activate" name="activate">
                                <option value="0"><?php _e('No'); ?></option>
                                <option value="1"><?php _e('Yes'); ?></option>
                            </select>
                        </div>
                        <div class="col-xs-4 form-group">
                            <label for="edit_customers" class="control-label"><?php _e('Add/Edit Customers'); ?></label>
                            <select class="custom-select" id="edit_customers" name="edit_customers">
                                <option value="0"><?php _e('No'); ?></option>
                                <option value="1"><?php _e('Yes'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php _e('Access Departments'); ?></label>
                        <div class="row">
                            <?php
                            $stuff_departments = $departments;
                            if ($stuff_departments) {
                                foreach ($stuff_departments as $department) {
                                    ?>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="checkbox">
                                            <label data-on="<?php _e('ON'); ?>" data-off="<?php _e('OFF'); ?>" class="custom-option toggle">
                                                <input type="checkbox" value="<?php echo $department['d_id']; ?>" name="stuff_department[]" id="stuff_department-<?php echo $department['d_id']; ?>">
                                                <span class="button-checkbox"></span>
                                            </label>
                                            <label for="stuff_department-<?php echo $department['d_id']; ?>"><?php echo $department['d_name']; ?></label>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
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
<div class="modal fade" id="user-tickets" data-ajaxurl="<?php echo Site_URL . '/get-ajax/get-tikects'; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg"></div>
</div>