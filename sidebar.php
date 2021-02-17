<div class="columnSidebar">
    <div class="posts__once">
        <?php tribunaSimilarPost(); ?>

    </div>
    <?php if (have_rows("sidebar_banners","option")) : ?>
        <div class="columnSidebar__item" id="sidebarBanner">
            <div class="owl-carousel">
                <?php while (have_rows("sidebar_banners","option")) : the_row(); ?>
                    <a href="<?php echo get_sub_field("banner_sidebar_link", "option"); ?>">

                        <img src="<?php echo get_sub_field("banner_sidebar", "option"); ?>" alt="">
                    </a>
                <?php endwhile; ?>
            </div>

        </div>
    <?php endif; ?>
    <style>
        #sidebarBanner .owl-carousel .owl-item img {
            width: 100%;
        }
        #sidebarBanner .owl-dots {
            display: none;
        }
    </style>
    <div class="columnSidebar__item boxComments">
        <div class="columnSidebar__itemTitle">Нові коментарі</div>
        <ul class="listComments">
            <?php $comments = get_comments(array("number" => 3)); ?>
            <?php foreach ($comments as $comment) :
                $postItem = get_post($comment->comment_post_ID);

                ?>
                <li class="postSidebarItem">
                    <h3 class="postSidebarItem__title"><a href="<?php echo get_comment_link($comment) ?>">
                            <?php echo wp_trim_words($comment->comment_content, 5, "..."); ?>
                    </h3>
                    <h4 class="postSidebarItem__subtitle">

                        <a href="<?php echo get_the_permalink($postItem); ?>"> <?php echo getCyrPostType(get_post_type($postItem), "single"); ?>
                            : <?php echo wp_trim_words($postItem->post_title, 5, "..."); ?></a>
                    </h4>
                    <div class="postSidebarItem__meta">
                        <div class="postSidebarItem__date"><?php echo tribunaDate($comment->comment_date . " "); ?></div>
                        <a class="postSidebarItem__author" href="<?php echo get_comment_link($comment) ?>"
                           title="<?php echo $comment->comment_author; ?>"
                        ><?php echo $comment->comment_author; ?></a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="columnSidebar__item">
        <div class="posts__once">
            <?php tribunaSimilarPost(); ?>
        </div>
    </div>
    <div class="columnSidebar__item boxComments lastNews">
        <div class="columnSidebar__itemTitle">ОСТАННІ НОВИНИ</div>
        <ul class="listLastNews">
            <?php $lastPosts = get_posts(array("numberposts" => 3, "post_type" => ["news"])); ?>
            <?php foreach ($lastPosts as $post) : ?>
                <li class="postSidebarItem">
                    <h3 class="postSidebarItem__title">
                        <a href="<?php echo get_permalink($post); ?>"><?php echo get_the_title($post); ?>
                        </a>
                    </h3>
                    <div class="postSidebarItem__meta">
                        <div class="postSidebarItem__date"><?php echo tribunaDate($post->post_date); ?></div>
                        <?php if (get_comments_number($post) > 0) : ?>
                            <div class="postCard__border"></div>
                            <div class="postCard__comments"><?php echo get_comments_number($post); ?></div>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach;
            wp_reset_postdata(); ?>
        </ul>
    </div>
</div>

