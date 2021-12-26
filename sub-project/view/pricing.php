<?php

use CNEWS\CError;
use CNEWS\User;

cnews_header();
?>

    <!--====== MAIN PART START ======-->
    <main>
        <!--======  Curated News platform START ======-->


        <section id="News_platform">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                        if(isset($_GET['pricing_status'])){
                            ?>
                            <div class="alert alert-info">
                                Please purchase a plan to access protected content.
                            </div>
                            <?php
                        }

                        ?>
                    </div>
                </div>
            </div>


            <!-- pricing table  -->
            <section id="pricing-tables">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="single-table text-center">
                                <div class="plan-header">
                                    <h3>Reader</h3>
                                    <p>plan for Reader Only</p>
                                    <h4 class="plan-price">$15<span>/year</span></h4>
                                </div>
                                <a href="<?php echo User::get_payment_url('Reader'); ?>" class="plan-submit hvr-bounce-to-right">Subscribe Now</a>
                            </div>
                        </div>


                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="single-table text-center">
                                <div class="plan-header">
                                    <h3>Author</h3>
                                    <p>plan for Author Only</p>
                                    <h4 class="plan-price">$25<span>/year</span></h4>
                                </div>
                                <a href="<?php echo User::get_payment_url('Author'); ?>" class="plan-submit hvr-bounce-to-right">Subscribe Now</a>
                            </div>
                        </div>
<!--
                        <ul class="plan-features">
                            <li>10 Free PSD files</li>
                            <li>10 Free PSD files</li>
                            <li>10 Free PSD files</li>
                            <li>10 Free PSD files</li>
                            <li>10 Free PSD files</li>
                            <li>10 Free PSD files</li>
                        </ul>-->


                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="single-table text-center">
                                <div class="plan-header">
                                    <h3>Joint</h3>
                                    <p>plan for both Author & Reader</p>
                                    <h4 class="plan-price">$30<span>/year</span></h4>
                                </div>
                                <a href="<?php echo User::get_payment_url('Both'); ?>" class="plan-submit hvr-bounce-to-right">Subscribe Now</a>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <?php

                $pricing_breakdown = [
                    [
                        'pricing_details' => 'Read, save, and organize manipulation-proof news content',
                        'joint' => 'check',
                        'reader' => 'check',
                        'writer' => 'times',
                    ],
                    [
                        'pricing_details' => 'Import and curate other RSS feeds',
                        'joint' => 'check',
                        'reader' => 'check',
                        'writer' => 'times',
                    ],
                    [
                        'pricing_details' => 'Donate to curated writers with a portion of your subscription fee',
                        'joint' => 'check',
                        'reader' => 'check',
                        'writer' => 'times',
                    ],
                    [
                        'pricing_details' => 'Write, pre-plan, and publish news written for readers',
                        'joint' => 'check',
                        'reader' => 'times',
                        'writer' => 'check',
                    ],
                    [
                        'pricing_details' => 'Earn money through our content donation payment system',
                        'joint' => 'check',
                        'reader' => 'times',
                        'writer' => 'check',
                    ],
                    [
                        'pricing_details' => 'Customize your published content',
                        'joint' => 'check',
                        'reader' => 'times',
                        'writer' => 'check',
                    ],
                    [
                        'pricing_details' => 'Become a Curator!',
                        'joint' => 'check',
                        'reader' => 'check',
                        'writer' => 'check',
                    ]

                ];

            ?>



            <section class="pricing-details container">
                <div class="row mt-5">
                    <div class="col-md-12">
                        <h1 class="text-primary">What are you getting for your money?</h1>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3 col-6">
                        <h3 class="text-white"><i class="fa fa-check-circle text-success mr-2"></i> Included Feature(s)</h3>
                    </div>
                    <div class="col-md-3 col-6">
                        <h3 class="text-white"><i class="fa fa-times-circle text-danger mr-2"></i> Not Included</h3>
                    </div>
                </div>

                <div class="row mt-5 mb-3">
                    <div class="col-6"><h2 class="text-white">Pricing Break-down</h2></div>
                    <div class="col-2 text-center"><h2 class="text-white">Joint</h2></div>
                    <div class="col-2 text-center"><h2 class="text-white">Reader</h2></div>
                    <div class="col-2 text-center"><h2 class="text-white">Writer</h2></div>
                </div>

                <?php

                    foreach ($pricing_breakdown as $price):

                        ?>

                            <div class="row mt-5 text-white">
                                <div class="col-6"><?php echo $price['pricing_details']; ?></div>
                                <div class="col-2 text-center"><i class="fa fa-<?php echo $price['joint']; ?>-circle <?php echo $price['joint'] == 'check' ? 'text-success' : 'text-danger'; ?>"></i></div>
                                <div class="col-2 text-center"><i class="fa fa-<?php echo $price['reader']; ?>-circle <?php echo $price['reader'] == 'check' ? 'text-success' : 'text-danger'; ?>"></i></div>
                                <div class="col-2 text-center"><i class="fa fa-<?php echo $price['writer']; ?>-circle <?php echo $price['writer'] == 'check' ? 'text-success' : 'text-danger'; ?>"></i></div>
                            </div>

                        <?php

                    endforeach;

                ?>


            </section>

        </section>

    </main>
    <!--====== MAIN PART END ======-->


    <link rel="stylesheet" href="<?php echo home_url('/static/sass/main.css')?>">

<?php
cnews_footer();
?>