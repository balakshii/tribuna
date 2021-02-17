<?php
add_theme_support('post-thumbnails');
add_image_size('tribuna-ava', 133, 133, true);
add_image_size('tribuna-ava-semi', 100, 100, true);
add_image_size('tribuna-ava-mid', 74, 74, true);
add_image_size('tribuna-ava-small', 50, 50, true);
add_image_size('tribuna-postCard', 318, 200, true);
add_image_size('tribuna-postCard-mid', 640, 356, true);
add_image_size('tribuna-slider', 956, 548, true);
add_image_size('tribuna-little-post', 22, 18, true);

//add_filter( 'the_title',                  'wptexturize' );
add_filter('the_content', 'tribunaContent');
//add_filter( 'the_excerpt',                'wptexturize' );
//add_filter( 'the_post_thumbnail_caption', 'wptexturize' );
//add_filter( 'comment_text',               'wptexturize' );
//add_filter( 'list_cats',                  'wptexturize' );
//add_filter( 'widget_text_content',        'wptexturize' );
//add_filter( 'the_excerpt_embed',          'wptexturize' );
function tribunaContent($content)
{
    $content = str_replace('&#8220;', "&#171;", $content);
    $content = str_replace('&#8221;', "&#187;", $content);
    return $content;
}

function tribunaDate($post_object)
{
    date_default_timezone_set("Europe/Kiev");
    $label = "";
    if (is_object($post_object)) {
        $current_date = strtotime($post_object->post_date);
    } else {
        $current_date = strtotime($post_object);
    }

    $in_minutes = ceil((time() - $current_date) / 60);
    $in_hours = ceil((time() - $current_date) / 3600);
    $in_days = ceil((time() - $current_date) / 86400);
    //dump($in_minutes);
    if ($in_minutes < 1) {
        $label = "1 хв. тому";
    } elseif ($in_minutes <= 60) {
        $label = $in_minutes . " хв. тому";

    } elseif ($in_hours >= 1 && $in_hours <= 24) {
        $label = $in_hours . " год. тому";
    } elseif ($in_days >= 1 && $in_days <= 30) {
        $label = $in_days;
        if ($in_days == 1 || $in_days == 21) {
            $label .= " день. тому";
        } elseif (($in_days >= 2 && $in_days <= 4) || ($in_days >= 22 && $in_days <= 24)) {
            $label .= " дні. тому";
        } else {
            $label .= " днів. тому";
        }

    } else {
        $label = date('Y-m-d', $current_date);
    }
    return $label;
}

if (!isset($_COOKIE["tribuna_user_id"])) {
    setcookie("tribuna_user_id", uniqid("user_id_", true), time() + (3600 * 24 * 365 * 10));
}

//Librrarties
require_once "libs/memCached.php";

include('admin/postView.php');
include('posts/ajaxPost.php');

show_admin_bar(false);

add_filter('show_admin_bar', '__return_false');
function getBitcoinPrice()
{
    require_once "libs/coinmarketcup.php";
}

function getCurrency()
{
    $cache = MemcachedConnect::getInstance()->getConnect();
    $currency = $cache->get('getCurrency');
    if (empty($currency)) {
        $url = 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5';
        $data = file_get_contents($url);
        $currency = json_decode($data);
        $currency = round($currency[0]->buy, 2);
        $cache->set('getCurrency', $currency, false, 3600);
    }
    return $cache->get('getCurrency');
}


function getOilPrice()
{
    $cache = MemcachedConnect::getInstance()->getConnect();
    $price = $cache->get('getOilPrice');
    if (empty($price)) {
        require_once "libs/simple_html_dom.php";
        $html = file_get_html('http://vseazs.com/');
        $price = strip_tags($html->getElementById("price_bar_3")->childNodes(1));
        $cache->set('getOilPrice', $price, false, 3600);
    }
    return $cache->get('getOilPrice');
}

