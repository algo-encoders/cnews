<?php

use CNEWS\CError;
use CNEWS\User;
use CNEWS\CNotices;
use CNEWS\News;

if(!is_logged_in()){

    header('Location: '.'/login');
    exit();
}
global $news_slug;

$single_news = News::get_news_by_slug($news_slug);

$all_published_news = !empty($single_news) ? [$single_news] : [];


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

                <div class="cnews_section" style="margin-bottom: 200px;">
                    <div class="row">
                        <div class="col-md-7">

                    <?php

                        if(!empty($all_published_news)):

                            foreach($all_published_news as $news_key => $news){
                                ?>

                                <div class="row mb-3">
                                    <div class="col-md-12" >
                                        <?php
                                            if($news['featured_image']):

                                            else:
                                                $news['featured_image'] = cnews_placeholder_image();
                                            endif;
                                        ?>
                                        <img src="<?php echo $news['featured_image']; ?>" style="width: 75%; alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="min-height: 110px;">
                                        <h2 class="cnews-title"><a class="text-white"><?php echo $news['news_title']; ?></a></h2>
                                        <div>
                                            <small class="text-success"><i class="fa fa-user"></i> <?php echo $news['first_name'].' '.$news['last_name']; ?> &nbsp;&nbsp; </small>
                                            <small class="text-white"><?php echo $news['cat_title']; ?></small> <small class="text-white"> > </small><small class="text-white"><?php echo $news['sub_cat_title']; ?></small>
                                        </div>

                                        <div class="news_content mt-5">
                                            <?php echo $news['news_content']; ?>
                                        </div>


                                    </div>


                                </div>

                                <?php
                            }

                        else:

                            ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        No published news found
                                    </div>
                                </div>
                            </div>


                            <?php

                        endif;

                    ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <!--====== MAIN PART END ======-->

<?php
//cnews_footer();
?>

<?php cnews_admin_footer(); ?>
