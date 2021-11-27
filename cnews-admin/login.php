<?php

use CNEWS\CError;
use CNEWS\User;
if(is_logged_in()){

    header('Location: '.'/news-list');
    exit();
}

$login_error = '';
$posted_user_name = '';
if(isset($_POST['cnews_login'])){
    if(!isset($_POST['cnews_nonce']) || !cnews_verify_nonce($_POST['cnews_nonce'], 'cnews_nonce_action')){
        die('Sorry, your nonce did not verify');
    }else{

        $user_name = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];
        $posted_user_name = $user_name;


        $user_login = User::login_user($user_name, $password);

        if($user_login instanceof CError){
            $login_error = $user_login;
        }else{
            $posted_user_name = '';
            header('Location: '.'/news-list');
            exit();
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
            <div class="col-lg-6">
              <div class="form d-flex align-items-center">
                <div class="content">

                <div class="row mb-3">
                    <div class="col-md-12">
                        <?php

                        if(is_object($login_error)){
                            ?>
                            <div class="alert alert-danger"><strong>Login Error! &nbsp;</strong><?php echo $login_error->getMessage(); ?></div>
                            <?php
                        }

                        ?>
                    </div>
                </div>

                  <form method="post" class="form-validate mb-4">

                      <?php

                      cnews_nonce_field('cnews_nonce', 'cnews_nonce_action');
                      ?>
                    <div class="form-group">
                      <input id="login-username" type="text" value="<?php echo $posted_user_name; ?>" name="loginUsername" required data-msg="Please enter your username" class="input-material">
                      <label for="login-username" class="label-material">User Name</label>
                    </div>
                    <div class="form-group">
                      <input id="login-password" type="password" name="loginPassword" required data-msg="Please enter your password" class="input-material">
                      <label for="login-password" class="label-material">Password</label>
                    </div>
                    <button type="submit" name="cnews_login" class="btn btn-primary">Login</button>
                  </form><a href="#" class="forgot-pass">Forgot Password?</a><br><small>Do not have an account? </small><a href="/signup" class="signup">Signup</a>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


<?php

include_once ('includes/footer-main.php'); ?>