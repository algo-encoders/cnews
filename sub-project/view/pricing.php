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

            <section id="comparison" class="section container text-center">
                <h2 class="pb-8 text-left font-semibold text-interactive-04 leading-snug text-2.5xl sm:text-ds-h2">What are you getting for your money?</h2>
                <ul class="list-none flex-wrap flex p-0 mb-10">
                    <li class="flex mb-2 mr-5" style="width: 30%; color: white;">
                        <div class="chart__cell">
                            <svg class="chart__icon">
                                <use href="#checked"></use>
                            </svg>
                        </div>
                        <div class="text-left whitespace-nowrap font-semibold ml-2">Included Feature(s)</div>
                    </li>
                    <li class="flex mb-2 mr-5" style="width: 30%; color: white;" >
                        <div class="chart__cell">
                            <svg class="chart__icon">
                                <use href="#crossed"></use>
                            </svg>
                        </div>
                        <div class="text-left whitespace-nowrap font-semibold ml-2">Not Included</div>
                    </li>
                </ul>

                <svg xmlns="http://www.w3.org/2000/svg" style="width:0;height:0;position:absolute;">
                    <symbol id="checked" viewBox="0 0 37 37" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4314 36.7838C28.4986 36.7838 36.6597 28.6395 36.6597 18.5931C36.6597 8.5466 28.4986 0.402344 18.4314 0.402344C8.3642 0.402344 0.203125 8.5466 0.203125 18.5931C0.203125 28.6395 8.3642 36.7838 18.4314 36.7838Z" fill="#12A378"></path>
                        <path d="M11.7715 18.9428L15.978 22.4411L25.0921 13.3457" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                    </symbol>

                    <symbol id="crossed" viewBox="0 0 37 37" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4861 36.7838C28.5532 36.7838 36.7143 28.6395 36.7143 18.5931C36.7143 8.5466 28.5532 0.402344 18.4861 0.402344C8.41887 0.402344 0.257812 8.5466 0.257812 18.5931C0.257812 28.6395 8.41887 36.7838 18.4861 36.7838Z" fill="#EA3A0D"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M 13.3062 25.4118 C 12.9 25.818 12.2415 25.818 11.8354 25.4118 C 11.4292 25.0057 11.4292 24.3472 11.8354 23.941 L 17.2174 18.559 L 11.9646 13.3062 C 11.5585 12.9 11.5585 12.2415 11.9646 11.8354 C 12.3708 11.4292 13.0292 11.4292 13.4354 11.8354 L 18.6882 17.0882 L 23.941 11.8354 C 24.3472 11.4292 25.0057 11.4292 25.4118 11.8354 C 25.818 12.2415 25.818 12.9 25.4118 13.3062 L 20.159 18.559 L 25.541 23.941 C 25.9472 24.3472 25.9472 25.0057 25.541 25.4118 C 25.1349 25.818 24.4764 25.818 24.0703 25.4118 L 18.6882 20.0298 L 13.3062 25.4118 Z" stroke="white" fill="white"></path>
                    </symbol>

                    <symbol id="limited" viewBox="0 0 37 37" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4314 36.7838C28.4986 36.7838 36.6597 28.6395 36.6597 18.5931C36.6597 8.5466 28.4986 0.402344 18.4314 0.402344C8.3642 0.402344 0.203125 8.5466 0.203125 18.5931C0.203125 28.6395 8.3642 36.7838 18.4314 36.7838Z" fill="#F5C518"></path>
                        <path d="M 28.7 17 H 10.3 C 9.6 17 9 17.6 9 18.3 C 9 19 9.6 19.6 10.3 19.6 H 28.8 C 29.4 19.5 30 19 30 18.3 C 30 17.6 29.4 17 28.7 17 Z" stoke="white" stroke-width="3" fill="white"></path>
                    </symbol>
                </svg>


                <div class="chart">
                    <div class="chart__row chart__header">
                        <p class="chart__heading">Pricing Break-down</p>
                        <div class="chart__cell-group">
                            <div class="chart__cell chart__browser-name">
                                <span>Joint</span>
                            </div>
                            <div class="chart__cell chart__browser-name">
                                <span>Reader</span>
                            </div>
                            <div class="chart__cell chart__browser-name">
                                <span>Writer</span>
                            </div>
                        </div>
                    </div>

                    <div class="chart__row">
                        <p class="chart__heading">Read, save, and organize manipulation-proof news content</p>
                        <div class="chart__cell-group">
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#crossed"></use>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="chart__row">
                        <p class="chart__heading">Import and curate other RSS feeds</p>
                        <div class="chart__cell-group">
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#crossed"></use>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="chart__row">
                        <p class="chart__heading">Donate to curated writers with a portion of your subscription fee</p>
                        <div class="chart__cell-group">
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#crossed"></use>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="chart__row">
                        <p class="chart__heading">Write, pre-plan, and publish news written for readers</p>
                        <div class="chart__cell-group">
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#crossed"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="chart__row">
                        <p class="chart__heading">Earn money through our content donation payment system</p>
                        <div class="chart__cell-group">
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#crossed"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="chart__row">
                        <p class="chart__heading">Customize your published content</p>
                        <div class="chart__cell-group">
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#crossed"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="chart__row">
                        <p class="chart__heading">Become a Curator!</p>
                        <div class="chart__cell-group">
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
                            </div>
                            <div class="chart__cell">
                                <svg class="chart__icon">
                                    <use href="#checked"></use>
                                </svg>
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