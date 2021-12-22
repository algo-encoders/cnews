<?php

use CNEWS\CError;
use CNEWS\User;
use CNEWS\CNotices;
use CNEWS\News;

User::check_subscription();

if(!is_logged_in()){

    header('Location: '.'/login');
    exit();
}


$all_published_news = News::all_published_news();


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
                                <div class="col-md-12 text-white">
                                    <h2>HI, <?php echo $current_user['first_name']; ?></h2>
                                    <p><strong>Here's your news feed....</strong></p>
                                </div>
                            </div>

                            <div class="row mt-3 ml-3">
                                <div class="col-md-7">

                                    <?php

                                    if(!empty($all_published_news)):

                                        foreach($all_published_news as $news_key => $news){

                                            $saved_news = isset($news['saved_news']) && $news['saved_news'] > 0;

                                            ?>

                                            <div class="row mb-5 cnews-single-loop cnews-<?php echo $news['ID']; ?>" data-news="<?php echo $news['ID']; ?>" data-title="<?php echo $news['news_title']; ?>">
                                                <div class="col-md-2 text-right" >
                                                    <?php
                                                    if($news['featured_image']):

                                                    else:
                                                        $news['featured_image'] = cnews_placeholder_image();
                                                    endif;
                                                    ?>
                                                    <img src="<?php echo $news['featured_image']; ?>" style="width: 100%; alt="">
                                                </div>
                                                <div class="col-md-10" style="min-height: 110px;">
                                                    <h2 class="cnews-title"><a href="/single-news/<?php echo $news['slug']; ?>" class="text-white"><?php echo $news['news_title']; ?></a></h2>
                                                    <div>
                                                        <small class="text-success">
                                                            <i class="fa fa-user"></i> <?php echo $news['first_name'].' '.$news['last_name']; ?> &nbsp;&nbsp;&nbsp;
                                                        </small>
                                                        <small>
                                                            <i class="fa fa-bookmark text-white news-action news-save <?php echo $saved_news ? 'text-warning' : ''; ?>" data-action="save" title="Save News For Letter Reading"></i> &nbsp;&nbsp;
                                                            <i class="fa fa-share text-white news-action news-share" data-action="share" title="Share news to your friend"></i>&nbsp;&nbsp;
                                                        </small>

                                                        <small class="text-white"><?php echo $news['cat_title']; ?></small> <small class="text-white"> > </small><small class="text-white"><?php echo $news['sub_cat_title']; ?></small>
                                                    </div>

                                                    <p style="font-size: 12px; font-weight: normal;" class="text-white mt-3">
                                                        <?php echo $news['excerpt']; ?>
                                                    </p>


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

                        <?php
                    }
                ?>


            </div>
        </section>

    </main>
    <!--====== MAIN PART END ======-->


    <!-- Modal -->
    <div class="modal fade" id="send_news_modal" tabindex="-1" role="dialog" aria-labelledby="send_news_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="send_news_modal">Share News to Readers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p class="my-2 modal-notices">

                    </p>

                    <p><h5 style="display: inline;">News Title:</h5> <span class="modal-news-title"></span></p>

                    <div class="form-group">
                        <label class="form-control-label">Please Enter Curated User Name or Email to Share This News.</label>
                        <input type="hidden" id="shared_news">
                        <input type="text" id="cnews_model_user" placeholder="User Name Or Email" class="form-control">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary reader_share_news">Share</button>
                </div>
            </div>
        </div>
    </div>

<?php
//cnews_footer();
?>

<?php cnews_admin_footer(); ?>
