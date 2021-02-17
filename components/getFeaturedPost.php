<?php
$sticky = get_option("sticky_posts");
rsort($sticky);
$sticky = array_slice($sticky, 0, 2);
$query_posts = new WP_Query(array("ignore_sticky_posts" => 1, "post__in" => $sticky, "post_type" => ["post", "media", "news", "photo"]));
//tribunaPostCard($post);