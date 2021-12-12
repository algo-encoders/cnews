<?php
global $current_route;


?>
<footer class="footer">
    <div class="footer__block block no-margin-bottom">
        <div class="container-fluid text-center">
            <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            <p class="no-margin-bottom"> <?php echo date('Y'); ?> &copy; <a href="/">Curated News</a> <a style="opacity: 0;" href="https://bootstrapious.com/p/bootstrap-4-dark-admin">Bootstrapious</a></p>
        </div>
    </div>
</footer>
</div>
</div>
<!-- JavaScript files-->
<script src="<?php echo admin_dir_url('/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?php echo admin_dir_url('/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo admin_dir_url('/'); ?>vendor/jquery.cookie/jquery.cookie.js"> </script>
<!--<script src="--><?php //echo admin_dir_url('/'); ?><!--vendor/chart.js/Chart.min.js"></script>-->
<script src="<?php echo admin_dir_url('/'); ?>vendor/jquery-validation/jquery.validate.min.js"></script>
<!--<script src="--><?php //echo admin_dir_url('/'); ?><!--js/charts-home.js"></script>-->

<?php if($current_route == 'add-news'): ?>

<script src="<?php echo admin_dir_url('/'); ?>js/plugins/date-time/jquery.datetimepicker.full.min.js" referrerpolicy="origin"></script>


<?php endif; ?>

<script src="<?php echo admin_dir_url('/'); ?>js/front.js"></script>
</body>
</html>