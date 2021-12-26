<?php

use \CNEWS\User;
use \CNEWS\CNotices;
use \CNEWS\Category;
use \CNEWS\News;

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

if(!function_exists('cnews_shared_news')){
    function cnews_shared_news(){
        $result = [];

        if(User::is_user_logged_in()){

            if(isset($_POST['user_name']) && isset($_POST['news_id'])){


                $user = MDB()->queryFirstRow("SELECT * FROM users WHERE user_name=%s || email=%s", $_POST['user_name'], $_POST['user_name']);
                if(empty($user)){
                    CNotices::add_notice('user_not_found', 'error');
                }else{

                    $shared_to = $user["ID"];
                    $shared_from = User::get_current_user_id();
                    $news_id = $_POST['news_id'];
                    $news_already = MDB()->queryFirstRow("SELECT * FROM shared_news WHERE share_from=%i AND share_to=%i AND news=%i", $shared_from, $shared_to, $news_id);

                    if(empty($news_already)){

                        $news_shared = MDB()->insert('shared_news', ['share_from' => $shared_from, 'share_to' => $shared_to, 'news' => $news_id]);
                        $result['shared_news'] = $news_shared;

                        if($news_shared){
                            CNotices::add_notice('news_shared_success', 'success');
                        }

                    }else{
                        CNotices::add_notice('news_already_shared', 'error');
                    }
                }


            }else{
                CNotices::add_notice('news_user_required', 'error');
            }

        }else{
            CNotices::add_notice('not_authorized', 'error');
        }


        ob_start();

        CNotices::print_notices();

        $result['html'] = ob_get_clean();


        echo json_encode($result);

        exit;
    }
}

if(!function_exists('load_more_rss')){
    function load_more_rss(){
        $result = [];

        if(User::is_user_logged_in() && isset($_POST['offset'])){

            $offset = $_POST['offset'];
            $all_rss = News::rss_query($offset);

            ob_start();

            News::rss_html($all_rss);

            $result['html'] = ob_get_clean();


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



