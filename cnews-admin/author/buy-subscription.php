<?php

use \CNEWS\News;
use \CNEWS\Category;
use \CNEWS\CNotices;

cnews_admin_header_add();
News::post_news();

News::news_get_action();

$posted_news = CNotices::get_news_posted();
$is_edit = CNotices::get_is_news_edit();


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
                                                <input value="" type="text"  class="form-control" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label class="form-control-label">Duration</label>
                                                <input value="1" type="number" min="1" step="1" name="cnews_subscription[years]"   class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-1 d-flex align-items-end">
                                            <span class="year-text mb-3">Year</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label class="form-control-label">Total Amount Payable</label>
                                                <input value="15" type="text" disabled="disabled" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-1 d-flex align-items-end">
                                            <span class="year-text mb-3">USD</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 pay-pal-btn">

                                            <button type="submit" title="Pay With PayPal"><img class="btn" src="<?php echo admin_dir_url("/img/paypal btn.png") ?>" alt=""></button>
                                            <br>
                                            <img src="<?php echo admin_dir_url("/img/paypal-down.png") ?>" alt="">
                                        </div>
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You have to agree all terms and conditions
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Disagree</button>
                    <button type="button" class="btn btn-primary c_news_accept_terms">Agree</button>
                </div>
            </div>
        </div>
    </div>


<?php cnews_admin_footer(); ?>