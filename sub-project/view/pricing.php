<?php

use CNEWS\CError;
use CNEWS\User;

cnews_header();
?>

    <!--====== MAIN PART START ======-->
    <main>
        <!--======  Curated News platform START ======-->
        <section id="News_platform">

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
                                <a href="/signup?user_type=Reader" class="plan-submit hvr-bounce-to-right">Subscribe Now</a>
                            </div>
                        </div>


                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="single-table text-center">
                                <div class="plan-header">
                                    <h3>Author</h3>
                                    <p>plan for Author Only</p>
                                    <h4 class="plan-price">$25<span>/year</span></h4>
                                </div>
                                <a href="/signup?user_type=Author" class="plan-submit hvr-bounce-to-right">Subscribe Now</a>
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
                                <a href="/signup?user_type=Both" class="plan-submit hvr-bounce-to-right">Subscribe Now</a>
                            </div>
                        </div>

                    </div>

                </div>
            </section>


        </section>

    </main>
    <!--====== MAIN PART END ======-->


    <link rel="stylesheet" href="<?php echo home_url('/static/sass/main.css')?>">

<?php
cnews_footer();
?>