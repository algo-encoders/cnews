<?php

namespace CNEWS;

class News
{
    private $ID;
    private $news_title;
    private $news_content;
    private $slug;
    private $category;
    private $sub_category;
    private $tags;
    private $featured_image;
    private $author;
    private $news_status;
    private $created_date;
    private $modified_date;
    private $views;

    /**
     * @param int $ID
     */
    public function __construct($news = 0)
    {


        if(is_array($news)){

            $this->set_news($news);

        }else if($news > 0){

            $news = $this->get_news_by('ID', $news);
            if(!empty($news)){
                $this->set_news($news);
            }

        }else{

        }


    }

    private function set_news($news_data){

        if(!empty($news_data) && is_array($news_data)){
            foreach($news_data as $property => $value){
                if(property_exists($this, $property)){
                    $this->$property = $value;
                }
            }
        }
    }

    public function get_news_by($field, $field_value){

        $result = array();
        if($field){
            $end_part = '%s';
            $query_str = $field."=".$end_part;
            $result = MDB()->queryFirstRow("SELECT * FROM news WHERE $query_str", $field_value);
        }

        return $result;
    }

    private function insert_news(){

        $query = "INSERT INTO `news` (`ID`, `news_title`, `news_content`, `slug`, `category`, `sub_category`, `tags`, 
                    `featured_image`, `author`, `news_status`, `created_date`, `modified_date`, `views`)
                    VALUES (NULL, %s, %s, %s, %i, %i, %s, %s, %i, %s, %s , %s, %i)";

        $result = MDB()->query($query, $this->getNewsTitle(), $this->getNewsContent(), $this->getSlug(),
            $this->getCategory(), $this->getSubCategory(), $this->getTags(), $this->getFeaturedImage(), $this->getAuthor(),
            $this->getCreatedDate(), $this->getModifiedDate(), $this->getViews());

