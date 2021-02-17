<?php
global $sliderPosts;
//dump($sliderPosts);?>
<div class="lastPosts">
    <div class="lastPosts__control">
        <button class="active">ОСТАННі КОМЕНТАРІ</button>
    </div>

    <?php

    $first = true;
    $comments = get_comments(array("number" => 10,"status" => "approve" )); ?>
    <?php if (count($comments) > 0) : ?>
        <ul class="lastPosts__listItems <?php if ($first) echo "active" ?>">
            <?php foreach ($comments as $comment) :
                ?>
                <li class="lastPosts__item">
                    <h3 class="lastPosts__title">
                        <a href="<?php echo get_comment_link($comment) ?>"
                           title="<?php echo wp_trim_words($comment->comment_content, 10, '...'); ?>"><?php echo wp_trim_words($comment->comment_content, 10, '...'); ?></a>
                    </h3>
                    <?php $post = get_post($comment->comment_post_ID); ?>
                    <h4 class="lastPosts__subtitle">
                        <a href="<?php echo get_the_permalink($post); ?>"
                           title="<?php echo wp_trim_words($post->post_title, 10, '...'); ?>">
                            <?php echo wp_trim_words($post->post_title, 10, '...'); ?>
                        </a>
                    </h4>
                    <div class="lastPosts__meta">
                        <div class="lastPosts__date"><?php echo tribunaDate($comment->comment_date); ?></div>
                        <div class="lastPosts__border"></div>
                        <a class="lastPosts__author" href="<?php echo get_comment_link($comment) ?>"
                           title="<?php echo $comment->comment_author; ?>"
                        ><?php echo $comment->comment_author; ?></a>
                    </div>
                </li>
                <?php $first = false; endforeach; ?>
        </ul>
    <?php endif; ?>
</div>