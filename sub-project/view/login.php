<?php

use CNEWS\CError;
use CNEWS\User;
if(is_logged_in()){

    header('Location: '.'/admin');
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
            if(User::current_user_can('author') || User::current_user_can('admin')){
                header('Location: '.'/admin');
                exit();
            }else{
                header('Location: '.'/news-reader');
                exit();
            }

        }

    }
}

cnews_header();
?>

    <!--====== MAIN PART START ======-->
    <main>
        <!--======  Curated News platform START ======-->
        <section id="News_platform">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-md-7">

                        <div class="card text-white mb-3 cnews_login">
                            <div class="card-header">Login</div>
                            <div class="card-body p-5">

                                <?php

                                if(is_object($login_error)){
                                    ?>
                                    <div class="alert alert-danger"><strong>Login Error! &nbsp;</strong><?php echo $login_error->getMessage(); ?></div>
                                    <?php
                                }

                                ?>

                                <form method="post" class="form-validate mb-4">

                                    <?php

                                    cnews_nonce_field('cnews_nonce', 'cnews_nonce_action');
                                    ?>
                                    <div class="form-group mb-5">
                                        <label for="login-username" class="label-material">User Name</label>
                                        <input id="login-username" type="text" value="<?php echo $posted_user_name; ?>" name="loginUsername" required data-msg="Please enter your username" class="form-control">
                                    </div>
                                    <div class="form-group mb-5">
                                        <label for="login-password" class="label-material">Password</label>
                                        <input id="login-password" type="password" name="loginPassword" required data-msg="Please enter your password" class="form-control">
                                    </div>
                                    <button type="submit" name="cnews_login" class="btn btn-primary btn-lg">Login</button>
                                </form>
                                <a href="#" class="forgot-pass">Forgot Password?</a>
                                <br>
                                <small>Do not have an account? </small><a href="/signup" class="signup">Signup</a>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    </main>
    <!--====== MAIN PART END ======-->

<?php
cnews_footer();
?>