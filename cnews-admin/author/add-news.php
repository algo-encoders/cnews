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
                <h2 class="h5 no-margin-bottom">Add News</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">

                <div class="row my-3">
                    <!-- Basic Form-->
                    <div class="col-lg-12">
                        <div class="block">

                            <div class="title">
                                <strong class="d-block">News Content</strong>
                                <span class="d-block">Create an amazing news for your reader.</span>
                            </div>

                            <div class="block-body">

                                <div class="row cnews_notices my-3">
                                    <div class="col-md-12">
                                        <?php
                                            CNotices::print_notices();
                                        ?>
                                    </div>
                                </div>

                                <form method="post" enctype="multipart/form-data" id="cnews-add-news">
                                    <?php

                                        cnews_nonce_field('cnews_nonce', 'cnews_nonce_action');

                                        if($is_edit){
                                            $news_id = cnews_get_value('ID', $posted_news);
                                            echo "<input type='hidden' value='$news_id' class='cnews_id' name='c_news[ID]'>";
                                        }

                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label class="form-control-label">News Title</label>
                                                <input value="<?php echo cnews_get_value('news_title', $posted_news); ?>" type="text" name="c_news[news_title]" placeholder="News Title" class="form-control">

                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Category</label>

                                            <select name="c_news[category]" class="form-control mb-3 mb-3">
                                                <option value="">Select Category</option>
                                                <?php echo Category::get_categories_html(0, cnews_get_value('category', $posted_news)); ?>
                                            </select>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-control-label">Sub Category</label>

                                            <select name="c_news[sub_category]" class="form-control mb-3 mb-3">
                                                <option value="">Select Sub Category</option>
                                                <?php echo Category::get_categories_html(cnews_get_value('category', $posted_news, 0), cnews_get_value('sub_category', $posted_news)); ?>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label class="form-control-label">News Status</label>

                                                <select name="c_news[news_status]" class="form-control mb-3 mb-3">
                                                    <?php echo cnews_statuses_html(cnews_get_value('news_status', $posted_news))?>
                                                </select>

                                            </div>

                                            <div class="form-group">

                                                <label class="form-control-label">Published Date</label>

                                                <input value="<?php echo cnews_get_value('created_date', $posted_news); ?>" type="text"  placeholder="0000-00-00 00:00" class="form-control" id="cnews-pbulished-date" name="c_news[created_date]">

                                            </div>


                                            <div class="form-group">

                                                <label class="form-control-label">Featured Image</label>
                                                <input type="file" id="filer_input" name="cnews_featured_image" class="form-control">

                                            </div>


                                        </div>

                                        <div class="col-md-6">

                                            <?php
                                            if(cnews_get_value('featured_image', $posted_news)):
                                                $featured_image = cnews_get_value('featured_image', $posted_news);
                                            else:
                                                $featured_image = cnews_placeholder_image();
                                            endif;
                                            ?>

                                            <img class="featured_image" src="<?php echo $featured_image; ?>" alt="" style="width: 250px; height: auto;">
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="cnews_excerpt_input">
                                                <label class="form-control-label">News Excerpt (Summary)</label>
                                                <textarea name="c_news[excerpt]" maxlength="300" class="form-control" id="cnews_excerpt" cols="30" rows="5"><?php echo cnews_get_value('excerpt', $posted_news); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="cnews_content_input">
                                                <label class="form-control-label">News Content</label>
                                                <textarea name="c_news[news_content]" class="summernote form-control" id="cnews_content"><?php echo cnews_get_value('news_content', $posted_news); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary c-news-terms d-none" data-toggle="modal" data-target="#exampleModal">
                                            Launch demo modal
                                        </button>
                                        <button  class="cnews-latest-news-test btn btn-primary"><?php echo $is_edit ? 'Update News' : 'Create News'; ?></button>
                                        <input type="submit" name="cnews-latest-news" value="Create News" class="cnews-latest-news d-none btn btn-primary">
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