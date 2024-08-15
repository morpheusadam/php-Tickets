<div class="main-body">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading"><h3><?php echo __("Search") . ' &gg; ' . str_replace('+', ' ', query_search($_GET['query'])); ?></h3></div>
            <div class="panel-body" style="padding-bottom:0px">
                <?php
                $knowledges = search_knowledges(query_search($_GET['query']));
                if ($knowledges) {
                    ?>
                    <div class="row">
                        <?php
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
                        ?>
                    </div>
                    <?php
                } else {
                    echo alert_message(__('Error'), __('No Data Found'), 'danger');
                }
                ?>
            </div>
        </div>
    </div>
</div>