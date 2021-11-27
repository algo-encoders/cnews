<?php

use \CNEWS\User;
use \CNEWS\CNotices;

$register_error = null;

$posted_user = array();

if(isset($_POST['cnews_user'])){

    if(!isset($_POST['cnews_nonce']) || !cnews_verify_nonce($_POST['cnews_nonce'], 'cnews_nonce_action')){

        die('Sorry, your nonce did not verify');

    }else{

        $cnews_user = $_POST['cnews_user'];

        $posted_user = $cnews_user;

        if(!empty($cnews_user)){
            $all_values_check = array();

            foreach($cnews_user as $key => $value){
                if(!$value){
                    $all_values_check[] = $key;
                }
            }

            if(empty($all_values_check)){

                if($cnews_user['password'] == $cnews_user['c_password']){

                    $user_update = USER::update_user($cnews_user);

                    if($user_update instanceof \CNEWS\CError){

                        CNotices::add_notice($user_update->getCode(), 'error');

                    }else{

                        if($user_update){
                            CNotices::add_notice('register_success', 'success');
                            $posted_user = array();
                        }else{
                            CNotices::add_notice('process_problem', 'error');
                        }

                    }

                }else{
                    CNotices::add_notice('password_not_match', 'error');
                }

            }else{
                CNotices::add_notice('fill_required_fields', 'error');
            }
        }


    }


}

include_once ('includes/header-main.php');




?>
    <div class="login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>Dashboard</h1>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center mb-3">
                <div class="content">

                    <?php CNotices::print_notices(); ?>
                  <form class="text-left form-validate" method="post">

                    <?php
                         cnews_nonce_field('cnews_nonce', 'cnews_nonce_action');
                    ?>

                    <div class="form-group-material">
                        <input id="register-fname" type="text" value="<?php echo cnews_get_value('first_name', $posted_user); ?>" name="cnews_user[first_name]" required data-msg="Please enter your first name" class="input-material">
                        <label for="register-fname" class="label-material">First Name</label>
                    </div>
                    <div class="form-group-material">
                      <input id="register-lastname" type="text" value="<?php echo cnews_get_value('last_name', $posted_user); ?>" name="cnews_user[last_name]" required data-msg="Please enter your last name" class="input-material">
                      <label for="register-lastname" class="label-material">Last Name</label>
                    </div>
                    <div class="form-group-material">
                      <input id="username" type="text" value="<?php echo cnews_get_value('user_name', $posted_user); ?>" name="cnews_user[user_name]" required data-msg="Please enter your username" class="input-material">
                      <label for="username" class="label-material">Username</label>
                    </div>
                    <div class="form-group-material">
                      <input id="register-email" type="email" value="<?php echo cnews_get_value('email', $posted_user); ?>" name="cnews_user[email]" required data-msg="Please enter a valid email address" class="input-material">
                      <label for="register-email" class="label-material">Email Address</label>
                    </div>
                    <div class="form-group-material">
                      <input id="register-password" type="password" name="cnews_user[password]" required data-msg="Please enter your password" class="input-material">
                      <label for="register-password" class="label-material">Password</label>
                    </div>
                    <div class="form-group-material">
                      <input id="register-cpassword" type="password" name="cnews_user[c_password]" required data-msg="Please confirm your password" class="input-material">
                      <label for="register-cpassword" class="label-material">Confirm Password</label>
                    </div>
                    <div class="form-group-material">
                        <label for="user-type" class="label-material">User Type</label>

                      <select id="user-type" name="cnews_user[user_type]" required data-msg="Please select user type" class="custom-select">
                          <option value="Author" <?php echo cnews_get_value('user_type', $posted_user) == 'Author' ? 'selected' : ''; ?>>Author</option>
                          <option value="Reader" <?php echo cnews_get_value('user_type', $posted_user) == 'Reader' ? 'selected' : ''; ?>>Reader</option>
                      </select>

                    </div>
                    <div class="form-group terms-conditions text-center">
                      <input id="register-agree" name="registerAgree" type="checkbox" required value="1" data-msg="Your agreement is required" class="checkbox-template">
                        <label for="register-agree">I agree with the <a href="/termsandconditions">terms and policy</a></label>
                    </div>

                    <div class="form-group text-center">
                      <input id="register" type="submit" value="Register" class="btn btn-primary">
                    </div>

                  </form><small>Already have an account? </small><a href="/login" class="signup">Login</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p class="d-none">Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a></p>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
      </div>
    </div>


<?php

include_once ('includes/footer-main.php'); ?>