<div class="container">
    <div class="section blogs">
        <h2 class="blogs__title">
            <a href="/blogs">Блоги</a>
        </h2>
        <div class="blogs__list">
            <?php
            $role_ids = authorIds();
            $args = array(
                "posts_per_page" => 3,
                'ignore_sticky_posts' => 1,
                "post_type" => "post",
                "author__in" => $role_ids
            );
            query_posts($args);
            if (have_posts()): while (have_posts()): the_post();
                $author = $post->post_author;
                ?>
                <a href="<?php the_permalink(); ?>" class="blogItem">
                    <?php echo get_avatar(get_the_author_meta("ID", $author), 100, '', '', array(
                        'class' => 'blogItem__author'
                    )) ?>
                    <div class="blogItem__title">
                        <span><?php the_title() ?></span>
                        <div class="blogItem__date"><?php print get_the_time('d F Y') ?></div>
                    </div>
                </a>
            <?php endwhile; endif ?>
        </div>
    </div>
</div>