<?php get_header();
$attr = array("posts_per_page" => 14,"ignore_sticky_posts"=>1);
$page_title = "";
$count_posts = "";
$button_attr = "";
global $wp_query;
if ($wp_query->query["author_name"]) {
    $post_type = "author";
    $authorId = get_query_var('author');
    $userData = get_userdata($authorId);
    $attr["post_type"] = array("post", "news", "media", "photo");
    $attr["author"] = $authorId;
    $count_posts = count_user_posts($authorId,array("post", "news", "media", "photo"));
    $attr["posts_per_page"] = 14;
    $button_attr .= " data-author-id='" . $authorId . "' ";
    $post_type = "author";
} elseif ($wp_query->query["tag"]) {
    $page_title = get_the_archive_title();
    $attr["tag"] = $wp_query->query["tag"];
    $attr["posts_per_page"] = 14;
    $attr["post_type"] = array("post", "news", "media", "photo");
    $post_type = "tag";
    $button_attr .= " data-tag-id='" . $wp_query->query["tag"] . "' ";
} elseif ($wp_query->query["pagename"] == "blogs") {
    $page_title = "Блоги";
    $attr["post_type"] = "post";
    $post_type = "blogs";
} elseif ($wp_query->query["post_type"]) {
    $post_type = $wp_query->query["post_type"];
    if ($post_type == "photo") {
        $page_title = "Фотогалерея";
    } elseif ($post_type == "news") {
        $attr["posts_per_page"] = 14;
        $page_title = "Стрічка новин";
    } elseif ($post_type == "photo") {
        $page_title = "Фотогалерея";
    } elseif ($post_type == "media") {
        $page_title = "Медіа";
    }
    $attr["post_type"] = $post_type;
}


$posts = new WP_Query($attr);

?>
<?php if ($authorId) : ?>
    <section class="authorInfo">
        <div class="container">
            <?php print get_avatar($authorId, 133); ?>
            <div class="authorInfo__name"><span><?php print $userData->display_name; ?></span></div>
            <div class="authorInfo__quantity"><?php echo $count_posts; ?> записи</div>
        </div>
    </section>
<?php endif; ?>
<section class="posts excluded_area">
    <div class="container">
        <?php if ($page_title) : ?>
            <h1 class="main__title">
                <?php echo $page_title; ?>
            </h1>
        <?php endif; ?>
        <div class="posts__list" id="posts-2">
            <div class="row">
                <?php for ($i = 0; $i < 2; $i++) : ?>
                    <?php if ($posts->have_posts()) : $posts->the_post(); ?>
                        <div class="posts__item-md">
                            <?php tribunaPostCard($post, "--middle") ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>

            </div>
            <?php if ($posts->have_posts()) : ?>
            <div class="row">
                <?php $i = 0;
                while ($posts->have_posts()) :
                $i++;
                $posts->the_post(); ?>
                <div class="posts__item">
                    <?php tribunaPostCard($post); ?>
                </div>
                <?php if ($i % 4 == 0) : ?>
            </div>
            <div class="row">
                <?php endif; ?>
                <?php
                endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($count_posts == "" || $count_posts > 12) : ?>
            <button class="btn btn-white" <?php echo $button_attr; ?> data-load-more data-page-type="<?php echo ($post_type) ? $post_type : ""; ?>">
                Більше матеріалів
                <div class="btn__load"><i class="fas fa-sync fa-spin"></i></div>
            </button>
        <?php endif; ?>
    </div>
</section>
<?php get_footer() ?>
