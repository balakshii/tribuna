<?php
$lastPosts = get_posts(array(
    "numberposts"	=> 4,
    "post_type"		=> array("news")
));
$topPosts = get_posts(array(
    "numberposts"	=> 2,
    "post_type"		=> array("news"),
    "meta_key"		=> "topPost",
    "meta_value"	=> 1,
    "offset"    => 3
));
?>

<section class="posts excluded_area">
    <div class="container">
        <?php
        $sticky = get_option('sticky_posts');
        rsort($sticky);
        $sticky = array_slice($sticky, 0, 6);
        $stickyPosts = get_posts(array('ignore_sticky_posts' => 1, 'post__in' => $sticky, 'post_type' => ['post', 'media', 'news', 'photo']));
        ?>
        <div class="posts__list">
            <div class="row">
                <?php foreach($lastPosts as $post) : ?>
                    <div class="posts__item">
                        <?php tribunaPostCard($post); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <?php
                    foreach ($topPosts as $topPost) :
                ?>
                    <div class="posts__item-md">
                        <?php tribunaPostCard($topPost, "--middle") ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php wp_reset_query(); ?>