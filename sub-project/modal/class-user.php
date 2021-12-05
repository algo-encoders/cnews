<?php

namespace CNEWS;

class User
{
    private $ID;
    private $first_name;
    private $last_name;
    private $user_name;
    private $email;
    private $password;
    private $user_type;
    private $is_active;
    private $subscription_status;
    private $subscription_expiry;
    private $join_date;
    public static $current_user;
    private $profile_image;

    /**
     * @param $ID
     */
    public function __construct($User = 0)
    {

        if(is_array($User)){

            $this->set_user($User);
        }else if($User > 0){

            $user = $this->get_user_by('ID', $User);
            if(!empty($user)){
                $this->set_user($user);
            }
        }else{

        }

    }

    public static function get_payment_url($user_type = ''){
        if(self::is_user_logged_in()){
            return '/buy-subscription';
        }else{
            $query = $user_type ? "?user_type=$user_type" : '';
            return '/signup'.$query;
        }
    }

    public static function check_subscription(){
        if(!self::is_user_logged_in()){
            header('Location: '.'/login');
            exit;
        }else{

            $current_user = self::get_user();
            $sub_expiry = $current_user['subscription_expiry'];
            $expire_status = true;
            if($sub_expiry){
                $expire_time = strtotime($sub_expiry);

                if(time() <= $expire_time){
                    $expire_status = false;
                }
            }

            if($expire_status){
                header('Location: '.'/pricing?pricing_status=true');
                exit();
            }
        }
    }

    private function set_user($user_data){

        if(!empty($user_data) && is_array($user_data)){
               foreach($user_data as $property => $value){
                   if(property_exists($this, $property)){
                       $this->$property = $value;
                   }
               }
        }
    }


    public static function login_user($user_name_email, $password){
        $query_1 = "SELECT * FROM users WHERE user_name =%s OR email =%s";
        $user = MDB()->queryFirstRow($query_1, $user_name_email, $user_name_email);
        $login_error = new CError('user_login_error');
        if(empty($user)){
            return $login_error;
        }else{

            if(password_verify($password, $user['password'])){

               $user_data = new self($user);
               $_SESSION['user'] = serialize($user_data);
               $_SESSION['user_id'] = $user['ID'];
               $_SESSION['is_logged_in'] = true;

               return  $user_data;

            }else{
                return $login_error;
            }

        }


    }

    public static function get_prices($user_type = false){


        $price_data =  [
            'reader' => 15,
            'author' => 25,
            'both' => 30,
        ];

        if(!$user_type){
            return $price_data;
        }else{
            $user_type = strtolower($user_type);
            return array_key_exists($user_type, $price_data) ? $price_data[$user_type] : false;
        }
    }

    public static function logout_user(){
        session_unset();
        session_destroy();
    }

    public static function is_user_logged_in(){

        if(isset($_SESSION['is_logged_in']) && isset($_SESSION['user_id'])){
            return $_SESSION['is_logged_in'] && !empty($_SESSION['user_id']);
        }else{
            return false;
        }
    }

    public static function get_current_user(){
        if(self::is_user_logged_in()){
            return $_SESSION['user'];
        }
    }

    public static function get_user($user_id = 0){
        if($user_id == 0 && self::is_user_logged_in()){
            $user_id = self::get_current_user_id();
        }else{
            return false;
        }

        return MDB()->queryFirstRow("SELECT * FROM users WHERE ID=%i", $user_id);

    }

    public  function set_user_data(){

    }

    public static function password_hash($password){
        return password_hash($password, PASSWORD_BCRYPT);;
    }

    public static function update_user($user_data){

        $new_user = new User();

        $new_user->setFirstName(cnews_get_value('first_name', $user_data));
        $new_user->setLastName(cnews_get_value('last_name', $user_data));
        $new_user->setUserName(cnews_get_value('user_name', $user_data));
        $new_user->setEmail(cnews_get_value('email', $user_data));
        $password = password_hash(cnews_get_value('password', $user_data), PASSWORD_BCRYPT);
        $new_user->setPassword($password);
        $new_user->setUserType(cnews_get_value('user_type', $user_data));
        $new_user->setIsActive(true);
        $current_time = strtotime('+1 month');
//        $new_user->setSubscriptionExpiry(null);
//        $new_user->setSubscriptionStatus(false);
        $new_user->setJoinDate(cnews_db_time_stamp(time()));
        $status = $new_user->update_db();

        return $status;

    }

