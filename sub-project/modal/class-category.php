<?php

namespace CNEWS;



class Category
{
    private $ID;
    private $title;
    private $description;
    private $parent ;
    private $author;

    /**
     * @param int $ID
     */
    public function __construct($category = 0)
    {


        if(is_array($category)){

            $this->set_category($category);

        }else if($category > 0){

            $category = $this->get_category_by('ID', $category);
            if(!empty($category)){
                $this->set_category($category);
            }

        }else{

        }


    }

    private function set_category($category_data){

        if(!empty($category_data) && is_array($category_data)){
            foreach($category_data as $property => $value){
                if(property_exists($this, $property)){
                    $this->$property = $value;
                }
            }
        }
    }

    public function get_category_by($field, $field_value){

        $result = array();
        if($field){
            $end_part = '%s';
            $query_str = $field."=".$end_part;
            $result = MDB()->queryFirstRow("SELECT * FROM category WHERE $query_str", $field_value);
        }

        return $result;
    }

    private function insert_category(){

        $query = "INSERT INTO `category` (`ID`, `title`, `description`, `parent`, `author`)
                    VALUES (NULL, %s, %s, %i, %i)";
        $result = MDB()->query($query, $this->getTitle(), $this->getDescription(), $this->getParent(),
            $this->getAuthor());

        return $result;

    }

    private function update_category_db(){

        if($this->getID()){

            $query = "UPDATE `category` set `title` = %s,`description` = %s,`parent` = %i,`author` = %i WHERE ID = %i";

            $result = MDB()->query($query, $this->getTitle(), $this->getDescription(), $this->getParent(),
                $this->getAuthor());

            return $result;

        }else{
            return false;
        }

    }

    private function get_category_by_id($category_id){
        return MDB()->queryFirstRow("SELECT * FROM category WHERE ID = %i", $category_id);
    }

    public static function get_categories($parent){
        $categories = MDB()->query("SELECT * FROM category WHERE parent = %i", $parent);
        return $categories;
    }

    public static function get_categories_html($parent, $selected = ''){
        $categories = self::get_categories($parent);
        if(!empty($categories)){
            foreach($categories as $category){
                $selected = $category['ID'] == $selected ? 'selected' : '';
                echo "<option value='{$category['ID']}' $selected>{$category['title']}</option>";
            }
        }
    }

    public static function post_category(){



        if(isset($_POST['cnews_save_category'])){

            if(!isset($_POST['cnews_nonce']) || !cnews_verify_nonce($_POST['cnews_nonce'], 'cnews_nonce_action')){
                die('Sorry, your nonce did not verify');
            }else{

                if(!is_logged_in() && User::current_user_can('admin') || User::current_user_can('author')){

                    $c_news_cat = isset($_POST['c_news_cat']) && !empty($_POST['c_news_cat']) ? $_POST['c_news_cat'] : array();

                    CNotices::set_cat_posted($c_news_cat);

                    if(!empty($c_news_cat)){

                        if(!empty($c_news_cat['title'])){

                                $c_news_cat['author'] = User::get_current_user_id();

                                $result = false;
                                $r_type = false;

                                if(isset($c_news_cat['ID']) && !empty($c_news_cat['ID'])){



                                    $prev_category_ID = MDB()->queryFirstRow("SELECT * FROM category WHERE ID=%s", $c_news_cat['ID']);

                                    if(!empty($prev_category_ID)){

//                                        check if category previously a parent category and now updated to sub category then all its previously child to parent category
                                        if($prev_category_ID['parent'] == 0 && $c_news_cat['parent'] > 0){
                                            MDB()->query("UPDATE category set parent=%i WHERE parent=%i", 0, $c_news_cat['ID']);
                                        }

                                        $result = MDB()->update('category', $c_news_cat, 'ID=%i', $c_news_cat['ID']);
                                        $r_type = 'update';

                                    }

                                }

                                if(!$r_type){

                                    $prev_category = MDB()->queryFirstRow("SELECT * FROM category WHERE title=%s", $c_news_cat['title']);

                                    if(empty($prev_category)){

                                        $result = MDB()->insert('category', $c_news_cat);
                                        $r_type = 'insert';

                                    }else{

                                        CNotices::add_notice('cat_already_exists', 'error');
                                    }

                                }

                                if($result){

                                    if($r_type == 'update'){

                                        CNotices::add_notice('cat_updated_success', 'success');

                                    }else{

                                        CNotices::set_cat_posted(array());
                                        CNotices::add_notice('cat_created_success', 'success');

                                    }

                                }else{
                                    CNotices::add_notice('cat_problem', 'error');
                                }



                        }else{
                            CNotices::add_notice('title_required', 'error');
                        }

                    }else{
                        CNotices::add_notice('no_data_found', 'error');
                    }

                }else{

                    CNotices::add_notice('not_authorized', 'error');
                }

            }

        }

        self::post_action_category();
    }

    public static function post_action_category(){

        if(isset($_POST['cnews_action_category']) && (isset($_POST['cnews_action_delete']) || isset($_POST['cnews_action_edit']))){

            if(!isset($_POST['cnews_nonce']) || !cnews_verify_nonce($_POST['cnews_nonce'], 'cnews_nonce_action')){
                die('Sorry, your nonce did not verify');
            }else{

                if(!is_logged_in() && User::current_user_can('admin') || User::current_user_can('author')){

                    $prev_category = MDB()->queryFirstRow("SELECT * FROM category WHERE ID=%i", $_POST['cnews_action_category']);
                    if(empty($prev_category)){

                        CNotices::add_notice('no_data_found', 'success');

                    }else{

                        if(isset($_POST['cnews_action_delete'])){

                            MDB()->query("DELETE FROM category WHERE ID=%i", $_POST['cnews_action_category']);
                            MDB()->query("UPDATE category set parent=%i WHERE parent=%i", 0, $_POST['cnews_action_category']);
                            $prev_category = MDB()->queryFirstRow("SELECT * FROM category WHERE ID=%i", $_POST['cnews_action_category']);
                            if($prev_category){
                                CNotices::add_notice('cat_problem', 'error');
                            }else{
                                CNotices::add_notice('cat_saved_deleted', 'success');
                            }

                        }else if(isset($_POST['cnews_action_edit'])){
                            CNotices::set_cat_posted($prev_category);
                        }

                    }

                }else{

                    CNotices::add_notice('not_authorized', 'error');
                }

            }

        }

    }



    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }



}