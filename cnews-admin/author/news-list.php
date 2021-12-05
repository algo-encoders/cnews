<?php

use \CNEWS\News;
use  \CNEWS\User;
use \CNEWS\CNotices;
use \CNEWS\CError;

User::check_subscription();
if(User::current_user_can('author')){

}else{
    echo "You are not allow to access this page";
    exit;
}

cnews_admin_header_add();

$current_user_id = User::get_current_user_id();
News::news_get_action();
?>
    <script>
        window.history.pushState({"","","", <?php echo home_url('/news-list'); ?>);
    </script>
<?php


$limit = 5;
/*How may adjacent page links should be shown on each side of the current page link.*/
$adjacents = 2;
$total_rows = MDB()->queryFirstRow("SELECT COUNT(*) As total_records FROM `news` WHERE author = $current_user_id");
$total_rows = !empty($total_rows) ? $total_rows['total_records'] : 0;
$total_pages = ceil($total_rows / $limit);


if(isset($_GET['page']) && $_GET['page'] != "") {
    $page = $_GET['page'];
    $offset = $limit * ($page-1);
} else {
    $page = 1;
    $offset = 0;
}

//Here we generates the range of the page numbers which will display.
if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
} else {
    if(($page - $adjacents) > 1) {
        if(($page + $adjacents) < $total_pages) {
            $start = ($page - $adjacents);
            $end   = ($page + $adjacents);
        } else {
            $start = ($total_pages - (1+($adjacents*2)));
            $end   = $total_pages;
        }
    } else {
        $start = 1;
        $end   = (1+($adjacents * 2));
    }
}



$current_user_id = User::get_current_user_id();
$where = "WHERE news.author = $current_user_id ORDER BY news.created_date DESC LIMIT $offset, $limit";
$all_news_current_author = News::news_query_part().$where;
$all_news = MDB()->query($all_news_current_author);


?>

        <!-- Page Header-->
        <div class="page-header no-margin-bottom">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">Add News</h2>
            </div>
        </div>


        <section class="mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="block margin-bottom-sm">
                            <div class="title"><strong>News List</strong></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <?php CNotices::print_notices(); ?>
                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>News Title</th>
                                        <th>Published Date</th>
                                        <th>News Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php

                                        if(!empty($all_news)){

                                            if($page > 1){
                                                $counter = (1 * $offset) + 1;
                                            }else{
                                                $counter = 1;
                                            }

                                            foreach($all_news as $single_news){

                                                ?>


                                                    <tr>
                                                        <th scope="row"><?php echo $counter; ?></th>
                                                        <td><?php echo $single_news['news_title']; ?></td>
                                                        <td><?php echo $single_news['created_date']; ?></td>
                                                        <td><?php echo $single_news['news_status']; ?></td>
                                                        <td><a href="<?php echo home_url('/add-news?news_id='.$single_news['ID'].'&action=edit'); ?>">Edit</a> | <a class="cnews_list_delete" href="<?php echo home_url('/news-list?news_id='.$single_news['ID'].'&action=delete'); ?>">Delete</a></td>
                                                    </tr>


                                                <?php

                                                $counter++;
                                            }
                                        }

                                    ?>


                                    </tbody>
                                </table>




                            </div>


                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <?php if($total_pages > 1) { ?>
                                        <ul class="pagination pagination-sm justify-content-center">
                                            <!-- Link of the first page -->
                                            <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
                                                <a class='page-link' href='news-list?page=1'><<</a>
                                            </li>
                                            <!-- Link of the previous page -->
                                            <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
                                                <a class='page-link' href='news-list?page=<?php ($page>1 ? print($page-1) : print 1)?>'><</a>
                                            </li>
                                            <!-- Links of the pages with page number -->
                                            <?php for($i=$start; $i<=$end; $i++) { ?>
                                                <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
                                                    <a class='page-link' href='news-list?page=<?php echo $i;?>'><?php echo $i;?></a>
                                                </li>
                                            <?php } ?>
                                            <!-- Link of the next page -->
                                            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
                                                <a class='page-link' href='news-list?page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'>></a>
                                            </li>
                                            <!-- Link of the last page -->
                                            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
                                                <a class='page-link' href='news-list?page=<?php echo $total_pages;?>'>>>
                                                </a>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<?php cnews_admin_footer(); ?>