<?php

use \CNEWS\Category;
use \CNEWS\CNotices;
use \CNEWS\User;

User::check_subscription();
$current_user = User::get_user();

if($current_user['user_type'] == 'Author' || $current_user['user_type'] == 'Joint' || $current_user['user_type'] == 'Both'){

}else{
    header('Location: '.'/login');
    exit;
}

cnews_admin_header_add();

Category::post_category();




$cat_posted_data = CNotices::get_cat_posted();

$is_edit = cnews_get_value('ID', $cat_posted_data) > 0;
$edit_id = cnews_get_value('ID', $cat_posted_data);
$cat_list_parent = Category::get_categories_parent();


?>

        <!-- Page Header-->
        <div class="page-header no-margin-bottom">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">Categories</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container">

                <div class="row my-3">
                    <!-- Basic Form-->
                    <div class="col-lg-12">
                        <div class="block">

                            <div class="title">
                                <strong class="d-block">Add New Category</strong>
                            </div>


                            <?php if(CNotices::is_notices()): ?>

                                <div class="row my-5">
                                    <div class="col-md-12">
                                        <?php
                                            CNotices::print_notices();
                                        ?>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <div class="block-body">
                                <form method="post" enctype="multipart/form-data" id="cnews-add-category">
                                    <?php

                                        cnews_nonce_field('cnews_nonce', 'cnews_nonce_action');
                                        if($is_edit){

                                            ?>
                                                <input type="hidden" class="cnews_id" name="c_news_cat[ID]" value="<?php echo cnews_get_value('ID', $cat_posted_data); ?>">
                                            <?php
                                        }

                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label class="form-control-label">Title</label>
                                                <input value="<?php echo cnews_get_value('title', $cat_posted_data); ?>" type="text" name="c_news_cat[title]" placeholder="Title" class="form-control" required>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-6">

                                            <div class="mb-3">

                                                <label class="form-control-label">Parent Category</label>
                                                <select name="c_news_cat[parent]" class="form-control mb-3 mb-3" required>
                                                    <option value="0">No Parent</option>
                                                    <?php if(!empty($cat_list_parent)): ?>

                                                        <?php

                                                        $selected = cnews_get_value('parent', $cat_posted_data);
                                                        foreach ($cat_list_parent as $parent_cat):

                                                            $disabled = $is_edit && $edit_id == $parent_cat['ID'] ? 'disabled' : '';

                                                            $selected_str = $selected == $parent_cat['ID'] ? 'selected' : '';

                                                            echo "<option $selected_str $disabled value='{$parent_cat['ID']}'>{$parent_cat['title']}</option>";

                                                        endforeach;
                                                        ?>

                                                    <?php endif; ?>
                                                </select>

                                            </div>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <div class="cnews_excerpt_input">
                                                <label class="form-control-label">Description</label>
                                                <textarea name="c_news_cat[description]" class="form-control" id="cnews_description" cols="30" rows="2"><?php echo cnews_get_value('description', $cat_posted_data); ?></textarea>
                                            </div>

                                        </div>

                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-md-12">

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <input type="submit"  value="<?php echo $is_edit ? 'Update Category' : 'Create Category'; ?>" name="cnews_save_category" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>

                            <hr>

                            <form method="post" enctype="multipart/form-data" id="cnews-action-category">

                                <?php

                                    cnews_nonce_field('cnews_nonce', 'cnews_nonce_action');

                                ?>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">

                                            <label class="form-control-label">All Categories</label>
                                            <select name="cnews_action_category" class="form-control mb-3 mb-3" required>

                                                <option value="">Select Category</option>

                                                <?php if(!empty($cat_list_parent)): ?>

                                                    <?php

                                                        foreach ($cat_list_parent as $parent_cat):

                                                            echo "<option value='{$parent_cat['ID']}'>{$parent_cat['title']}</option>";

                                                            if(!empty($parent_cat['child'])):

                                                                foreach($parent_cat['child'] as $child_cat):

                                                                    echo "<option value='{$child_cat['ID']}'> - {$child_cat['title']}</option>";

                                                                endforeach;

                                                            endif;

                                                        endforeach;
                                                    ?>

                                                <?php endif; ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label class="form-control-label">Action</label>

                                            <div>
                                                <button type="submit" class="btn btn-sm btn-primary cat_action" name="cnews_action_edit" >Edit</button>
                                                <button type="submit" class="btn btn-sm btn-danger cat_action" name="cnews_action_delete">Delete</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </section>


<?php cnews_admin_footer(); ?>