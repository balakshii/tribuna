<?php
global $sliderPosts;
?>
<ul class="slider owl-carousel">
    <?php foreach ($sliderPosts as $item) : ?>
        <li class="slider__item" data-postId="<?php echo $item->ID; ?>">
            <div class="slider__imgContainer">
                <a href="<?php echo get_the_permalink($item); ?>">
                    <?php echo get_the_post_thumbnail($item, "tribuna-slider",array("alt" => get_the_title($item), "class" => "slider__img")); ?>
                </a>
                <div class="slider__meta">
                    <?php $author = $item->post_author; ?>
                    <a class="slider__author"
                       href="<?php echo get_author_posts_url(get_the_author_meta("ID", $author)); ?>">
                        <?php echo get_avatar(get_the_author_meta("ID", $author), 74) ?>
                    </a>
                    <?php if (get_field("hasVideo", $item)) : ?>
                        <div class="slider__itemType">
                            <div class="slider__video"><i class="fas fa-play"></i></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="slider__footer">
                <div class="slider__meta">
                    <div class="slider__date"><?php echo get_the_time("d/m", $item); ?><span
                            class="slider__time"><?php echo get_the_time("H:m", $item); ?></span>
                        <?php if ($item->comment_count > 0) : ?>
                        <span class="slider__comments"><?php echo $item->comment_count; ?><i class="fal fa-comment"></i></span>
                        <?php endif; ?>
                    </div>
                </div>
                <h2 class="slider__title">
                    <a
                        href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a>
                </h2>
            </div>
        </li>
    <?php endforeach; ?>
</ul>