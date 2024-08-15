<div class="main-body">
    <div class="services">
        <div class="container">
            <h2><?php _e('What We Have ?'); ?></h2>
            <div class="row">
                <?php for ($x = 1; $x <= 3; $x++) { ?>
                    <div class="col-md-4">
                        <div class="service">
                            <i class="fa <?php echo get_theme_option('service_icon_' . $x); ?>"></i>
                            <h4><?php echo get_theme_option('service_title_' . $x); ?></h4>
                            <p><?php echo get_theme_option('service_description_' . $x); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--/services-->
    <div class="knowledge">
        <div class="container">
            <h2><?php _e('Popular Knowledge'); ?></h2>
            <div class="row">
                <?php
                global $Knowledges;
                if ($Knowledges->get_popular_knowledges()) {
                    $knowledges = $Knowledges->get_popular_knowledges(6);
                    foreach ($knowledges as $knowledge) {
                        ?>
                        <div class="col-md-6">
                            <p class="post">
                                <a href="<?php echo Site_URL . '/main/knowledge&id=' . $knowledge['post_id']; ?>"><?php echo $knowledge['post_title']; ?></a>
                                <b><?php echo get_department_byID($knowledge['post_department'], 'd_name'); ?> &gg; <?php echo time_ago($knowledge['post_time']); ?></b>
                                <span><?php _e('Helpful'); ?> <em <?php echo($knowledge['post_like'] >= 0) ? '' : 'class="error"'; ?>><i class="fa fa-thumbs-o-up"></i> <?php echo $knowledge['post_like']; ?></em></span>
                            </p>
                        </div>
                        <?php
                    }
                } else {
                    if ($Knowledges->get_knowledges()) {
                        $knowledges = $Knowledges->get_knowledges(6);
                        foreach ($knowledges as $knowledge) {
                            
                        }
                        ?>
                        <div class="col-md-6">
                            <p class="post">
                                <a href="<?php echo Site_URL . '/main/knowledge&id=' . $knowledge['post_id']; ?>"><?php echo $knowledge['post_title']; ?></a>
                                <b><?php echo get_department_byID($knowledge['post_department'], 'd_name'); ?> &gg; <?php echo time_ago($knowledge['post_time']); ?></b>
                                <span><?php _e('Helpful'); ?> <em <?php echo($knowledge['post_like'] >= 0) ? '' : 'class="error"'; ?>><i class="fa fa-thumbs-o-up"></i> <?php echo $knowledge['post_like']; ?></em></span>
                            </p>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!--/knowledge-->
    <div class="our-team">
        <div class="container">
            <h2><?php _e('Our Support Team'); ?></h2>
            <div class="row">
                <?php for ($x = 1; $x <= 4; $x++) { ?>
                    <div class="col-md-3">
                        <div class="team">
                            <img src="<?php echo get_theme_option('team_photo_' . $x); ?>" alt="">
                            <h4>
                                <?php echo get_theme_option('team_name_' . $x); ?>
                                <span><?php echo get_theme_option('team_job_' . $x); ?></span>
                            </h4>
                            <p><?php echo get_theme_option('team_about_' . $x); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--/our-team-->
</div>