<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/dist/css/fonts.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/dist/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/dist/libs/owl/assets/owl.carousel.min.css">
    <link rel="stylesheet"
          href="<?php echo get_template_directory_uri() ?>/dist/libs/owl/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/dist/css/style.min.css">
    <?php if (is_single() && get_post_type() == 'photo'): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/dist/css/gallery.css">
    <?php endif ?>
    <?php if (get_page_template_slug() == "shop.php") : ?>
        <link type="text/css" rel="stylesheet"
              href="<?php echo get_template_directory_uri() ?>/bower_components/lightgallery/dist/css/lightgallery.min.css">
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <title><?php wp_title(); ?></title>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="google-site-verification" content="gBrY5OHtjWkNZmf7SwVKeT9ywaSliden397HX2Dk_VY"/>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-4175468511260873",
            enable_page_level_ads: true
        });
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>


<div class="mobileMenuBox">
    <button class="searchControl"><i class="fal fa-search"></i></button>
    <ul class="menu">
        <?php wp_nav_menu(array('container' => '', 'menu' => 'TopMenu2', 'items_wrap' => '%3$s',)); ?>
    </ul>
</div>
<div class="header">
    <div class="container">
        <div class="header__firstColumn">

            <button class="btn-close"></button>
            <button class="navControl">
                <div class="navControl__line"></div>
                <div class="navControl__line"></div>
                <div class="navControl__line"></div>
            </button>
            <a class="logo" href="/"></a>
            <ul class="header__menu">
                <?php wp_nav_menu(array('container' => '', 'menu' => 'TopMenu2', 'items_wrap' => '%3$s',)); ?>

            </ul>
        </div>
        <div class="header__secondColumn">
            <button class="searchControl"><i class="fal fa-search"></i></button>
            <div class="currency owl-carousel" id="currencyCarusel">
                <div class="currency__item">
                    <div class="currency__title">А95 – <?php echo getOilPrice(); ?> грн.</div>
                    <div class="currency__label">Пальне</div>
                </div>
                <div class="currency__item">
                    <div class="currency__title">$ – <?php echo getCurrency(); ?> грн.</div>
                    <div class="currency__label">Курс</div>
                </div>
                <div class="currency__item">
                    <div class="currency__title"><i class="fab fa-bitcoin"></i> – <?php getBitcoinPrice(); ?></div>
                    <div class="currency__label">Курс</div>
                </div>
            </div>
            <ul class="socialButtons">
                <li><a class="fab fa-facebook-f"
                       href="https://www.facebook.com/pages/%D0%A2%D1%80%D0%B8%D0%B1%D1%83%D0%BD%D0%B0/1589365837950876"
                       target="_blank"></a>
                </li>
                <li><a class="fab fa-instagram" href="https://instagram.com/tribuna.pl.ua" target="_blank"></a></li>
                <li><a class="fab fa-twitter" href="https://twitter.com/tribunaPL" target="_blank"></a></li>
                <li><a class="fab fa-youtube" href="https://www.youtube.com/channel/UCmmmMOR9CjbcgV8neCINReg"
                       target="_blank"></a></li>
                <li><a class="fab fa-telegram-plane" href="https://t.me/tribuna_pl" target="_blank"></a></li>
            </ul>
        </div>
    </div>
</div>
<main role="main">