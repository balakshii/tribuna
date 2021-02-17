<div class="postCard<?php echo $class;?>" data-postId="<?php echo $post->ID; ?>">
    <?php $categories = get_the_category($post->ID);
    if (!empty($categories) && $categories[0]->cat_ID != 1) :
        $category = $categories[0];
        ?>
        <a href="<?php print get_category_link($category->cat_ID) ?>"
           class="postCard__label"><?= $category->cat_name ?></a>
    <?php endif ?>
    <div class="postCard__imgContainer">
        <a href="<?php echo get_the_permalink($post); ?>">
            <?php
                if ($class == "--middle"){
                    echo get_the_post_thumbnail($post->ID, 'tribuna-postCard-min',array("class" => "postCard__img"));
                }else{
                    echo get_the_post_thumbnail($post->ID, 'tribuna-postCard',array("class" => "postCard__img"));
                }
            ?>
        </a>
    </div>
    <?php
    $author = $post->post_author;
    ?>
    <?php if ($post->post_type == "post"  && !is_author()) : ?>
        <a href="<?php echo get_author_posts_url(get_the_author_meta("ID",$author)); ?>" class="postCard__author">
            <?php echo get_avatar(get_the_author_meta("ID", $author),50)?>
        </a>
        <div class="postCard__authorTooltip"><?php echo get_the_author_meta("first_name", $author) . " " . get_the_author_meta("last_name", $author); ?>
            <a href="<?php echo get_author_posts_url(get_the_author_meta("ID",$author)); ?>">
                <?php echo count_user_posts($author, "post", true); ?>
                записи</a></div>
    <?php endif; ?>
    <?php if (get_field("hasVideo", $post)) : ?>
        <div class="postCard__video"><i class="fas fa-play"></i></div>
    <?php endif; ?>

    <h3 class="postCard__title"><a
                href="<?php echo get_permalink($post); ?>"><?php echo get_the_title($post); ?></a>


        <?php if (get_field("authorsMaterial",$post)) : ?>
            <div class="postCard__t"></div>
        <?php endif; ?>
        <?php if (get_field("isAdvertising",$post)) : ?>
            <div class="postCard__p"></div>
        <?php endif; ?>
    </h3>
    <div class="postCard__meta">
        <div>
            <div class="postCard__date"><?php echo tribunaDate($post);?></div>
            <?php if ($post->comment_count > 0) : ?>
                <div class="postCard__border"></div>
                <div class="postCard__comments"><?php echo $post->comment_count; ?></div>
            <?php endif; ?>
        </div>
        <div class="postCard__category">
            <?php
                if ($post->post_type == "photo"){
                    if (get_field("photos")){
                        $media_count = count(get_field("photos"));
                    }else{
                        $media_count = count(get_attached_media( 'image',$post ));
                    }
                    echo $media_count;
                }
            ?>
            <?php echo getCyrPostType($post->post_type) ?>
        </div>
    </div>
</div>