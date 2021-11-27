<?php


if(!CNEWS_DIR){ die('Go through proper way');}

require_once('modal/class-options.php');
require_once('modal/class-user.php');

require_once('modal/class-notices.php');
require_once('modal/CError.php');

require_once('modal/class-news.php');
require_once('modal/class-category.php');



require_once('lib/MeekroDB.php');

use CNEWS\CError;
use CNEWS\User;
use CNEWS\Options;
use CNEWS\CNotices;

if(!function_exists('cnews_db_init')){
    function cnews_db_init(){
        DB::$host = 'localhost';
        DB::$dbName = 'qtcsmaia_cnews';
        DB::$password = 'cnews786&*^';
        DB::$user = 'qtcsmaia_cnews';

        new MeekroDB();
    }
}


if(!function_exists('MDB')){
    function MDB(){
        $mdb = DB::getMDB();
        return $mdb;
    }
}

if(!function_exists('pree')){
    function pree($d){
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }
}


if(!function_exists('home_url')){
    function home_url($path = ''){
        return 'https://cnews.learndigital.cyou'.$path;
    }
}

if(!function_exists('home_path')){
    function home_path($path = ''){
        return CNEWS_DIR.$path;
    }
}

if(!function_exists('admin_dir_url')){
    function admin_dir_url($sub_path){
        return home_url('/cnews-admin').$sub_path;
    }
}

if(!function_exists('is_logged_in')){
    function is_logged_in(){
        return User::is_user_logged_in();
    }
}

if(!function_exists('cnews_admin_header')){
    function cnews_admin_header(){
        include_once (CNEWS_DIR.'/cnews-admin/includes/header.php');
    }
}

if(!function_exists('cnews_admin_header_add')){
    function cnews_admin_header_add(){
        include_once (CNEWS_DIR.'/cnews-admin/includes/header-main.php');
    }
}

if(!function_exists('cnews_admin_footer')){
    function cnews_admin_footer(){
        include_once (CNEWS_DIR.'/cnews-admin/includes/footer-main.php');
    }
}

if(!function_exists('cnews_admin_sidebar')){
    function cnews_admin_sidebar(){
        include_once (CNEWS_DIR.'/cnews-admin/includes/sidebar-main.php');
    }
}

if(!function_exists('cnews_header')){
    function cnews_header(){
        include_once (CNEWS_DIR.'/header.php');
    }
}

if(!function_exists('cnews_footer')){
    function cnews_footer(){
        include_once (CNEWS_DIR.'/footer.php');
    }
}

if(!function_exists('cnews_get_value')){
    function cnews_get_value($key, $array, $default = ''){

        $array = is_array($array) ? $array : array();
        $value = array_key_exists($key, $array) ? $array[$key] : $default;
        if(is_array($default)):
            $value = is_array($default) && is_array($value) ? $value : $default;
        endif;
        return $value;

    }
}

if(!function_exists('cnews_create_nonce')){
    function cnews_create_nonce($action = -1){
        $session_id = '22222';
        return substr(md5($session_id.'|'.$action), 0, 10);
    }
}

if(!function_exists('cnews_verify_nonce')){
    function cnews_verify_nonce($nonce, $action = -1){
        $session_id = '22222';
        $current_nonce = substr(md5($session_id.'|'.$action), 0, 10);
        return $nonce == $current_nonce;
    }
}

if(!function_exists('cnews_nonce_field')){
    function cnews_nonce_field($field, $action = -1){
        ?>
        <input type="hidden" name="<?php echo $field; ?>" value="<?php echo cnews_create_nonce($action); ?>">
        <?php
    }
}

if(!function_exists('cnews_db_time_stamp')){
    function cnews_db_time_stamp($u_time){
        return date('Y-m-d H:i:s', $u_time);
    }
}

if(!function_exists('cnews_statuses')){
    function cnews_statuses(){

        return [
          'draft' => 'Draft',
          'published' => 'Published',
          'approved' => 'Approved',
          'not_approved' => 'Not Approved',
        ];
    }
}


if(!function_exists('cnews_statuses_html')){
    function cnews_statuses_html($selected){

        $statuses = cnews_statuses();

        if(!empty($statuses)){
            foreach($statuses as $key => $status){
                if(User::current_user_can('author')){
                    $author_skip = ['approved', 'not_approved'];

                    if(in_array($key, $author_skip)){continue;}

                }

                $selected = $key == $selected ? 'selected' : '';
                echo "<option value='$key' $selected>$status</option>";
            }
        }
    }
}

if(!function_exists('cnews_placeholder_image')){
    function cnews_placeholder_image(){
        return home_url('/cnews-admin/img/placeholder.png');
    }
}




//echo password_hash('test', PASSWORD_BCRYPT); exit;
//init code here


cnews_db_init();



