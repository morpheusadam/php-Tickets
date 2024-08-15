<?php
global $httpRequest;
?>
<form action="<?php echo Site_URL . '/ajax'; ?>" method="post" id="create-ticket" data-toggle="validator" enctype="multipart/form-data">
    <div class="show-alerts"></div>
    <input type="hidden" name="tickets_create" id="tickets_create" value="<?php echo $httpRequest->http_get('user-id'); ?>">
    <input type="hidden" name="tickets_is_user_create" id="tickets_is_user_create" value="<?php echo user_data_byID($httpRequest->http_get('user-id'), 'name'); ?>">
    <input type="hidden" name="tickets_redirect" id="tickets_redirect" value="<?php echo Site_URL . '/#tickets'; ?>">
    <input type="hidden" name="max_attach" id="max_attach" value="<?php echo formatSize_int(Attach_Size); ?>">
    <div class="row">
        <div class="col-sm-6 form-group">
            <label for="user-name" class="control-label"><?php _e('Customer'); ?></label>
            <input class="form-control input-lg" id="user-name" name="user-name" type="text" disabled value="<?php echo user_data_byID($httpRequest->http_get('user-id'), 'name'); ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label for="subject" class="control-label"><?php _e('Subject'); ?></label>
            <input class="form-control input-lg" id="subject" name="subject" type="text" required data-error="<?php _e('empty subject'); ?>">
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label for="department" class="control-label"><?php _e('Department'); ?></label>
            <select class="custom-select" id="department" name="department">
                <?php
                global $Tickets;
                if ($Tickets->get_departments()) {
                    $departments = $Tickets->get_departments();
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
        <div class="radio">
            <label class="custom-option button">
                <input type="radio" id="priority-1" name="priority" value="low" checked="checked">
                <span class="button-radio"></span>
            </label>
            <label for="priority-1"><?php _e('Low'); ?></label>
        </div>
        <div class="radio">
            <label class="custom-option button">
                <input type="radio" id="priority-2" name="priority" value="medium">
                <span class="button-radio"></span>
            </label>
            <label for="priority-2"><?php _e('Medium'); ?></label>
        </div>
        <div class="radio">
            <label class="custom-option button">
                <input type="radio" id="priority-3" name="priority" value="high">
                <span class="button-radio"></span>
            </label>
            <label for="priority-3"><?php _e('High'); ?></label>
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="control-label"><?php _e('Content'); ?></label>
        <textarea rows="5" class="form-control input-lg tinymce" id="content" name="content" data-error="<?php _e('empty ticket content'); ?>"></textarea>
    </div>
    <?php if (Allow_Attach) { ?>
        <div class="row">
            <div class="col-sm-6 form-group">
                <span class="control-label">
                    <i class="fa fa-file-zip-o"></i>&nbsp; <?php _e('Attach File'); ?>
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
            <span><?php _e('Submit Ticket'); ?></span>
            <em><i class="fa fa-refresh"></i></em>
        </button>
    </div>
</form>
<div class="over_load">
    <div class="progress">
        <div class="bar"></div >
        <div class="percent">0%</div>
    </div>
</div>