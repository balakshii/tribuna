</main>
<footer class="footer">
    <div class="container">
        <div class="footer__item"><a class="logo" href="/" title="Tribuna.pl.ua"></a>
            <ul class="footer__menu">
                <?php wp_nav_menu( array( 'container' => '', 'menu' => 'footer', 'items_wrap' => '%3$s', ) ); ?>
            </ul>
            <div class="clearfix"></div>
            <div class="footer__text footer__about">
                <?php print date('Y')?> «Трибуна» Незалежна преса Полтави. Використання матеріалів «Трибуни» на інших сайтах дозволяється лише за наявності гіперпосилання на сайт tribuna.pl.ua, не закритого для індексації пошуковими системами. У друкованих виданнях — лише за погодженням з редакцією.Редакція «Трибуни» не несе відповідальності за зміст коментарів, розміщених користувачами сайту. Редакція може не завжди поділяти погляди авторів окремих публікацій.
            </div>
        </div>
        <div class="footer__item">
            <ul class="socialButtons">
                <li><a class="fab fa-facebook-f" href="https://www.facebook.com/pages/%D0%A2%D1%80%D0%B8%D0%B1%D1%83%D0%BD%D0%B0/1589365837950876" target="_blank"></a></li>
                <li><a class="fab fa-instagram" href="https://instagram.com/tribuna.pl.ua" target="_blank"></a></li>
                <li><a class="fab fa-twitter" href="https://twitter.com/tribunaPL" target="_blank"></a></li>
                <li><a class="fab fa-youtube" href="https://www.youtube.com/channel/UCmmmMOR9CjbcgV8neCINReg" target="_blank"></a></li>
                <li><a class="fab fa-telegram-plane" href="https://t.me/tribuna_pl" target="_blank"></a></li>
            </ul>
            <div class="footer__text">
                <a href="mailto:tribuna.pl.ua@gmail.com">
                    Редакція - tribuna.pl.ua@gmail.com
                </a>
                <a href="tel:+380995319891">
                    Телефон - +38(099)531-98-91
                </a>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer__text">&copy; 2015-<?php print date('Y')?> Трибуна, незалежна преса Полтави</div>
    </div>
</footer>
<a class="fixed_link--telegram-group" href="https://t.me/tribuna_pl" target="_blank"></a>
<script type='text/javascript'>
    /* <![CDATA[ */
    var myajax = {"url": location.origin + "/wp-admin/admin-ajax.php"};
    /* ]]> */
</script>

<?php if (get_page_template_slug() == "shop.php") : ?>
    <script src="<?php echo get_template_directory_uri() ?>/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $(".lightgallery .postCard__imgContainer").lightGallery();
        });
    </script>
<?php endif; ?>

<script src="<?php echo get_template_directory_uri() ?>/dist/libs/owl/owl.carousel.min.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/dist/libs/jquery.nicescroll.js"></script>
<!--<script src="--><?php //echo get_template_directory_uri() ?><!--/dist/js/app.js"></script>-->
<script src="<?php echo get_template_directory_uri() ?>/dist/js/app.js"></script>
<?php if (is_single() && get_post_type() == 'photo'):?>
    <script src="<?php echo get_template_directory_uri() ?>/dist/libs/jssor.slider-24.1.2.min.js" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri() ?>/dist/libs/gallery.js" type="text/javascript"></script>
<?php endif?>

<script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-66785639-1', 'auto');
    ga('send', 'pageview');
    setTimeout("_gaq.push(['_trackEvent', '15_seconds', 'read'])",15000);
</script>
<style>
#catapult-cookie-bar{display:none}
</style>
<script>
setInterval(function(){ jQuery('#catapult-cookie-bar').show(); }, 5000);
</script> 
<?php wp_footer(); ?>
</body>
</html>