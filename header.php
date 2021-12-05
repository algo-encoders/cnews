<?php
use \CNEWS\User;
global $current_route;

//pree($current_route);
//
//exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Curated News</title>
    <meta name="description" content="Curated News is a misinformation-proof news aggregation platform that provides tools and content that help strengthen your information consumption habits.">
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico">
    <link href="<?php echo home_url(); ?>/static/css/poppins.css" rel="stylesheet">
    <link href="<?php echo home_url(); ?>/static/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo home_url(); ?>/static/css/aos.css">
    <link href="<?php echo home_url(); ?>/static/css/Normalize.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo home_url(); ?>/static/css/bootstrap.css" rel="stylesheet" type="text/css" />




    <?php

    if($current_route == 'pricing' && false){
     ?>
        <link href="<?php echo home_url(); ?>/static/css/main.min.css" rel="stylesheet" type="text/css" />
        <?php
    }


    if($current_route != 'curated-regions'){
        ?>
        <link href="<?php echo home_url(); ?>/static/css/style.css" rel="stylesheet" type="text/css" />

        <?php

        if($current_route == 'analytics'){

            ?>
            <link href="<?php echo home_url(); ?>/static/css/slimselect.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo home_url(); ?>/curatedanalytics/assets/chart-styles.css" rel="stylesheet" type="text/css" />
            <noscript><meta http-equiv="refresh" content="1;url=./errornojs.html"></noscript>
            <style>p.b {font-family: Poppins;} button.t{font-family: Poppins;}</style>

            <?php

        }

    }else{

        ?>

        <link href="./static/css/style2.css" rel="stylesheet" type="text/css" />
            <noscript><meta http-equiv="refresh" content="1;url=errornojs.html"></noscript>

            <script src="<?php echo home_url(); ?>/static/js/raphael.js"></script>
            <script src="<?php echo home_url(); ?>/static/js/scale.raphael.js"></script>
            <script src="<?php echo home_url(); ?>/static/js/jquery.js"></script>
            <script src="<?php echo home_url(); ?>/static/js/color.jquery.js"></script>
            <script src="<?php echo home_url(); ?>/static/js/jquery.usmap.js"></script>

            <script>
                $(document).ready(function() {
                    $('#map').usmap({
                        'click' : function(event, data) {
                            $('#alert')
                                .text('Here is all the local news for that state:')
                                .stop()
                                .css('backgroundColor', '#ecf0f1')
                                .animate({backgroundColor: '#ecf0f1'}, 1000);
                            click = data.name;
                            window.open("./load-region/"+click);
                        }
                    });

                    $('#over-md').click(function(event){
                        $('#map').usmap('trigger', 'MD', 'mouseover', event);
                    });

                    $('#out-md').click(function(event){
                        $('#map').usmap('trigger', 'MD', 'mouseout', event);
                    });
                });
            </script>

        <?php

    }
    ?>




</head>
<body data-new-gr-c-s-loaded="14.1018.0" class="cnews-page page-<?php echo $current_route; ?>">
<!--====== HEADER PART START ======-->
<header class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="/">
                        <img src="<?php echo home_url(); ?>/static/images/logo.png" alt="Logo" class="img-fluid logo-curated">
                        <h4 class="logo_text">Curated News</h4>
                    </a>
                    <!-- Logo -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="bar-icon"></span>
                        <span class="bar-icon"></span>
                        <span class="bar-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul id="nav" class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a data-scroll-nav="0" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a data-scroll-nav="0" href="/curated-news">Curated News</a>
                            </li>
                            <li class="nav-item">
                                <a data-scroll-nav="0" href="/analytics">Analytics</a>
                            </li>
                            <li class="nav-item">
                                <a data-scroll-nav="0" href="/admin">Tools</a>
                            </li>
                            <li class="nav-item">
                                <a data-scroll-nav="0" href="/pricing">Pricing</a>
                            </li>
                            <li class="nav-item">
                                <a data-scroll-nav="0" href="/curated-regions">Regions</a>
                            </li>
                            <li class="nav-item">
                                <a data-scroll-nav="0" href="/curated-blog">Our Blog</a>
                            </li>
                        </ul>
                        <!-- navbar nav -->
                    </div>

                        <?php if(is_logged_in()):

                            $current_user = User::get_logged_in_user();
                            ?>

                        <ul class="navbar-nav ml-auto cnews_user">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $current_user->getProfilePicture(); ?>" width="40" height="40" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/admin">Dashboard</a>

                                    <?php


                                        if(User::current_user_can('author')){
                                            ?>
                                            <a class="dropdown-item" href="/add-news">Add News</a>
                                            <a class="dropdown-item" href="/news-list">News List</a>
                                            <?php
                                        }

                                        if(User::current_user_can('reader')){
                                            ?>
                                                <a class="dropdown-item" href="/news-reader">News Reader</a>
                                                <a class="dropdown-item" href="/news-reader?saved_news=true">My Saved News</a>
                                            <?php
                                        }


                                    ?>

                                    <a class="dropdown-item" href="/profile">Profile</a>
                                    <a class="dropdown-item" href="/logout">Log Out</a>
                                </div>
                            </li>
                        </ul>

                        <?php endif; ?>
                </nav>
                <!-- navbar -->
            </div>
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</header>
<!--====== HEADER PART ENDS ======-->