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