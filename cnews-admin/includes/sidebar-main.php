<?php
    use \CNEWS\User;

    global $current_route;

    $current_user = User::get_logged_in_user();

    $news_li = ['add-news', 'news-list', 'categories'];
    $reader_li = ['add-news', 'news-list', 'categories'];


?>

<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="<?php echo home_url().$current_user->getProfilePicture(); ?>" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
                <h1 class="h5"><?php echo $current_user->getDisplayName(); ?></h1>
                <p><?php echo $current_user->getUserType(); ?></p>
            </div>
        </div>

        <!-- Sidebar Navidation Menus--><span class="heading">curated Tools</span>

        <ul class="list-unstyled">

            <?php

                $is_sub = false;
                $is_sub = isset($_GET['saved_news']) || isset($_GET['send_news']);
                $open = $current_route == 'rss';

            ?>

            <li><a href="#reader_drop_down" class="<?php echo $current_route == 'news-reader' || $open ? '' : 'collapsed'; ?>" aria-expanded="<?php echo $current_route == 'news-reader' || $open ? 'true' : 'false'; ?>" data-toggle="collapse"> <i class="icon-windows"></i>Reader Tools</a>
                <ul id="reader_drop_down" class="collapse list-unstyled <?php echo $current_route == 'news-reader' || $open ? 'show' : ''; ?>">
                    <li class="<?php echo $current_route == 'news-reader' && !$is_sub ? 'text-primary' : ''; ?>">
                        <a href="/news-reader">News Reader</a>
                    </li>
                    <li class="<?php echo $current_route == 'news-reader' && isset($_GET['saved_news']) ? 'text-primary' : ''; ?>">
                        <a href="/news-reader?saved_news=true">Saved News</a>
                    </li>
                    <li class="<?php echo $current_route == 'news-reader' && isset($_GET['send_news']) ? 'text-primary' : ''; ?>">
                        <a href="/news-reader?send_news=true">Send News</a>
                    </li>
                    <li class="<?php echo $current_route == 'rss' ? 'text-primary' : ''; ?>">
                        <a href="/rss">RSS News</a>
                    </li>
                </ul>
            </li>

        </ul>



        <ul class="list-unstyled">

            <?php

                if(User::current_user_can('admin') || User::current_user_can('author')):

            ?>

                <li><a href="#news_drop_down" class="<?php echo in_array($current_route, $news_li)? '' : 'collapsed'; ?>" aria-expanded="<?php echo in_array($current_route, $news_li)? 'true' : 'false'; ?>" data-toggle="collapse"> <i class="icon-windows"></i>Author Tools</a>
                    <ul id="news_drop_down" class="collapse list-unstyled <?php echo in_array($current_route, $news_li)? 'show' : ''; ?>">
                        <li class="<?php echo $current_route == 'add-news' ? 'text-primary' : ''; ?>">
                            <a href="/add-news">Add News</a>
                        </li>
                        <li class="<?php echo $current_route == 'news-list' ? 'text-primary' : ''; ?>">
                            <a href="/news-list">News List</a>
                        </li>
                        <li class="<?php echo $current_route == 'categories' ? 'text-primary' : ''; ?>">
                            <a href="/categories">Categories</a>
                        </li>
                    </ul>
                </li>

            <?php endif; ?>

            <li class="<?php echo $current_route == 'profile' ? 'text-primary' : ''; ?>">
                <a href="/profile">
                    <i class="icon-user"></i>
                    Profile
                </a>
            </li class="<?php echo $current_route == 'settings' ? 'text-primary' : ''; ?>">
            <li>
                <a href="/payments">
                    <i class="icon-bill"></i>
                    Payments
                </a>
            </li>
        </ul>
<!--        <span class="heading d-none">Extras</span>-->
<!--        <ul class="list-unstyled">-->
<!--            <li> <a href="#"> <i class="icon-settings"></i>Demo </a></li>-->
<!--            <li> <a href="#"> <i class="icon-writing-whiteboard"></i>Demo </a></li>-->
<!--            <li> <a href="#"> <i class="icon-chart"></i>Demo </a></li>-->
<!--        </ul>-->
    </nav>
    <!-- Sidebar Navigation end-->
    <div class="page-content">