function getWeather()
{
    $cache = MemcachedConnect::getInstance()->getConnect();
    $weather = $cache->get('getWeather');
    if (empty($weather)) {
        $url = 'http://meteo.ua/informer/get.php?cities=58';
        $data = file_get_contents($url);

        preg_match('/<div class="meteo_infor_temp">(.*)<\/div>/i', $data, $matches);
        if (empty($matches[1])) {
            return 0;
        }
        $weather = $matches[1];
        $cache->set('getWeather', $weather, false, 1200);
    }
    /*if ($weather > 0) {
        return '+'.$weather;
    }*/

    return $weather;
}

function sortPosts($posts)
{
    foreach ($posts as &$single) {
        $single->time = strtotime($single->post_date);
    }

    usort($posts, function ($a, $b) {
        if ($a->time == $b->time) {
            return 0;
        }
        return ($a->time > $b->time) ? -1 : 1;
    });

    return $posts;
}


function tribuna_setup()
{

    register_nav_menus(array(
        'header' => __('Header menu', 'tribuna'),
        'footer' => __('footer menu', 'tribuna'),
    ));
}

add_action('after_setup_theme', 'tribuna_setup');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');


add_theme_support('post-formats', array(
    'image', 'video'
));


function tribuna_add_custom_types($query)
{
    if (is_category() || is_tag() && empty($query->query_vars['suppress_filters'])) {
        $query->set('post_type', array(
            'post', 'nav_menu_item', 'news', 'media'
        ));
        return $query;
    }
}

add_filter('pre_get_posts', 'tribuna_add_custom_types');
add_filter('wp_trim_words', 'shortcode_unautop');
add_filter('wp_trim_words', 'do_shortcode');
add_filter('the_excerpt', 'shortcode_unautop');
add_filter('the_excerpt', 'do_shortcode');
add_filter('get_the_excerpt', 'shortcode_unautop');
add_filter('get_the_excerpt', 'do_shortcode');


function limit_posts_per_archive_page()
{
    if (is_search()) {
        $limit = 20;
        set_query_var('posts_per_archive_page', $limit);
    }
}

add_filter('pre_get_posts', 'limit_posts_per_archive_page');


function authorIds()
{
    $ids = get_users(array('role' => 'author', 'fields' => 'ID'));
    return $ids;
}

function notAuthorIds()
{
    $ids = get_users(array('role__not_in' => 'author', 'fields' => 'ID'));
    return $ids;
}

function getCategoryWithCount()
{
    $categories = get_categories('exclude=1&title_li=');
    $result = array();
    foreach ($categories as $cat) {
        $result[$cat->cat_ID] = $cat->category_count;
    }

    arsort($result);

    return array_slice($result, 0, 3, true);
}

function toz_force_https()
{
    if (!is_ssl()) {
        wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
        exit();
    }
}

add_action('template_redirect', 'toz_force_https', 1);

function myprefix_unregister_tags()
{
    unregister_taxonomy_for_object_type('post_tag', 'post');
}

add_action('init', 'myprefix_unregister_tags');


add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function removeEmptyParagraphs($content)
{
    $content = str_replace("<p>&nbsp;</p>", "", $content);

    return $content;
}

add_filter('the_content', 'removeEmptyParagraphs', 99999);


wp_enqueue_script('comment-reply');
add_action('wp_footer', 'my_footer_scripts');
function my_footer_scripts()
{
    if (!is_single()) return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            var data = {
                action: 'action_view_post',
                viewPostId: <?=get_the_ID()?>
            };

            jQuery.post('<?=admin_url('admin-ajax.php', 'relative')?>', data, function (response) {
            });
        });
    </script>
    <?php
}


add_action('wp_logout', 'go_home');
function go_home()
{
    wp_redirect(home_url());
    exit();
}

function addRssNs()
{
    print  'xmlns="http://backend.userland.com/rss2" xmlns:yandex="http://news.yandex.ru"';
}

add_action('rss2_ns', 'addRssNs');


class MyWalker_Comment extends Walker_Comment
{

