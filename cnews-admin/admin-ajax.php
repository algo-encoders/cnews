<?php

use \CNEWS\User;
use \CNEWS\CNotices;
use \CNEWS\Category;

if(!function_exists('cnews_save_user_news')){
    function cnews_save_user_news (){

        $result = [];

        if(isset($_POST['cnews_action'])){

            if(is_logged_in()){

                $news_action = $_POST['cnews_action'];

                switch ($news_action){
                    case 'save':

                        $current_user_id = User::get_current_user_id();
                        $news_id = isset($_POST['news_id']) && is_numeric($_POST['news_id'])? $_POST['news_id'] : '';
                        $table_name = 'saved_news';
                        $update_status = 'failed';
                        if($current_user_id && $news_id){
                            $is_news_already_saved = MDB()->queryFirstRow("SELECT * FROM $table_name WHERE reader=%i AND news=%i", $current_user_id, $news_id);
                            if(!empty($is_news_already_saved)){
                               $row_affected =  MDB()->delete($table_name, "reader=%i AND news=%i", $current_user_id, $news_id);
                               $row_affected = MDB()->affectedRows();

                               if($row_affected > 0){
                                   $update_status = 'deleted';
                               }

                            }else{

                                $update_status = MDB()->insert($table_name, ['reader' => $current_user_id, 'news' => $news_id]);
                                $row_affected = MDB()->affectedRows();
                                if($row_affected > 0){
                                    $update_status = 'inserted';
                                }
                            }
                        }

                        $update_status = 'news_saved_'.$update_status;

                        $result = CNotices::get_message($update_status, 1);

                        break;

                    case 'share':

                        break;
                }


            }else{
                $result = CNotices::get_message('not_authorized', -1);
            }
        }

        echo json_encode($result);
        exit;

    }

}

if(!function_exists('cnews_load_sub_cats')){
    function cnews_load_sub_cats (){

        $result = [];

        if(isset($_POST['cnews_cat'])){
            if(is_logged_in()){
                $cnews_cat = $_POST['cnews_cat'];
                $result = CNotices::get_message('sub_cats_success', 1);

                ob_start();

                echo '<option value="">Select Sub Category</option>';
                echo Category::get_categories_html($cnews_cat);
                $sub_cats_html = ob_get_clean();

                $result['html_data'] = $sub_cats_html;

            }else{
                $result = CNotices::get_message('not_authorized', -1);
            }
        }

        echo json_encode($result);
        exit;

    }

}


if(isset($_POST['cnews_ajax_action'])){
    $cnews_action = $_POST['cnews_ajax_action'];
    header('Content-Type: application/json; charset=utf-8');

    if(function_exists($cnews_action)){
        $cnews_action();
    }

}