    public function get_user_by($field, $field_value){

        $result = array();
        if($field){
            $end_part = '%s';
            $query_str = $field."=".$end_part;
            $result = MDB()->queryFirstRow("SELECT * FROM users WHERE $query_str", $field_value);
        }

        return $result;
    }


    private function insert_new_user(){


        $by_email = $this->get_user_by('email', $this->getEmail());
        $by_user_name = $this->get_user_by('user_name', $this->getUserName());


        if(empty($by_email) && empty($by_user_name)){

            $query = "INSERT INTO `users` (`ID`,`first_name`,`last_name`,`user_name`,`email`,`password`,`user_type`,`is_active`,`join_date`)
                VALUES (NULL, %s, %s, %s, %s, %s, %s, %i, %s)";

            $result = MDB()->query($query, $this->getFirstName(), $this->getLastName(), $this->getUserName(),
                $this->getEmail(), $this->getPassword(), $this->getUserType(), $this->getIsActive(), $this->getSubscriptionStatus(), $this->getSubscriptionExpiry(), $this->getJoinDate());

            return $result;

        }else{

            $error_code = '';

            if(!empty($by_user_name)){

                $error_code = 'user_name_exist';

            }else if(!empty($by_email)){
                $error_code = 'email_exist';
            }

            return new CError($error_code);

        }


    }

    private function update_user_db(){

        $query = "UPDATE `users` set `first_name` = %s,`last_name` = %s,`user_name` = %s,`email` = %s,
                   `password` = %s,`user_type` = %s,`is_active` = %i,
                   `join_date` = %s WHERE ID = %i";

        $result = MDB()->query($query, $this->getFirstName(), $this->getLastName(), $this->getUserName(),
            $this->getEmail(), $this->getPassword(), $this->getUserType(), $this->getIsActive(), $this->getSubscriptionStatus(),
            $this->getSubscriptionExpiry(), $this->getJoinDate(), $this->getID());

        return $result;
    }

    private function get_user_by_id($user_id){
        return MDB()->queryFirstRow("SELECT * FROM users WHERE ID = %i", $user_id);
    }