    protected function comment($comment, $depth, $args)
    {
        $is_user_like = false;
        $comment_likes = get_comment_meta(get_comment_ID(), "like");
        foreach ($comment_likes as $comment_like) {
            if ($comment_like == $_COOKIE["tribuna_user_id"]) {
                $is_user_like = true;
            }
        }
        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <div class="postItemCommentItem postItemCommentItem-depth<?= $depth ?>" id="comment-<?php comment_ID(); ?>">
            <div class="postItemCommentItem__title">
                <?php comment_text(get_comment_id(), array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </div>
            <div class="postItemCommentItem__meta">
                <div class="postItemCommentItem__date"><?php echo tribunaDate($comment->comment_date) ?></div>
                <div class="postCard__border"></div>
                <div class="postItemCommentItem__author"><?php print $comment->comment_author ?></div>
                <?php
                comment_reply_link(array_merge($args, array(
                    'add_below' => $add_below,
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'before' => '<div class="postCard__border"></div>',
                    'after' => '',
                    'class' => 'postItemCommentItem__reply'
                )));
                ?>
            </div>
            <div class="postItemCommentItem__boxLike postItemCommentItem__likeEmpty">
                <a class="postItemCommentItem__like <?php echo ($is_user_like) ? "active" : ""; ?>"
                   data-comment-id="<?php comment_ID(); ?>" href="#"></a>
                <span><?php echo count($comment_likes); ?></span>
            </div>
        </div>
        <?php
    }

    public function end_el(&$output, $comment, $depth = 0, $args = array())
    {
        return;
    }

}


function myfeed_request($qv)
{
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('news', 'post', 'media', 'photo');
    return $qv;
}

add_filter('request', 'myfeed_request');

function getUsers()
{

    $args = array(
        'orderby' => 'post_count',
        'order' => 'desc',
        'number' => 50,
    );
    $users = array();
    $roles = array('contributor', 'author', 'editor');

    foreach ($roles as $role) {
        $args = array(
            'orderby' => 'post_count',
            'order' => 'desc',
            'number' => 50,
            'role' => $role
        );

        $results = get_users($args);
        if ($results) $users = array_merge($users, $results);
    }

    return $users;
}


function trim_excerpt($text)
{
    $text = str_replace(array('[', ']'), '', $text);
    return $text;
}

add_filter('get_the_excerpt', 'trim_excerpt');


function my_comment_class($class = '', $comment_id = null, $post_id = null, $echo = true)
{
    // Separates classes with a single space, collates classes for comment DIV
    $class = 'class="' . join(' ', get_comment_class($class, $comment_id, $post_id)) . ' comments_item"';
    if ($echo)
        echo $class;
    else
        return $class;
}

function groupPostsByDay($postsArray)
{
    $resultArray = array();
    foreach ($postsArray as $onePost) {
        $date = date('d-m-Y', strtotime($onePost->post_date));
        if (isset($resultArray[$date])) {
            $resultArray[$date][] = $onePost;
        } else {
            $resultArray[$date] = array();
            $resultArray[$date][] = $onePost;
        }
    }

    return $resultArray;
}


function true_russian_date_forms($the_date = '')
{
    if (substr_count($the_date, '---') > 0) {
        return str_replace('---', '', $the_date);
    }
    $replacements = array(
        "Січень" => "січня",
        "Лютий" => "лютого",
        "Березень" => "березня",
        "Квітень" => "квітня",
        "Травень" => "травня",
        "Червень" => "червня",
        "Липень" => "липня",
        "Серпень" => "серпня",
        "Вересень" => "вересня",
        "Жовтень" => "жовтня",
        "Листопад" => "листопада",
        "Грудень" => "грудня"
    );

    return strtr($the_date, $replacements);
}

add_filter('the_time', 'true_russian_date_forms');
add_filter('date_i18n', 'true_russian_date_forms');
add_filter('get_the_time', 'true_russian_date_forms');
add_filter('the_date', 'true_russian_date_forms');
add_filter('get_the_date', 'true_russian_date_forms');
add_filter('the_modified_time', 'true_russian_date_forms');
add_filter('get_the_modified_date', 'true_russian_date_forms');
add_filter('get_post_time', 'true_russian_date_forms');
add_filter('get_comment_date', 'true_russian_date_forms');

/**
 * Control the number of search results
 */
function custom_posts_per_page($query)
{
    if ($query->is_author) {
        set_query_var('posts_per_page', 100);
    }

    if ($query->is_post_type_archive('media') || $query->is_post_type_archive('photo')) {
        set_query_var('posts_per_page', 15);
    }
}

add_action('pre_get_posts', 'custom_posts_per_page');


function getRandomArticle()
{
    global $wpdb;
    $sql = "SELECT * FROM `wp_posts` WHERE post_type IN ('post', 'news', 'media', 'photo') and post_status='publish' order by rand() limit 1;";
    return $wpdb->get_row($sql);
}

function dateToRussian($date)
{
    $month = array("january" => "січня", "february" => "лютого", "march" => "березня", "april" => "квітня", "may" => "травня", "june" => "червня", "july" => "липня", "august" => "серпня", "september" => "вересня", "october" => "жовтня", "november" => "листопада", "december" => "грудня");
    $days = array("monday" => "Понедельник", "tuesday" => "Вторник", "wednesday" => "Среда", "thursday" => "Четверг", "friday" => "Пятница", "saturday" => "Суббота", "sunday" => "Воскресенье");
    return str_replace(array_merge(array_keys($month), array_keys($days)), array_merge($month, $days), strtolower($date));
}

//Vladislav's functions
function tribunaPostCard($post, $class = "")
{
    if (!$post) {
        global $post;
    }
    include 'components/postCard.php';
}




function getCyrPostType($postType, $type = "")
{
    if ($type == "single") {
        switch ($postType) {
            case "news" :
                {
                    return "Новина";
                }
            case "post" :
                {
                    return "Блог";
                }
            case "media" :
                {
                    return "Відео";
                }
            case "photo" :
                {
                    return "Фото";
                }
            default :
                return $postType;
        }
    } else {
        switch ($postType) {
            case "news" :
                {
                    return "Новини";
                }
            case "post" :
                {
                    return "Блог";
                }
            case "media" :
                {
                    return "Відео";
                }
            case "photo" :
                {
                    return "Фото";
                }
            default :
                return $postType;
        }
    }

}

function tribunaSlider()
{
    require_once "components/slider/slider.php";
}

function tribunaFeaturedPosts()
{
    require_once "components/slider/featuredPosts.php";
}

function tribunaQuote()
{
    require_once "components/quote.php";
}

function tibunaLastPostsTable()
{
    require_once "components/lastPostsTable.php";
}

function tibunaStickyPosts()
{
    require_once "components/stickyPosts.php";
}

function tribunaBlogs()
{
    require_once "components/blogs.php";
}

function tribunaPosts()
{
    require_once "components/posts.php";
}

function tribunaGetFeaturedPost()
{
    require_once "components/getFeaturedPost.php";
}


function tribunaSimilarPost()
{
    global $excluded_posts;
    if (empty($excluded_posts)) {
        global $post;
        $excluded_posts .= $post->ID . " ";
        unset($post);
    }
    $currentPost = get_posts(array(
        "numberposts" => 1,
        "post_type" => array("news"),
        "meta_key" => "topPost",
        "meta_value" => 1,
        "date_query" => array(
            "after" => "1 months ago"
        ),
        "exclude" => $excluded_posts
    ));
    $excluded_posts .= $currentPost[0]->ID . " ";
    tribunaPostCard($currentPost[0]);
}


function dump($data)
{
    if (current_user_can('administrator')) {
        echo "<pre style='position: fixed;width: 100%;height: 100%; z-index: 999999; background: white;top:0;left:0;overflow: scroll'>";
        print_r($data);
        echo "</pre>";
        die;
    }
}

add_action('wp_enqueue_scripts', 'myajax_data', 1);
function myajax_data()
{

    wp_localize_script('twentyfifteen-script', 'myajax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );

}
add_action('wp_ajax_buy', 'buy_callback');
add_action('wp_ajax_nopriv_buy', 'buy_callback');
function buy_callback() {
    $data = "";
    foreach ($_POST["data"] as $item){
        $data .= $item["name"] . ": " . $item["value"] . "\n";

    }

    wp_mail(get_field("shopEmail","option"),"Новий заказ!",$data);
    wp_mail("onvix@solutionua.com","Новий заказ!",$data);
//    wp_mail("tribuna.pl.ua@gmail.com","Новий заказ!",$data);
    echo "done";
    wp_die();
}