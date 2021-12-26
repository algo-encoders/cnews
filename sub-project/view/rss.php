<?php

use CNEWS\CError;
use CNEWS\User;
use CNEWS\CNotices;
use CNEWS\News;
use CNEWS\Category;

User::check_subscription();

if(!is_logged_in()){

    header('Location: '.'/login');
    exit();
}


News::import_rss_to_db();

$all_published_news = News::rss_query();
$pagination_data = News::get_rss_pagination_data();



//cnews_header();
cnews_admin_header_add();
?>

    <!--====== MAIN PART START ======-->
    <main>
        <!--======  Curated News platform START ======-->
        <section id="News_platform">
            <div class="container">
                <div class="row mt-3">

                    <div class="col-md-12">

                        <?php

                            if(!User::current_user_can('reader')){

                                CNotices::add_notice('not_allowed_page', 'error');
                                CNotices::print_notices();
                            }

                        ?>

                    </div>

                </div>

                <?php
                    if(User::current_user_can('reader')){
                        $current_user = User::get_user();

                        ?>

                            <div class="cnews_section">

                            <div class="row ">
                                <div class="col-md-6 text-white">
                                    <h2>HI, <?php echo $current_user['first_name']; ?></h2>
                                    <p><strong>Here's your news feed....</strong></p>
                                </div>

                            </div>

                            <form action="/rss" method="get">

                                <div class="row col-md-12">

                                    <div class="col-md-3">

                                        <?php

                                        Category::get_rss_filter('Topic');

                                        ?>

                                    </div>

                                    <div class="col-md-3">

                                        <?php

                                        Category::get_rss_filter('Source');

                                        ?>

                                    </div>


                                    <div class="col-md-3">

                                        <?php

                                        Category::get_rss_filter('Leaning');

                                        ?>

                                    </div>


                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary">Filter News</button>
                                    </div>

                                </div>

                            </form>

                            <div class="row mt-5 ml-3">
                                <div class="col-md-12 rss-container">

                                    <?php

                                    if(!empty($all_published_news)):

                                        News::rss_html($all_published_news);

                                    else:

                                        ?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-info">
                                                    No RSS news found
                                                </div>
                                            </div>
                                        </div>


                                    <?php

                                    endif;

                                    ?>

                                </div>
                            </div>


                                <div class="row rss_loading_row d-none" data-current="0" data-total="<?php echo $pagination_data['total_rss']; ?>" data-total_pages="<?php echo $pagination_data['total_pages'] - 1; ?>">
                                    <div class="col-md-12">
                                        <p class="text-center">Loading....</p>
                                    </div>
                                </div>
                        </div>

                        <?php
                    }
                ?>


            </div>
        </section>

    </main>
    <!--====== MAIN PART END ======-->


<?php
//cnews_footer();
?>

<?php cnews_admin_footer(); ?>