    /**
     * @throws \MeekroDBException
     */
    public function update_db(){

//        $user_data = (array) $this;
//        $user_keys = array_keys($user_data);
//        $user_values = array_values($user_data);
//        $user_keys_new = array_map(function($user_key){
//            return str_replace('CNEWS\User', '', $user_key);
//        }, $user_keys);

//        $user_data_new = array_combine($user_keys_new, $user_values);

        if(!empty($this->getID())){

           $result = $this->insert_new_user();

        }else{

            $user_prev = $this->get_user_by_id($this->getID());

            if(!empty($user_prev)){
                $result = $this->update_user_db();
            }else{
                $result = $this->insert_new_user();
            }

        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionStatus()
    {
        return $this->subscription_status;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionExpiry()
    {
        return $this->subscription_expiry;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $user_type
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    /**
     * @param mixed $subscription_status
     */
    public function setSubscriptionStatus($subscription_status)
    {
        $this->subscription_status = $subscription_status;
    }

    /**
     * @param mixed $subscription_expiry
     */
    public function setSubscriptionExpiry($subscription_expiry)
    {
        $this->subscription_expiry = $subscription_expiry;
    }

    /**
     * @return mixed
     */
    public function getJoinDate()
    {
        return $this->join_date;
    }

    /**
     * @param mixed $join_date
     */
    public function setJoinDate($join_date)
    {
        $this->join_date = $join_date;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->first_name. ' '. $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getProfilePicture()
    {
        if($this->profile_image){
            return $this->profile_image;
        }else{
            return '/cnews-admin/img/placeholder.png';
        }

    }

    /**
     * @param mixed $profile_image
     */
    public function setProfilePicture($profile_image): void
    {
        $this->profile_image = $profile_image;
    }





    public static function user_roles($user_role){

        $reader = [
            'read_news' => true,
            'save_news' => true,
            'message_news' => true,
            'import_rss' => true,
            'view_in_section' => true,
            'organize_save_news' => true,
            'share_news' => true,
            'reader' => true,
        ];

        $author = [
            'write_news' => true,
            'delete_news' => true,
            'update_news' => true,
            'publish_in_realtime' => true,
            'author' => true,

        ];

        $both = array_merge($reader, $author);

        $both['both'] = true;


        $admin = array_merge($reader, $author);

        $admin_real = [
            'admin' => true
        ];

        $admin = array_merge($admin, $admin_real);

        $all_roles = ['Reader' => $reader, 'Author' => $author, 'Admin' => $admin, 'Both' => $both];

        return array_key_exists($user_role, $all_roles) ? $all_roles[$user_role] : array();

    }

    public static function get_current_user_id(){

        if(self::get_logged_in_user()){
            return self::get_logged_in_user()->getID();
        }else{
            return false;
        }
    }

    public static function get_logged_in_user(){
        if(is_logged_in()){
            if(self::$current_user == null){
                self::$current_user = new self($_SESSION['user_id']);
            }

            return self::$current_user;

        }else{
            return  false;
        }
    }

    public static function current_user_can($role): bool{
        if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] && isset($_SESSION['user'])){
            $user = self::get_logged_in_user();
            if($user && $user->getUserType()){
                $user_type = $user->getUserType();
                $current_user_roles = self::user_roles($user_type);
                return array_key_exists($role, $current_user_roles) && $current_user_roles[$role];
            }else{
                return false;
            }
        }
        return false;
    }

    public static function upload_profile_image($user_id){

        $profile_image = isset($_FILES['user_profile_image']) && !empty($_FILES['user_profile_image']) ? $_FILES['user_profile_image'] : array();
        $profile_image_path = '';



        if(!empty($profile_image) && $profile_image['tmp_name']){


            $imgfile = $profile_image["name"];
            $img_size = $profile_image["size"];
            $ext = pathinfo($imgfile, PATHINFO_EXTENSION);

            if($img_size <= 5000000){

                $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
                $allowed_extensions = array(".jpg","jpeg",".png",".gif");

                if(!in_array($extension,$allowed_extensions))
                {
                    CNotices::add_notice('invalid_featured_image', 'warning');

                }else{

                    $profile_image_name = 'profile-'.$user_id.'.'.$ext;
                    $file_sub_path = "/uploads/profile-images/";
                    $profile_image_new = $file_sub_path.$profile_image_name;
                    $home_dir = CNEWS_DIR;
                    $image_absolute_path = $home_dir.$profile_image_new;

                    if(file_exists($image_absolute_path)){
                        unlink($image_absolute_path);
                    }
                    move_uploaded_file($profile_image["tmp_name"], $image_absolute_path);
                    if(file_exists($image_absolute_path)){
                        $profile_image_path = $profile_image_new;
                    }

                }

            }else{

                CNotices::add_notice('greater_size', 'warning');

            }
        }



        return $profile_image_path;

    }

    public static function update_profile(){

        if(self::is_user_logged_in()){

            if(isset($_POST['cnews-update-profile'])){

                if(!isset($_POST['cnews_nonce']) || !cnews_verify_nonce($_POST['cnews_nonce'], 'cnews_nonce_action')){
                    die('Sorry, your nonce did not verify');
                }else{


                    $skip_array = [
                        'password' => '',
                        'c_password' => '',
                    ];



                    $cnews_user = isset($_POST['cnews_user']) && !empty($_POST['cnews_user']) ? $_POST['cnews_user'] : array();

                    if(!empty($cnews_user)){

                        $user_data = array_diff_key($cnews_user, $skip_array);
                        $pwd_data = array_intersect_key($cnews_user, $skip_array);

                        if(!empty($user_data) && isset($user_data['ID'])){

                            $profile_image = self::upload_profile_image($user_data['ID']);
                            if($profile_image){
                                $user_data['profile_image'] = $profile_image;
                            }
                            $result = MDB()->update('users', $user_data, 'ID=%i', $user_data['ID']);

                            if($result && !empty($pwd_data) && !empty($pwd_data['password'])){

                                $password_hash = self::password_hash($pwd_data['password']);
                                $password_update = ['ID' => $user_data['ID'], 'password' => $password_hash];

                                $result_pwd = MDB()->update('users', $password_update, 'ID=%i', $password_update['ID']);

                                var_dump($result_pwd);

                            }

                            if($result){
                                CNotices::add_notice("profile_updated_success", "success");
                            }else{
                                CNotices::add_notice("profile_update_error", "error");
                            }

                        }else{
                            CNotices::add_notice('no_data_found', 'error');
                        }

                    }else{
                        CNotices::add_notice('no_data_found', 'error');
                    }
                }
            }

        }else{
            echo CNotices::get_message_string('not_authorized');
        }

    }



}