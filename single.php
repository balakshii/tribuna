<?php the_post(); ?>

<?php if (!empty($_GET['comments_show'])): ?>
    <?php if (comments_open()) :
        comments_template();
    endif; ?>
<?php else: ?>

    <?php
    get_header();
    setPostViews(get_the_ID());
    global $post;
//$post->post_date = date('Y-m-d H:i:s', strtotime($post->post_date_gmt) + 7200);
    ?>
    <section class="categoryPosts">
        <div class="container">
            <div class="wrapColumn">
                <div class="columnMain">
                    <div class="postItem">
                        <div class="postItem__tagList">
                            <?php $categories = get_the_category(get_the_ID());
                            if (!empty($categories)) {
                                foreach ($categories as $cat) {
                                    if ($cat->name != "без рубрики") {
                                        $color = categoryCustomFields_DB_GetCategoryValueById($cat->term_id, 'color');
                                        $style = '';
                                        if (!empty($color)) {
                                            $style = 'background:' . $color->field_value;
                                        }
                                        echo '<a href="' . get_term_link($cat) . '" style="' . $style . '" class="postCard__label" data-wpel-link="internal">' . $cat->name . '</a>';
                                    }

                                }
                            }
                            ?>
                        </div>
                        <div class="postItem__head">
                            <h1 class="postItem__title">
                                <?php the_title() ?>
                            </h1>
                            <div class="postItem__labels">
                                <?php if (get_field("hasVideo")) : ?>
                                    <div class="postItem__video"></div>
                                <?php endif; ?>
                                <?php if (get_field("authorsMaterial")) : ?>
                                    <div class="postItem__t"></div>
                                <?php endif; ?>
                                <?php
                                    if (get_field("isAdvertising")) {
                                        echo '<div class="postItem__p"></div>';
                                    }
                                ?>

                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <div class="postItem__meta">

                            <a class="postItem__author"
                               href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>">
                                <?php echo get_the_author_meta("first_name") . " " . get_the_author_meta("last_name"); ?>
                                <?php echo get_avatar(get_the_author_meta("ID"), 25) ?>
                            </a>
                            <div class="postItem__date"><?php echo tribunaDate($post); ?></div>
                            <?php if (comments_open()) : ?>
                                <?php if (get_comments_number() > 0) : ?>
                                    <div class="postCard__comments">
                                        <?php echo get_comments_number(); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>


                        </div>
                        <div class="postItem__body">
                            <?php if (get_post_type() == "photo") : ?>
                                <?php include "gallery.php"; ?>
                            <?php endif; ?>
                            <?php the_content(); ?>
                        </div>
                        <div class="postItem__social">
                            <script type="text/javascript"
                                    src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59877ff6819648d7"></script>
                            <div class="addthis_inline_share_toolbox"></div>
                        </div>
                        <div class="postItem__info">
                            <a class="postItem__author"
                               href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>">
                                <?php echo get_the_author_meta("first_name") . " " . get_the_author_meta("last_name"); ?>
                                <?php echo get_avatar(get_the_author_meta("ID"), 25) ?>
                            </a>
                            <div class="postItem__date"><?php echo tribunaDate($post); ?></div>
                            <?php if (comments_open()) : ?>
                                <?php if (get_comments_number() > 0) : ?>
                                    <div class="postCard__comments"><?php echo get_comments_number(); ?></div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="postItem__tags">
                                <?php $postTags = wp_get_post_tags($post->ID); ?>
                                <?php if (!empty($postTags)): ?>
                                    <?php foreach ($postTags as $tag): ?>
                                        <a href="<?php print get_term_link($tag) ?>"
                                           class="article__tag"><?php print $tag->name ?></a>
                                    <?php endforeach ?>
                                <?php endif ?>

                            </div>
                        </div>
                    </div>
                    <?php if (comments_open()) :
                        comments_template();
                    endif; ?>
                    <h3 class="modulePosts__title">Останні новини:</h3>
                    <?php $lastPosts = get_posts(array('numberposts' => 3, 'post_type' => ['post', 'news']));
                    $excluded = array(); ?>

                    <div class="posts__col3">
                        <?php foreach ($lastPosts as $post) : $excluded[] = $post->ID ?>
                            <div class="posts__item">
                                <?php tribunaPostCard($post); ?>
                            </div>
                        <?php endforeach;
                        wp_reset_postdata(); ?>
                    </div>

                    <?php include('latest-news.php') ?>
                </div>

                <?php get_sidebar(); ?>
            </div>
        </div>
    </section>
    <?php get_footer(); ?>
<?php endif; ?>
