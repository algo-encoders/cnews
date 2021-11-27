<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");

const CNEWS_DIR = __DIR__;
$cnews_dir = __DIR__;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once CNEWS_DIR.'/vendor/autoload.php';
require CNEWS_DIR.'/sub-project/functions.php';

// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/', 'home.php');

// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
get('/user/$id', 'user.php');

// Dynamic GET. Example with 2 variables
// The $name will be available in user.php
// The $last_name will be available in user.php
get('/user/$name/$last_name', 'user.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
get('/product/$type/color/:color', 'product.php');

// Dynamic GET. Example with 1 variable and 1 query string
// In the URL -> http://localhost/item/car?price=10
// The $name will be available in items.php which is inside the views folder
get('/item/$name', 'views/items.php');


get('/admin', 'cnews-admin/index.php');


get('/admin/$force_login', 'cnews-admin/index.php');


get('/login', 'sub-project/view/login.php');
post('/login', 'sub-project/view/login.php');
get('/logout', 'cnews-admin/includes/logout.php');


get('/signup', 'sub-project/view/signup.php');
post('/signup', 'sub-project/view/signup.php');


get('/analytics', 'curatedanalytics/index.php');


get('/curated-news', 'curatednews.php');


get('/curated-regions', 'curatedregions.php');


get('/curated-blog', 'curatedblog.php');

get('/privacypolicy', 'privacypolicy.php');

get('/termsandconditions', 'termsandconditions.php');

//Author Routes

get('/add-news', 'cnews-admin/author/add-news.php');
post('/add-news', 'cnews-admin/author/add-news.php');


get('/categories', 'cnews-admin/author/category.php');
post('/categories', 'cnews-admin/author/category.php');

get('/news-list', 'cnews-admin/author/news-list.php');
get('/profile', 'cnews-admin/author/profile.php');
post('/profile', 'cnews-admin/author/profile.php');


get('/news-reader', 'sub-project/view/reader.php');
get('/single-news/$news_slug', 'sub-project/view/single-news.php');


//ajax

post('/ajax-admin', 'cnews-admin/admin-ajax.php');
get('/ajax-admin', 'cnews-admin/admin-ajax.php');

get('/pricing', 'sub-project/view/pricing.php');






global $region_code;
get('/load-region/$region_code', '/curatedregions/index.php');

// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','404.html');

MDB()->disconnect();