        return $result;

    }

    private function update_news_db(){

        if($this->getID()){

            $query = "UPDATE `news` set `news_title` = %s,`news_content` = %s,`slug` = %s,`category` = %i,
                   `sub_category` = %i,`tags` = %s,`author` = %i, `news_status` = %s,`created_date` = %s,
                   `modified_date` = %s, `views` = %i WHERE ID = %i";

            $result = MDB()->query($query, $this->getNewsTitle(), $this->getNewsContent(), $this->getSlug(),
                $this->getCategory(), $this->getSubCategory(), $this->getTags(), $this->getFeaturedImage(), $this->getAuthor(),
                $this->getCreatedDate(), $this->getModifiedDate(), $this->getViews(), $this->getID());

            return $result;

        }else{
            return false;
        }

    }

    private function get_news_by_id($news_id){
        return MDB()->queryFirstRow("SELECT * FROM news WHERE ID = %i", $news_id);
    }

    public static function post_news(){

        if(isset($_POST['cnews-latest-news'])){

            if(!isset($_POST['cnews_nonce']) || !cnews_verify_nonce($_POST['cnews_nonce'], 'cnews_nonce_action')){
                die('Sorry, your nonce did not verify');
            }else{

                if(!is_logged_in() && User::current_user_can('admin') || User::current_user_can('author')){

                    $cnews = isset($_POST['c_news']) && !empty($_POST['c_news']) ? $_POST['c_news'] : array();
                    $featured_image = isset($_FILES['cnews_featured_image']) && !empty($_FILES['cnews_featured_image']) ? $_FILES['cnews_featured_image'] : array();
                    $file_sub_path = '';

                    $is_featured_image = false;

                    $prev_news = array();
                    $prev_image = '';
                    if(isset($cnews['ID'])){
                        $prev_news = MDB()->queryFirstRow("SELECT * FROM news WHERE ID=%i", $cnews['ID']);
                        $prev_image = !empty($prev_news) ? CNEWS_DIR.$prev_news['featured_image'] : '';
                    }


                    if(!empty($featured_image) && $featured_image['tmp_name']){


                        $imgfile = $_FILES['cnews_featured_image']["name"];
                        $img_size = $_FILES['cnews_featured_image']["size"];

                        if($img_size <= 5000000){

                            $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
                            $allowed_extensions = array(".jpg","jpeg",".png",".gif");

                            if(!in_array($extension,$allowed_extensions))
                            {
                                CNotices::add_notice('invalid_featured_image', 'warning');

                            }else{

                                $imgnewfile = $imgfile;
                                $file_name = CNEWS_DIR.$file_sub_path;
                                $file_sub_path = "/uploads/featured-images/".$imgnewfile;
                                $actual_file_name = $file_name.$file_sub_path;

                                if(!file_exists($actual_file_name)){
                                    $is_featured_image = true;
                                    $file_sub_path = "/uploads/featured-images/".$imgnewfile;
                                    move_uploaded_file($_FILES["cnews_featured_image"]["tmp_name"], $actual_file_name);

                                    if(file_exists($prev_image)){
                                        unlink($prev_image);
                                    }

                                }else{

                                    CNotices::add_notice('featured_image_exist', 'warning');

                                }


                            }

                        }else{

                            CNotices::add_notice('greater_size', 'warning');

                        }


                    }

                    if(!empty($cnews)){

                        if(!empty($cnews['news_title'])){
                            if(!isset($cnews['ID'])){
                                $cnews['slug'] = self::make_slug($cnews['news_title']);
                                $cnews['views'] = 0;
                                $cnews['created_date'] = isset($cnews['created_date']) && !empty($cnews['created_date']) ? $cnews['created_date'] : date(Options::get_datetime_format());

                            }
                            $cnews['modified_date'] = date(Options::get_datetime_format());
                            $cnews['author'] = User::get_current_user_id();
                            if($is_featured_image){
                                $cnews['featured_image'] = $file_sub_path;
                            }

                            CNotices::set_news_posted($cnews);
                            if(isset($cnews['ID']) && !empty($cnews['ID'])){
                                $result = MDB()->update('news', $cnews, 'ID=%i', $cnews['ID']);
                                $r_type = 'update';
                            }else{
                                $result = MDB()->insert('news', $cnews);
                                $r_type = 'insert';
                            }
                            if($result){
                                CNotices::set_news_posted([]);
                                if($r_type == 'update'){
                                    CNotices::add_notice('news_updated_success', 'success');
                                }else{
                                    CNotices::add_notice('news_created_success', 'success');
                                }

                            }else{
                                CNotices::add_notice('news_problem', 'error');
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
    }

    public static function make_slug($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $title = $text;
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            $text = 'curated-news';
        }

        $slug_news = MDB()->queryFirstRow("SELECT MAX(ID) as ID, news_title, slug FROM news WHERE news_title = %s ", $title);
        $slug_news = array_filter($slug_news);

        if(!empty($slug_news)){
            $max_slug = $slug_news['slug'];
            $explod_slug = explode($divider, $max_slug);
            $last = end($explod_slug);
            $suffix = 1;

            if(is_numeric($last)){
                $last++;
                $suffix = $last;
            }

            $text .= '-'.$suffix;

        }

        return $text;
    }

    public static function news_query_part(){

        $current_user_id = User::get_current_user_id();
        $current_user_id = $current_user_id !== false ? $current_user_id : -1;


        $query = "SELECT news.*,
                users.ID as user_id, users.first_name, users.last_name,
                category.ID as cat_id, category.title as cat_title,
                sub_category.ID as sub_cat_id, sub_category.title as sub_cat_title,
                (SELECT COUNT(*) FROM saved_news WHERE reader=$current_user_id AND news=news.ID) as saved_news
                FROM `news`
                LEFT JOIN users ON news.author = users.ID
                LEFT JOIN category ON news.category = category.ID
                LEFT JOIN category as sub_category ON news.sub_category = sub_category.ID ";

        return $query;
    }

    public static function rss_settings($setting = '', $default = ''){
        $settings = [
            'limit' => 20,
        ];

        if($setting){

            return array_key_exists($setting, $settings) ? $settings[$setting] : $default;

        }else{
            return $settings;
        }
    }

    public static function get_rss_query(){

    }

    public static function get_rss_pagination_data(){
        $where = self::rss_where_query();
        $count_rss = MDB()->queryFirstColumn("SELECT COUNT(ID) FROM rss $where");
        $total_rss = current($count_rss);
        $page_limit = self::rss_settings('limit');
        $page_limit = $page_limit > $total_rss ? $total_rss : $page_limit;
        $total_pages = ceil($total_rss/$page_limit);


        return [
          'total_rss' => $total_rss,
          'total_pages' => $total_pages,
        ];
    }

    public static function rss_where_query(){
        $filters = ['Leaning', 'Source', 'Topic'];
        $where = [];
        foreach($filters as $filter){
            $filter_type = 'filter_'.$filter;
            if(isset($_REQUEST[$filter_type]) && $_REQUEST[$filter_type]){
                $where[] = "$filter = '$_REQUEST[$filter_type]' ";
            }
        }


        $where = implode('AND ', $where);
        $where = $where ? 'WHERE '.$where : '';

        return $where;
    }


    public static function rss_query($page = 0, $order = "ASC"){

        if(User::is_user_logged_in() && User::current_user_can('reader')){

            $limit = self::rss_settings('limit');
            $offset = $page * $limit;
            $where = self::rss_where_query();
            $query = "SELECT * FROM `rss` $where ORDER BY date $order LIMIT $limit OFFSET $offset ";

//            pree($query);
//
//            exit;

            return MDB()->query($query);

        }else{
            return [];
        }

    }

    public static function rss_html($all_published_news){
        foreach($all_published_news as $news_key => $news){

            ?>

            <div class="row mb-3 cnews-single-loop rss-<?php echo $news['ID']; ?>">

                <div class="col-md-12" style="min-height: 110px;">
                    <h3 class="cnews-title"><a target="_blank" href="<?php echo $news['Link']; ?>" class="text-white"><?php echo $news['Link']; ?></a></h3>
                    <div>
                        <small class="text-success">
                            <strong>Topic:</strong> <?php echo $news['Topic']; ?> &nbsp;&nbsp;&nbsp;
                        </small>

                        <small class="text-success">
                            <strong>Leaning:</strong> <?php echo $news['Leaning']; ?> &nbsp;&nbsp;&nbsp;
                        </small>

                        <small class="text-success">
                            <strong>Source:</strong> <?php echo $news['Source']; ?> &nbsp;&nbsp;&nbsp;
                        </small>

                    </div>


                </div>


            </div>

            <?php
        }
    }

    public static function get_where_slug(){


        return "WHERE slug = %s AND news_status = 'published' AND news.created_date <= %s";
    }

    public static function get_news_by_slug($slug){
        $current_date = date(Options::get_datetime_format());
        $query = self::news_query_part().self::get_where_slug();
        return MDB()->queryFirstRow($query, $slug, $current_date);
    }

    public static function get_where_part($part_key){

        $current_date = date(Options::get_datetime_format());
        $current_user_id = User::get_current_user_id();
        $current_user_id = $current_user_id !== false ? $current_user_id : -1;

        $saved_news = isset($_GET['saved_news']) && $_GET['saved_news'] && $_GET['saved_news'] == 'true' ? "AND (SELECT COUNT(*) FROM saved_news WHERE reader=$current_user_id AND news=news.ID) > 0" : '';
        $shared_news = isset($_GET['send_news']) && $_GET['send_news'] && $_GET['send_news'] == 'true' ? "AND (SELECT COUNT(*) FROM shared_news WHERE share_to=$current_user_id AND news=news.ID) > 0" : '';
        $category = isset($_GET['filter_category']) && $_GET['filter_category'] ? $_GET['filter_category'] : 0;
        $category_filter = isset($_GET['filter_category']) && $_GET['filter_category'] ? "AND (category = $category OR sub_category = $category)" : '';

        $parts = [
            'basic' => "WHERE news.news_status = 'published' AND news.created_date <= '$current_date' $saved_news $shared_news $category_filter
                ORDER BY news.created_date DESC",

        ];

        return array_key_exists($part_key, $parts) ? $parts[$part_key] : '';
    }

    public  static  function get_news_query_by($where_key){

        return self::news_query_part().self::get_where_part($where_key);
    }

    public static function all_published_news($query_type = 'basic'){

//        echo self::get_news_query_by('basic');

        return MDB()->query(self::get_news_query_by($query_type));

    }

    public static function import_rss_to_db(){
        if(isset($_GET['import_rss'])){
            $rss_file = home_path('/uploads/rss/rss.json');
            if(file_exists($rss_file)){
                $rss_content = file_get_contents($rss_file);
                $rss_content = json_decode($rss_content, true);
                if(User::current_user_can('admin') && !empty($rss_content)){
                    MDB()->insert('rss', $rss_content);
                }
            }

        }
    }



    public static function news_get_action(){

        if(isset($_GET['news_id']) && isset($_GET['action'])){

            if($_GET['action'] == 'edit'){

                CNotices::set_is_news_edit(true);
                $check_news = MDB()->queryFirstRow("SELECT * FROM news WHERE ID=%i", $_GET['news_id']);
                CNotices::set_news_posted($check_news);

            }else if($_GET['action'] == 'delete'){

                MDB()->query("DELETE FROM news WHERE ID=%i", $_GET['news_id']);
                $check_news = MDB()->queryFirstRow("SELECT * FROM news WHERE ID=%i", $_GET['news_id']);

                if(empty($check_news)){
                    CNotices::add_notice('news_delete', 'success');
                }else{
                    CNotices::add_notice('news_problem', 'success');
                }

            }
        }
    }

    /**
     * @throws \MeekroDBException
     */
    public function update_db(){


        if(!empty($this->getID())){

            $result = $this->insert_news();

        }else{

            $news_prev = $this->get_news_by_id($this->getID());

            if(!empty($news_prev)){
                $result = $this->update_news_db();
            }else{
                $result = $this->insert_news();
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
     * @param mixed $ID
     */
    public function setID($ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getNewsTitle()
    {
        return $this->news_title;
    }

    /**
     * @param mixed $news_title
     */
    public function setNewsTitle($news_title): void
    {
        $this->news_title = $news_title;
    }

    /**
     * @return mixed
     */
    public function getNewsContent()
    {
        return $this->news_content;
    }

    /**
     * @param mixed $news_content
     */
    public function setNewsContent($news_content): void
    {
        $this->news_content = $news_content;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getSubCategory()
    {
        return $this->sub_category;
    }

    /**
     * @param mixed $sub_category
     */
    public function setSubCategory($sub_category): void
    {
        $this->sub_category = $sub_category;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getFeaturedImage()
    {
        return $this->featured_image;
    }

    /**
     * @param mixed $featured_image
     */
    public function setFeaturedImage($featured_image): void
    {
        $this->featured_image = $featured_image;
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

    /**
     * @return mixed
     */
    public function getNewsStatus()
    {
        return $this->news_status;
    }

    /**
     * @param mixed $news_status
     */
    public function setNewsStatus($news_status): void
    {
        $this->news_status = $news_status;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @param mixed $created_date
     */
    public function setCreatedDate($created_date): void
    {
        $this->created_date = $created_date;
    }

    /**
     * @return mixed
     */
    public function getModifiedDate()
    {
        return $this->modified_date;
    }

    /**
     * @param mixed $modified_date
     */
    public function setModifiedDate($modified_date): void
    {
        $this->modified_date = $modified_date;
    }

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param mixed $views
     */
    public function setViews($views): void
    {
        $this->views = $views;
    }




}