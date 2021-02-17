<?php
    global $topMonthlyCommentedPosts;
?>
<div class="featuredPosts__list ">
    <?php foreach ($topMonthlyCommentedPosts as $item) :  ?>
        <div class="topPost">
            <a href="<?php echo get_the_permalink($item); ?>">
                <div class="topPost__meta">
                    <div class="topPost__date"><?php echo get_the_time('d/m', $item); ?></div>
                    <div class="topPost__time"><?php echo get_the_time('H:m', $item); ?></div>
                    <div class="topPost__border"></div>

                    <?php if (get_field("hasVideo", $item)) : ?>
                        <div class="topPost__video"></div>
                    <?php else : ?>
                        <?php if ($item->comment_count > 0) : ?>
                            <div class="topPost__comments"><?php echo $item->comment_count; ?>
                                <i class="fal fa-comment"></i>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (get_field("authorsMaterial", $item)) : ?>
                        <div class="topPost__t"></div>
                    <?php endif; ?>
                    <?php if (get_field("isAdvertising", $item)) : ?>
                        <div class="topPost__p"></div>
                    <?php endif; ?>
                </div>
                <h3 class="topPost__title">
                    <span><?php echo get_the_title($item); ?></span>
                </h3>
            </a>
        </div>
    <?php endforeach; ?>
</div>