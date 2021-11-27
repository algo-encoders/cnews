<?php
global $current_route;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dark Bootstrap Admin by Bootstrapious.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo admin_dir_url('/'); ?>vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo admin_dir_url('/'); ?>vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="<?php echo admin_dir_url('/'); ?>css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo admin_dir_url('/'); ?>css/style.default.css" id="theme-stylesheet">



    <!-- theme stylesheet-->

    <?php if($current_route == 'add-news'): ?>

        <link rel="stylesheet" href="<?php echo admin_dir_url('/'); ?>js/plugins/date-time/jquery.datetimepicker.min.css" id="theme-stylesheet">
        <!--        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/textcolor/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/image/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/imagetools/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/media/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/table/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/code/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/lists/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/advlist/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/link/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/autolink/plugin.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo admin_dir_url('/'); ?>js/plugins/tinymce/plugins/wordcount/plugin.min.js" referrerpolicy="origin"></script>
        <script>

            function cnews_get_word_count(id) {
                return tinymce.get(id).plugins.wordcount.getCount();
            }


            tinymce.init({
                selector:'textarea#cnews_content',
                plugins:'textcolor image imagetools media table code advlist lists link autolink wordcount',
                toolbar: 'undo redo | styleselect | forecolor backcolor| bold italic underline| alignleft aligncenter alignright alignjustify | outdent indent | link image | code',
                toolbar_mode: 'floating',
                height: 350

            });
        </script>
    <?php endif; ?>


    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo admin_dir_url('/'); ?>css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?php echo admin_dir_url('/'); ?><?php echo admin_dir_url('/'); ?>img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
