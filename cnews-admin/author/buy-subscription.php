<?php

use \CNEWS\News;
use \CNEWS\Category;
use \CNEWS\CNotices;
use \CNEWS\User;
use \CNEWS\Payments;


$posted_user = User::get_user();

if($posted_user['user_type'] == 'N/A'){
    $posted_user['user_type'] = 'Author';
}


Payments::post_payment();
cnews_admin_header_add();


?>

        <!-- Page Header-->
        <div class="page-header no-margin-bottom">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">CURATED NEWS SUBSCRIPTION</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">

                <div class="row my-3">
                    <!-- Basic Form-->
                    <div class="col-lg-12">
                        <div class="block">

                            <div class="title">
                                <strong class="d-block">SUBSCRIPTION DETAILS</strong>
                            </div>

                            <div class="block-body">


                                <form method="post" enctype="multipart/form-data" id="cnews-add-news">
                                    <?php

                                        cnews_nonce_field('cnews_nonce', 'cnews_nonce_action');

                                    ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Type</label>

                                                <select id="user-type" name="cnews_subscription[type]" required data-msg="Please select user type" class="sub-user-type custom-select">
                                                    <option value="Author|<?php echo User::get_prices('Author'); ?>" <?php echo cnews_get_value('user_type', $posted_user) == 'Author' ? 'selected' : ''; ?>>Author</option>
                                                    <option value="Reader|<?php echo User::get_prices('Reader'); ?>" <?php echo cnews_get_value('user_type', $posted_user) == 'Reader' ? 'selected' : ''; ?>>Reader</option>
                                                    <option value="Both|<?php echo User::get_prices('Both'); ?>" <?php echo cnews_get_value('user_type', $posted_user) == 'Both' ? 'selected' : ''; ?>>Reader & Author</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-none">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label class="form-control-label">Duration</label>
                                                <input value="1" type="number" min="1" step="1" max="5" name="cnews_subscription[years]" class="sub-years form-control">
                                            </div>
                                        </div>
                                        <div class="col-1 d-flex align-items-end">
                                            <span class="year-text mb-3">Year</span>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="alert alert-info">
                                                <h5>After Purchase:</h5>
                                                <p>
                                                    Your subscription will expire on
                                                    <span class="sub-date">
                                                        <?php
                                                            $expiry = $posted_user['subscription_expiry'] ? strtotime($posted_user['subscription_expiry']) : time();
                                                        ?>
                                                        <span data-year="<?php echo date('Y', $expiry); ?>">
                                                            <?php echo date('Y', strtotime("+364 Days", $expiry)); ?>
                                                        </span>-<?php echo date('m-d', strtotime("+364 Days", $expiry)); ?>
                                                    </span>
                                                </p>

                                                <h5 class="mt-3">Overview:</h5>

                                                <div class="row mt-2">
                                                    <div class="col-md-6"><strong>Per Year Price:</strong></div>
                                                    <div class="col-md-6 sub-per-year">$<?php echo User::get_prices(cnews_get_value('user_type', $posted_user)); ?></div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-6"><strong>Total Amount Payable:</strong></div>
                                                    <div class="col-md-6 sub-amount">$<?php echo User::get_prices(cnews_get_value('user_type', $posted_user)); ?></div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>


                                    <input type="hidden" name="data[cmd]" value="_xclick-subscriptions" />
                                    <input type="hidden" name="data[no_note]" value="1" />
                                    <input type="hidden" name="data[no_shipping]" value="1" />
                                    <input type="hidden" name="data[image_url]" value="<?php echo home_url('/static/images/logo-paypal.png'); ?>" />
                                    <input type="hidden" name="data[lc]" value="USA" />
                                    <input type="hidden" name="data[bn]" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                                    <input type="hidden" name="data[first_name]" value="<?php echo $posted_user['first_name']; ?>" />
                                    <input type="hidden" name="data[last_name]" value="<?php echo $posted_user['last_name']; ?>" />
                                    <input type="hidden" name="data[payer_email]" value="<?php echo $posted_user['email']; ?>" />
                                    <input type="hidden" name="data[item_number]" value="<?php echo $posted_user['user_type'].'|'.$posted_user['ID']; ?>" / >

                                    <div class="row">
                                        <div class="col-md-5 pay-pal-btn">

                                            <button type="submit" name="pay_with_paypal" title="Pay With PayPal"><img class="btn" src="<?php echo admin_dir_url("/img/paypal btn.png") ?>" alt=""></button>
<!--                                            <br>-->
<!--                                            <img src="--><?php //echo admin_dir_url("/img/paypal-down.png") ?><!--" alt="">-->
                                        </div>
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>


<?php cnews_admin_footer(); ?>