<?php
use CNEWS\User;

if(!is_logged_in()){

    header('Location: '.'/login');
    exit();
}

?>

<?php cnews_admin_header(); ?>

<header class="header">
    <nav class="navbar navbar-expand-lg">
        <?php
            if(is_logged_in()):
        ?>

            <div class="search-panel">
                <div class="search-inner d-flex align-items-center justify-content-center">
                    <div class="close-btn">Close <i class="fa fa-close"></i></div>
                    <form id="searchForm" action="#">
                        <div class="form-group">
                            <input type="search" name="search" placeholder="What are you searching for...">
                            <button type="submit" class="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php endif; ?>

        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <!-- Navbar Header--><a href="<?php echo home_url(); ?>" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase"><img class="pr-2" src="<?php echo home_url("/static/images/logo.png"); ?>" alt="">Curated News</div>
                    <div class="brand-text brand-sm"><img src="<?php echo home_url("/static/images/logo.png"); ?>" alt=""></div></a>
                <!-- Sidebar Toggle Btn-->
                <?php if(is_logged_in()): ?>
                <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>

                <?php endif; ?>
            </div>
            <?php if(is_logged_in()): ?>

            <div class="right-menu list-inline no-margin-bottom">
<!--                <div class="d-none list-inline-item"><a href="#" class="search-open nav-link"><i class="icon-magnifying-glass-browser"></i></a></div>-->
                    <div aria-labelledby="navbarDropdownMenuLink1" class="dropdown-menu messages"><a href="#" class="dropdown-item message d-flex align-items-center">
                            <div class="profile"><img src="<?php echo home_url(); ?>/img/avatar-3.jpg" alt="..." class="img-fluid">
                                <div class="status online"></div>
                            </div>
                            <div class="content">   <strong class="d-block">Nadia Halsey</strong><span class="d-block">lorem ipsum dolor sit amit</span><small class="date d-block">9:30am</small></div></a><a href="#" class="dropdown-item message d-flex align-items-center">
                            <div class="profile"><img src="<?php echo home_url(); ?>/img/avatar-2.jpg" alt="..." class="img-fluid">
                                <div class="status away"></div>
                            </div>
                            <div class="content">   <strong class="d-block">Peter Ramsy</strong><span class="d-block">lorem ipsum dolor sit amit</span><small class="date d-block">7:40am</small></div></a><a href="#" class="dropdown-item message d-flex align-items-center">
                            <div class="profile"><img src="<?php echo home_url(); ?>/img/avatar-1.jpg" alt="..." class="img-fluid">
                                <div class="status busy"></div>
                            </div>
                            <div class="content">   <strong class="d-block">Sam Kaheil</strong><span class="d-block">lorem ipsum dolor sit amit</span><small class="date d-block">6:55am</small></div></a><a href="#" class="dropdown-item message d-flex align-items-center">
                            <div class="profile"><img src="<?php echo home_url(); ?>/img/avatar-5.jpg" alt="..." class="img-fluid">
                                <div class="status offline"></div>
                            </div>
                            <div class="content">   <strong class="d-block">Sara Wood</strong><span class="d-block">lorem ipsum dolor sit amit</span><small class="date d-block">10:30pm</small></div></a><a href="#" class="dropdown-item text-center message"> <strong>See All Messages <i class="fa fa-angle-right"></i></strong></a></div>
                </div>
                <!-- Tasks-->

                <!-- Tasks end-->
                <!-- Megamenu-->

                <!-- Megamenu end     -->
                <!-- Languages dropdown    -->

                <!-- Log out               -->
                <div class="list-inline-item logout">
                    <?php if(is_logged_in()): ?>
                    <a id="logout" href="/logout" class="nav-link">
                        <span class="d-none d-sm-inline">Logout </span><i class="icon-logout"></i>
                    </a>
                    <?php else: ?>

                        <a id="login" href="/login" class="nav-link">
                            <span class="d-none d-sm-inline">Login </span><i class="icon-logout"></i>
                        </a>

                    <?php endif; ?>
                </div>
            </div>

            <?php endif; ?>

        </div>
    </nav>
</header>

<?php

if(is_logged_in()){
    cnews_admin_sidebar();
}
 ?>