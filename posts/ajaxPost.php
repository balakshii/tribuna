<?php
add_action("wp_ajax_get_posts", "get_posts_callback");
add_action("wp_ajax_nopriv_get_posts", "get_posts_callback");
add_action("wp_ajax_add_like", "add_like_callback");
add_action("wp_ajax_nopriv_add_like", "add_like_callback");
function get_posts_callback()
{
    $rendered = implode(",", $_POST["rendered"]);
    $attr = array(
        "numberposts" => 4,
        "post_type" => "post",
        "exclude" => $rendered
    );

    if ($_POST["pageType"] == "category" || $_POST["pageType"] == "search") {
        if ($_POST["pageType"] == "category") {
            $posts = get_posts(array("category__in" => $_POST["categoryId"], "numberposts" => 10, "post_type" => ["post", "media", "news", "photo"], "exclude" => $rendered));
        }
        if ($_POST["pageType"] == "search") {
            $posts = get_posts(array("s" => $_POST["search_query"], "numberposts" => 8, "post_type" => ["post", "media", "news", "photo"], "exclude" => $rendered));
        }
        foreach ($posts as $post) : ?>
            <div class="postShortCard" data-postId="<?php echo $post->ID; ?>">
                <h3 class="postShortCard__title">
                    <a
                            href="<?php the_permalink($post); ?>">
                        <?php echo get_the_title($post); ?>
                    </a>
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
        <?php
        endforeach;
        die;
    } else {
        if ($_POST["pageType"] == "author") {
            $attr["author"] = $_POST["authorId"];
            $attr["post_type"] = ["post", "media", "news", "photo"];
        } elseif ($_POST["pageType"] == "news") {
            $attr["post_type"] = "news";
            $posts = get_posts($attr);
        } elseif ($_POST["pageType"] == "news") {
            $attr["post_type"] = "news";
            $posts = get_posts($attr);
        } elseif ($_POST["pageType"] == "blogs") {
            $attr["post_type"] = "post";
            $posts = get_posts($attr);
        } elseif ($_POST["pageType"] == "media") {
            $attr["post_type"] = "media";
            $posts = get_posts($attr);
        } elseif ($_POST["pageType"] == "photo") {
            $attr["post_type"] = "photo";
        } elseif ($_POST["pageType"] == "tag") {
            $attr["post_type"] = ["post", "media", "news", "photo"];
            $attr["tag"] = $_POST["tagId"];
        } else {
            $attr["post_type"] = ["post", "media", "news", "photo"];
        }
        $posts = get_posts($attr);
    }
    ?>

    <?php foreach ($posts as $post) : ?>
    <div class="posts__item">
        <?php tribunaPostCard(get_post($post->ID)); ?>
    </div>
<?php
endforeach;
    wp_die();
} ?>
<?php
function add_like_callback()
{
    $attr = array();
    $comment_likes = get_comment_meta($_POST["comment_id"], "like");
    $is_user_like = false;
    foreach ($comment_likes as $comment_like) {
        if ($comment_like == $_COOKIE["tribuna_user_id"]) {
            $is_user_like = true;
        }
    }
    $attr["is_user_like"] = $is_user_like;
    if ($is_user_like) {
        delete_comment_meta($_POST["comment_id"], "like", $_COOKIE["tribuna_user_id"]);
        $attr["liked"] = false;
    } else {
        add_comment_meta($_POST["comment_id"], "like", $_COOKIE["tribuna_user_id"]);
        $attr["liked"] = true;
    }
    $attr["like_count"] = count(get_comment_meta($_POST["comment_id"], "like"));
    echo json_encode($attr);
    wp_die();
}