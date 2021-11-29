<?php

use \CNEWS\News;
use  \CNEWS\User;
use \CNEWS\CNotices;
use \CNEWS\Payments;

cnews_admin_header_add();

$current_user_id = User::get_current_user_id();

?>

        <!-- Page Header-->
        <div class="page-header no-margin-bottom">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">Payments</h2>

            </div>
        </div>


        <section class="mt-3">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <a class="btn btn-primary btn-sm" href="/buy-subscription">Buy Subscription</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="block margin-bottom-sm">
                            <div class="title"><strong>Payments History</strong></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <?php CNotices::print_notices(); ?>
                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Payment ID</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                        <th>Payment For</th>
                                        <th>Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>




                            </div>


                        </div>
                    </div>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<?php cnews_admin_footer(); ?>