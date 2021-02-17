<?php
get_header();
$excludedPosts = "";
$sliderPosts = get_posts(array(
    "numberposts"	=> 3,
    "post_type"		=> array("news"),
    "meta_key"		=> "topPost",
    "meta_value"	=> 1
));

$topMonthlyCommentedPosts = get_posts(array(
    "numberposts"	=> 3,
    "post_type"		=> array("news"),
    "orderby"       => "comment_count",
    "date_query" => array(
        "after" => "1 months ago"
    )
));

foreach ($topMonthlyCommentedPosts as $topMonthlyCommentedPost){
    $excludedPosts .= " " . $topMonthlyCommentedPost->ID;
}
$mostViewedPosts = get_posts(array(
    "numberposts"	=> 3,
    "post_type"		=> array("news"),
    "orderby"       => "post_views_count",
    "meta_query" => array(
        "post_views_count" => array(
            "key"     => "post_views_count",
            "value"   => 1,
            "compare" => "NOT LIKE",
        ),
        array(
            "key"   => "topPost",
            "value"   => 1,
            "compare" => "NOT LIKE"
        )
    ),
    "order"   => "DESC",
    "date_query" => array(
        "after" => "2 weeks ago"
    ),
    "exclude" => $excludedPosts
));
?>
<?php tribunaQuote(); ?>
<section class="featuredPosts">
    <div class="container">
        <div class="featuredPosts__main">
            <?php tribunaSlider(); ?>
            <?php tribunaFeaturedPosts(); ?>
        </div>
        <div class="featuredPosts__sidebar">
            <?php tibunaLastPostsTable(); ?>
        </div>
    </div>
</section>
<?php tibunaStickyPosts(); ?>
<?php if (have_rows("banners")) : ?>
    <section class="banners">
        <div class="container">
            <div class="owl-carousel">
                <?php while (have_rows("banners")) : the_row(); ?>
                    <a href="<?php echo (get_sub_field("link")) ? get_sub_field("link") : "#"; ?>">
                        <div class="banners__mobile"
                             style="background-image:url('<?php echo get_sub_field("banner_mob"); ?>');">
                        </div>
                        <div class="banners__desktop"
                             style="background-image:url('<?php echo get_sub_field("banner"); ?>');">
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php tribunaBlogs(); ?>
<?php tribunaPosts(); ?>


<?php get_footer(); ?>