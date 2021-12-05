<?php

namespace CNEWS;

class CNotices
{

    public static $messages_list = array(
        'register_success' => 'You have successfully registered please go to <a href="/login">login</a> page and login.',
        'user_login_error' => 'User name or password is wrong, please try a different user name or password',
        'fill_required_fields' => 'Please fill all required fields',
        'password_not_match' => 'Password not matched',
        'process_problem' => 'There is a problem to process your request Please try again later',
        'email_exist' => 'Email already exists, please try different',
        'user_name_exist' => 'User name already exists please try different.',
        'title_required' => 'News title required to create a news',
        'no_data_found' => 'Data not found',
        'not_authorized' => 'you are not authorized to complete this action',
        'news_problem' => 'There is a problem to complete your news process, Please try again',
        'featured_image_exist' => 'Featured image already exist please try a different name',
        'invalid_featured_image' => 'Invalid format. Only jpg / jpeg/ png /gif format allowed',
        'greater_size' => 'Image size should less then 5MB',
        'not_allowed_page' => 'Sorry, You are not allowed to access this page.',

//        news saved strings

        'news_saved_failed' => 'Failed to perform this action try again',
        'news_saved_deleted' => 'News removed from saved list',
        'news_saved_inserted' => 'News successfully saved',
        'news_created_success' => 'News Created Successfully',
        'news_updated_success' => 'News Updated Successfully',
        'news_delete' => 'News deleted Successfully',

//        Category saved strings
        'cat_created_success' => 'Category Created Successfully',
        'cat_updated_success' => 'Category Updated Successfully',
        'cat_saved_failed' => 'Failed to perform this action try again',
        'cat_saved_deleted' => 'Category removed from list',
        'cat_saved_inserted' => 'Category successfully saved',
        'cat_problem' => 'There is a problem to complete your category process, Please try again',
        'cat_title_required' => 'Category title required to create or update category',
        'cat_already_exists' => 'Category already exists with same title please chose different title',
        'sub_cats_success' => 'Sub categories fetched successfully',

//        User Profile Update

        'profile_update_error' => "There is some issue to update your profile please try again",
        'profile_updated_success' => "Profile updated",


//        payments

        'payment_cancel' => "Unfortunately your payment has been canceled, Please try again.",
        'payment_success' => "Congratulations, you have successfully completed your payment, it's take a little time to setup your account please be patience."

    );

    public static $active_notices = array();

    private static $news_posted_data = array();

    private static $cat_posted_data = array();

    private static $is_news_edit = false;

    public static function set_is_news_edit($t){
        self::$is_news_edit = $t;
    }

    public static function get_is_news_edit(){
        return self::$is_news_edit;
    }

    public static function is_notices(){
        return count(self::$active_notices) > 0 ;
    }

    public static function add_notice($code, $type, $is_dismiss = true, $message = ''){


            $message = !$message && array_key_exists($code, self::$messages_list) ? self::$messages_list[$code] : '';

            if($message){
                $notice = array(
                    'code' => $code,
                    'type' => $type,
                    'message' => $message,
                    'is_dismiss' => $is_dismiss,
            );

            self::$active_notices[] = $notice;
        }

    }

    public static function print_notices(){
        if(!empty(self::$active_notices)){
            foreach (self::$active_notices as $notice){

                $alert_type = $notice['type'];

                switch ($alert_type){
                    case 'error':
                        $alert_type = 'danger';
                        break;
                }

                ?>

                    <div class="mb-3 alert alert-<?php echo $alert_type;?> <?php $notice['is_dismiss'] ? 'alert-dismissible fade show' : ''; ?>" role="alert">
                        <strong><?php echo ucfirst($notice['type']); ?>!</strong>  <?php echo ucfirst($notice['message']); ?>

                        <?php if($notice['is_dismiss']): ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        <?php endif; ?>
                    </div>

                <?php
            }
        }
    }

    public static function set_news_posted($news){
        self::$news_posted_data = $news;
    }
    public static function get_news_posted(){
        return self::$news_posted_data;
    }

    public static function set_cat_posted($cat_data){
        self::$cat_posted_data = $cat_data;
    }
    public static function get_cat_posted(){
        return self::$cat_posted_data;
    }

    public  static function get_message($code, $type){
        return [
                'type' => $type,
                'code' => $code,
                'message' => array_key_exists($code, self::$messages_list) ? self::$messages_list[$code] : ''
        ];
    }

    public  static function get_message_string($code){
        return array_key_exists($code, self::$messages_list) ? self::$messages_list[$code] : '';
    }
}