<?php
global $current_route;

?>
<!--======  footer area ======-->
<footer class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="follow">Want to follow us? Check out our <a href="https://www.linkedin.com/company/curatednews" class="linkedin">LinkedIn</a> or <a href="https://www.facebook.com/theofficialcuratednews/" class="linkedin">Facebook</a>.</p>
            </div>
            <div class="col-12">
                <div class="terms_and_condition">
                    <ul>
                        <li><a href="/privacypolicy">Privacy Policy</a></li>
                        <li><a href="/termsandconditions">Terms and condition |</a><span> © 2020</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="footer_img">
                    <a href="curatedupdates.rss"><img src="./static/images/rss.png" alt="rrs" class="img-fluid currated_img_update"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--======  end area ======-->
<!-- Back to top button -->
<a id="button"></a>

<?php

if($current_route != "curated-regions"):
?>

<!------------------JS-------------->
<script src="<?php echo home_url(); ?>/static/js/jquery.min.js"></script>
<script src="<?php echo home_url(); ?>/static/js/popper.min.js"></script>
<script src="<?php echo home_url(); ?>/static/js/jquery.steps.js"></script>
<script src="<?php echo home_url(); ?>/static/js/bootstrap.min.js"></script>
<script src="<?php echo home_url(); ?>/static/js/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo home_url(); ?>/static/js/aos.js"></script>
<script src="<?php echo home_url(); ?>/static/js/smooth-scroll.min.js"></script>
<script src="<?php echo home_url(); ?>/static/js/app.js"></script>

<?php if($current_route == 'analytics'): ?>

<style>
    .single_news a{
        color: #31c5ff;
    }
</style>

<script src="<?php echo home_url(); ?>/static/js/apexcharts.js"></script>
<script src="<?php echo home_url(); ?>/static/js/slimselect.js"></script>
<script src="<?php echo home_url(); ?>/static/js/alasql.js"></script>
<script src="<?php echo home_url(); ?>/static/dataset/news-data.js"></script>
<script src="<?php echo home_url(); ?>/static/js/custom-script.js"></script>

<?php endif; ?>

<?php
endif;
?>

</body>
</html>