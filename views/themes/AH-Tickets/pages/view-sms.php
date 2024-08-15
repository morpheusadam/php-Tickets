<div class="row">
    <div class="col-md-12">
        <div class="ah-panel">
        <?php
                global $Users;
                $Users->is_login();
                echo users_msg;
			?>
            <h2 class="has-menu">
                <?php _e('View SMS'); ?>
                <?php include (dirname(__file__) . '/menu-links.php'); ?>
            </h2>
            <div class="ah-panel-body">
              <?php
			  if(Allow_Send_SMS != TRUE) {
				  echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Error') . ' : </strong> ' . __('creating sms is disabled') . '
                                    </div>';
                            return;
			  }
			   if (get_session('is_admin') != 1) { 
			   		echo '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>' . __('Warning') . ' : </strong> ' . __('you not has access to view sms') . '
                                    </div>';
                        return;
                    }
					else if(get_session('is_admin') == 1){
						if (isset($_GET['id']) and ! empty($_GET['id']) and is_numeric($_GET['id'])) {
						$db = DB::db();
						$id = $db->escape($_GET['id'], true);
						$sms = DB::table('sms');
						$sms->where('id', $id);
						$get = $sms->get_one();	
						}
						if($get === NULL){
                        ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong><?php _e('Error'); ?> : </strong> <?php _e('sms id not found'); ?>
                        </div>
                        <?php
                        return;
                    }
                    ?>
					<div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="subject" class="control-label"><?php _e('Subject'); ?></label>
                            <input class="form-control input-lg" id="subject" type="text" value="<?php echo $get['subject'] ?>" disabled>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="subject" class="control-label"><?php _e('Sent To'); ?></label>
                            <input class="form-control input-lg" id="subject" type="text" value="<?php  
										if(user_data_byID($get['sent_to'], 'name') !== NULL){
											echo user_data_byID($get['sent_to'], 'name');
										}		
										else echo $get['sent_to'];
										?>" disabled>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="control-label"><?php _e('Content'); ?></label>
                        <textarea rows="5" class="form-control input-lg" id="content" disabled><?php echo get_sms_content($get['content']); ?></textarea>
                    </div>                     
            </div>
        </div>
    </div>
</div>
<?php } return; ?>