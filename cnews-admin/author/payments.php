<?php

use \CNEWS\News;
use  \CNEWS\User;
use \CNEWS\CNotices;
use \CNEWS\Payments;

cnews_admin_header_add();

$current_user_id = User::get_current_user_id();

if(isset($_GET['payment_cancel'])){
    CNotices::add_notice('payment_cancel', 'error');
}else if(isset($_GET['payment_success'])){
    CNotices::add_notice('payment_success', 'success');
}




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

                            <div class="row mb-3">
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
                                        <th>Payment For</th>
                                        <th>Payment Date</th>
                                        <th>Subscription Expiry</th>
                                        <th>Purchased Year</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $payment_history = MDB()->query("SELECT * FROM payments where user_id=%i", User::get_current_user_id());

                                        if(!empty($payment_history)){
                                            foreach($payment_history as $index => $history):

                                                ?>

                                                <tr>
                                                    <th><?php echo $index + 1; ?></th>
                                                    <th><?php echo cnews_get_value('txnid', $history) ?></th>
                                                    <th><?php echo cnews_get_value('payment_title', $history) ?></th>
                                                    <th><?php echo date('Y-m-d', strtotime(cnews_get_value('payment_date', $history))) ?></th>
                                                    <th><?php echo date('Y-m-d', strtotime(cnews_get_value('expiry_date', $history))) ?></th>
                                                    <th><?php echo cnews_get_value('years', $history) ?></th>
                                                    <th>$<?php echo cnews_get_value('paid_amount', $history) ?></th>
                                                </tr>



                                            <?php
                                                endforeach;

                                        }
                                    ?>


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