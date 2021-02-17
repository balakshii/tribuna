<?php global $mostViewedPosts;?>
<section class="quote">
    <div class="container">
        <div class="owl-carousel">
            <?php foreach ($mostViewedPosts as $item) : ?>
                <div class="quote__item">
                    <a href="<?php the_permalink($item); ?>" title="<?php echo get_the_title($item); ?>">
                        <h3 class="quote__title">
                            <?php echo get_the_title($item); ?>
                        </h3>
                        <span class="quote__link">
                            Детальніше
                            <i class="fal fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>