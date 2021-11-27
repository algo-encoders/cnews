<?php

use \CNEWS\News;
use \CNEWS\Category;
use \CNEWS\CNotices;
use \CNEWS\User;


$edit_user = User::get_current_user_id();


User::update_profile();

$posted_user = array();
$is_edit = false;
if($edit_user){
   $is_edit = true;
}

$posted_user = MDB()->queryFirstRow("SELECT * FROM users WHERE ID = %i", $edit_user);


cnews_admin_header_add();


?>

    <!-- Page Header-->
    <div class="page-header no-margin-bottom">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">User Profile</h2>
        </div>
    </div>

    <section class="no-padding-top">
        <div class="container-fluid">

            <div class="row justify-content-center">

                <div class="col-md-12">

                    <div class="card text-white mb-3 cnews_login">

                        <div class="card-body p-5">

                            <?php CNotices::print_notices(); ?>
                            <br>
                            <form class="text-left form-validate" method="post" enctype="multipart/form-data">

                                <?php
                                cnews_nonce_field('cnews_nonce', 'cnews_nonce_action');

                                ?>
                                <input type="hidden" value="<?php echo cnews_get_value('ID', $posted_user); ?>" name="cnews_user[ID]">

                                <div class="form-group mb-5">
                                    <label for="register-fname" class="label-material">First Name</label>

                                    <input id="register-fname" type="text" value="<?php echo cnews_get_value('first_name', $posted_user); ?>" name="cnews_user[first_name]" required data-msg="Please enter your first name" class="form-control">
                                </div>
                                <div class="form-group mb-5">
                                    <label for="register-lastname" class="label-material">Last Name</label>

                                    <input id="register-lastname" type="text" value="<?php echo cnews_get_value('last_name', $posted_user); ?>" name="cnews_user[last_name]" required data-msg="Please enter your last name" class="form-control">
                                </div>
                                <div class="form-group mb-5">
                                    <label for="username" class="label-material">Username</label>

                                    <input id="username" disabled type="text" value="<?php echo cnews_get_value('user_name', $posted_user); ?>" name="cnews_user[user_name]" required data-msg="Please enter your username" class="form-control">
                                </div>
                                <div class="form-group mb-5">
                                    <label for="register-email" class="label-material">Email Address</label>

                                    <input id="register-email" type="email" value="<?php echo cnews_get_value('email', $posted_user); ?>" name="cnews_user[email]" required data-msg="Please enter a valid email address" class="form-control">
                                </div>
                                <div class="form-group mb-5">
                                    <label for="register-password" class="label-material">Password</label>

                                    <input id="register-password" type="password" name="cnews_user[password]" class="form-control">
                                </div>
                                <div class="form-group mb-5">
                                    <label for="register-cpassword" class="label-material">Confirm Password</label>

                                    <input id="register-cpassword" type="password" equalto="#register-password" name="cnews_user[c_password]" class="form-control">
                                </div>
                                <div class="form-group mb-5">
                                    <label for="user-type" class="label-material">User Type</label>


                                    <select disabled="disabled" id="user-type" name="cnews_user[user_type]" required data-msg="Please select user type" class="custom-select">
                                        <option value="Author" <?php echo cnews_get_value('user_type', $posted_user) == 'Author' ? 'selected' : ''; ?>>Author</option>
                                        <option value="Reader" <?php echo cnews_get_value('user_type', $posted_user) == 'Reader' ? 'selected' : ''; ?>>Reader</option>
                                        <option value="Both" <?php echo cnews_get_value('user_type', $posted_user) == 'Both' ? 'selected' : ''; ?>>Reader & Author</option>
                                    </select>

                                </div>

                                <hr>

                                <div class="form-group row">
                                    
                                    <div class="col-6">
                                        <label class="form-control-label">User Profile Image</label>
                                        <input type="file" id="filer_input" name="user_profile_image" class="form-control">
                                    </div>
                                    
                                    <div class="col-6 profile_image">
                                        <?php

                                        $profile_image =  cnews_get_value('profile_image', $posted_user);
                                        if($profile_image){
                                            $profile_image = home_url().$profile_image;
                                        }else{
                                            $profile_image = cnews_placeholder_image();
                                        }

                                        ?>

                                        <img class="featured_image" src="<?php echo $profile_image; ?>" alt="" style="width: 100px; height: 100px;">

                                    </div>
                                   

                                </div>

                                <div class="form-group">
                                    <input id="register" type="submit" name="cnews-update-profile" value="Update Profile" class="btn btn-primary btn-lg">
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