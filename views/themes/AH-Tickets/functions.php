<?php
/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

function siteTitle() {
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 'home') {
            echo Site_Name . ' | خانه';
        } elseif ($_GET['page'] == 'login') {
            echo Site_Name . ' | ورود';
        } elseif ($_GET['page'] == 'register') {
            echo Site_Name . ' | ثبت نام';
        } elseif ($_GET['page'] == 'forgot-password') {
            echo Site_Name . ' | فراموشی کلمه عبور';
        } elseif ($_GET['page'] == 'active_user') {
			if(isset($_GET['user_id'])){
				echo Site_Name . '| فعالسازی حساب کاربری';
			}
            else if (isset($_GET['user_key'])) {
                if (!empty($_GET['user_key'])) {
                    echo Site_Name . ' | فعالسازی حساب کاربری';
                } else {
                    echo Site_Name . ' | کد خالی است';
                }
            } else {
                echo 'صفحه پیدا نشد';
            }
        } elseif ($_GET['page'] == 'create-ticket') {
            echo Site_Name . ' | ایجاد تیکت جدید';
        } elseif ($_GET['page'] == 'create-sms') {
            echo Site_Name . ' | ارسال پیامک';
        } elseif ($_GET['page'] == 'view-sms') {
            echo Site_Name . ' | مشاهده پیامک';
        } elseif ($_GET['page'] == 'view-ticket') {
            if (!empty($_GET['id'])) {
                $ticket = view_ticket();
                echo Site_Name . ' | ' . $ticket['subject'];
            } else {
                echo 'صفحه پیدا نشد';
            }
        } else {
            echo 'صفحه پیدا نشد';
        }
    } elseif (isset($_GET['main'])) {
        if (isset($_GET['sub_page'])) {
            if ($_GET['sub_page'] == 'department') {
                echo Site_Name . ' | دپارتمان';
            } else if ($_GET['sub_page'] == 'knowledge') {
                echo Site_Name . ' | اخبار و اطلاعیه';
            } else if ($_GET['sub_page'] == 'about') {
                echo Site_Name . ' | درباره ما';
            } else if ($_GET['sub_page'] == 'contact') {
                echo Site_Name . ' | تماس با ما';
            } else {
                echo Site_Name . ' | صفحه پیدا نشد';
            }
        } else {
            echo Site_Name . ' | صفحه اصلی';
        }
    } else {
        echo Site_Name;
    }
}

function reply_rate($rate, $is_admin, $id, $is_user) {
    if ($is_admin == 1 or $is_admin == 2) {
        if ($rate == 0) {
            if ($is_user == 0) {
                ?>
                <div class="rate">
                    <div class="form-group">
                        <div class="rating rating-sm star">
                            <span class="control-label control-label-sm"><?php _e('Rate') ?></span>
                            <div class="rating-wrapper">
                                <input type="radio" name="reply-rate-<?php echo $id; ?>" id="star-rating-5-<?php echo $id; ?>" value="5">
                                <label class="fa fa-star" for="star-rating-5-<?php echo $id; ?>"></label>
                                <input type="radio" name="reply-rate-<?php echo $id; ?>" id="star-rating-4-<?php echo $id; ?>" value="4">
                                <label class="fa fa-star" for="star-rating-4-<?php echo $id; ?>"></label>
                                <input type="radio" name="reply-rate-<?php echo $id; ?>" id="star-rating-3-<?php echo $id; ?>" value="3">
                                <label class="fa fa-star" for="star-rating-3-<?php echo $id; ?>"></label>
                                <input type="radio" name="reply-rate-<?php echo $id; ?>" id="star-rating-2-<?php echo $id; ?>" value="2">
                                <label class="fa fa-star" for="star-rating-2-<?php echo $id; ?>"></label>
                                <input type="radio" name="reply-rate-<?php echo $id; ?>" id="star-rating-1-<?php echo $id; ?>" value="1">
                                <label class="fa fa-star" for="star-rating-1-<?php echo $id; ?>"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="rate">
                    <div class="rate-rang" data-value="<?php echo $rate; ?>">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                </div> 
                <?php
            }
        } else {
            ?>
            <div class="rate">
                <div class="rate-rang" data-value="<?php echo $rate; ?>">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
            </div> 
            <?php
        }
    }
}

function check_like($id) {
    if (isset($_COOKIE['is_post_' . $id . '_like'])) {
        return TRUE;
    }
}
