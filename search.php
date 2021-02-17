<?php get_header();
$search_posts = new WP_Query(array(
    'post_type' => array('post', 'news', 'photo', 'media'),
    'posts_per_page' => 13,
    's' => get_search_query()
));
$prev_post = "";
?>
<section class="categoryPosts">
    <div class="container">
        <h1 class="main__title">Результати пошуку</h1>
        <div class="wrapColumn">
            <div class="columnMain excluded_area">
                <div class="boxSearchInput">
                    <form action="/" method="get">

                        <input type="text" name="s" value="<?php echo get_search_query(); ?>">
                    </form>
                </div>
                <div class="posts__col3">
                    <?php if ($search_posts->have_posts()) : ?>
                        <?php
                        for ($i = 0; $i < 3; $i++) : ?>
                            <?php if ($search_posts->have_posts()) : $search_posts->the_post(); ?>
                                <?php if ($prev_post !== $post) : ?>
                                    <div class="posts__item">
                                        <?php tribunaPostCard($post); ?>
                                    </div>
                                <?php endif; ?>
                                <?php $prev_post = $post; endif; ?>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
                <?php if ($search_posts->have_posts()) : ?>
                    <div class="postsShort">
                        <div class="postsShort__items" id="posts-2">
                            <?php while ($search_posts->have_posts()) : $search_posts->the_post(); ?>
                                <div class="postShortCard" data-postId="<?php echo get_the_ID(); ?>">
                                    <h3 class="postShortCard__title"><a
                                                href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="postShortCard__meta">
                                        <div class="postShortCard__date"><?php echo tribunaDate($post);?></div>
                                        <?php if ($post->comment_count > 0) : ?>
                                            <div class="postShortCard__border"></div>
                                            <div class="postShortCard__comments"><?php echo $post->comment_count; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                        </div>
                        <button class="btn btn-white" data-load-more="posts-2" data-page-type="search"
                                data-search-query="<?php echo get_search_query(); ?>"
                        />
                        Більше матеріалів
                        <div class="btn__load"><i class="fas fa-sync fa-spin"></i></div>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>
<?php get_footer() ?>
