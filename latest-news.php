<h3 class="modulePosts__title">Читайте також:</h3>
<div class="posts__col3">
    <?php
    global $post;
    query_posts(['post_type' => ['post', 'media', 'news', 'photo'], 'post__not_in' => $excluded, 'ignore_sticky_posts' => true,
        'posts_per_page' => 3, 'paged' => get_query_var('page')]);
    if (have_posts()): while (have_posts()): the_post();
        $permalink = get_the_permalink();

        ?>
        <div class="posts__item">
            <?php tribunaPostCard($post); ?>
        </div>
    <?php endwhile;endif; ?>
    <?php wp_reset_query(); ?>

</div>
