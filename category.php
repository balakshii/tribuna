<?php get_header();

$sticky = get_option('sticky_posts');
rsort($sticky);
$sticky = array_slice($sticky, 0, 6);
$stickyPosts = get_posts(array('ignore_sticky_posts' => 1, 'post__in' => $sticky, 'post_type' => ['post', 'media', 'news', 'photo']));
$category_id = get_queried_object()->term_id;
$top_category_posts = new WP_Query(array(
    'ignore_sticky_posts' => 1,
    'post__in' => $sticky,
    'post_type' => array('post', 'news', 'photo', 'media'),
    'post_per_page' => 10,
    'cat' => $category_id
));
$exclude_ids = array();
?>
<section class="categoryPosts">
    <div class="container">
        <h1 class="main__title" style="text-transform: uppercase"><?php
            single_term_title('', true)
            ?></h1>
        <div class="wrapColumn">
            <div class="columnMain">
                <?php if ($top_category_posts->have_posts()) : /*?>
                    <ul class="slider owl-carousel">
                        <?php while ($top_category_posts->have_posts()) : $top_category_posts->the_post();
                            $exclude_ids[] = $post->ID; ?>
                            <li class="slider__item">
                                <div class="slider__imgContainer">
                                    <a href="<?php echo get_the_permalink($post); ?>">
                                        <?php echo get_the_post_thumbnail($item, "tribuna-slider",array("alt" => get_the_title($item), "class" => "slider__img")); ?>
                                    </a>
                                    <div class="slider__meta">
                                        <?php $author = $post->post_author; ?>
                                        <a class="slider__author"
                                           href="<?php echo get_author_posts_url(get_the_author_meta("ID", $author)); ?>"
                                           >
                                            <?php echo get_avatar(get_the_author_meta("ID", $author), 74) ?>
                                        </a>
                                        <?php if (get_field('hasVideo')) : ?>
                                            <div class="slider__itemType">
                                                <div class="slider__video"><i class="fas fa-play"></i></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="slider__footer">
                                    <div class="slider__meta">
                                        <div class="slider__date"><?php the_time('d/m') ?><span
                                                    class="slider__time"><?php the_time('H:m') ?></span><span
                                                    class="slider__comments"><?php echo $post->comment_count; ?><i
                                                        class="fal fa-comment"></i></span>
                                        </div>
                                    </div>
                                    <h2 class="slider__title"><a
                                                href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <!--                                    <div class="slider__label">ВІДЕО ТИЖНЯ</div>-->
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php */
                endif; ?>
                <?php
                $category_posts = new WP_Query(array(
                    'post_type' => array('post', 'news', 'photo', 'media'),
                    'posts_per_page' => 13,
                    'cat' => $category_id,
                    'post__not_in' => $exclude_ids
                ));
                ?>
                <div class="posts__col3 excluded_area">
                    <div class="posts__item">
                        <?php $category_posts->the_post() ?>
                        <?php tribunaPostCard($post); ?>
                    </div>
                    <div class="posts__item">
                        <?php $category_posts->the_post() ?>
                        <?php tribunaPostCard($post); ?>
                    </div>
                    <div class="posts__item">
                        <?php $category_posts->the_post() ?>
                        <?php tribunaPostCard($post); ?>
                    </div>
                </div>
                <div class="postsShort excluded_area">
                    <div class="postsShort__items" id="posts-2">
                        <?php while ($category_posts->have_posts()) : $category_posts->the_post(); ?>
                            <div class="postShortCard" data-postId="<?php echo get_the_ID(); ?>">
                                <h3 class="postShortCard__title"><a
                                            href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <?php if (get_field("authorsMaterial")) : ?>
                                        <div class="postCard__t"></div>
                                    <?php endif; ?>
                                    <?php if (get_field("isAdvertising")) : ?>
                                        <div class="postCard__p"></div>
                                    <?php endif; ?>
                                </h3>

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
                    <button class="btn btn-white" data-load-more data-page-type="category"
                            data-catogory-id="<?php echo $category_id ?>"
                    />
                    Більше матеріалів
                    <div class="btn__load"><i class="fas fa-sync fa-spin"></i></div>
                    </button>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>
<?php get_footer() ?>
