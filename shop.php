<?php
/*
Template Name: Shop
*/
//echo get_field("shopEmail","option");
//die;
get_header();
?>

<style>
    .tribuna__buyingWindow {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #0b0b0b96;
        z-index: 9999;
    }

    .tribuna__buyingForm {
        padding: 20px;
        position: fixed;
        z-index: 99999;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        min-width: 200px;
        max-width: 500px;
        max-height: 340px;
        background: #fff;
        margin: auto;
        box-shadow: 0 5px 8px rgba(0, 0, 0, .2);
    }

    @media screen and (max-width: 500px) {
        .tribuna__buyingForm {
            margin: auto 15px;
        }
    }

    .tribuna__buyingHeader {
        height: 50px;
        margin-bottom: 20px;
    }

    .tribuna__buyingHeader, .tribuna__buyingMeta, .tribuna__buyingMetaContainer {
        display: flex;
        align-items: center;
    }

    .tribuna__buyingMeta {
        margin-top: 10px;
    }

    .tribuna__buyingMeta input {
        display: none;
    }

    .tribuna__buyingMetaTitle {
        margin-right: 10px;
        width: 50px;
    }

    .tribuna__buyingTitle {
        line-height: 1rem;
        margin-left: 10px;
    }

    .tribuna__buyingMeta label {
        display: inline-block;
        padding: 5px 10px;
        border: 1px #fff solid;
        cursor: pointer;
    }

    .tribuna__buyingMeta input:checked + label {
        border: 1px #b41726 solid;

    }

    .tribuna__buyingInput {
        display: block;
        height: 35px;
        max-width: 337px;
        padding: 0 20px;
        margin: 20px auto 0 auto;
        border: 1px #b41726 solid;
    }

    .tribuna__buyingBtn {
        width: 100px;
        height: 35px;
        margin: 20px auto 0 auto;
        display: block;
        text-transform: uppercase;
        background-color: #b41726;
        padding: 0 10px;
        color: #fff;
        font-family: 'Museo Sans Cyrl';
        font-weight: 500;
        font-size: 12px;
        line-height: 30px;

    }

    .tribuna__buyingForm .fa-times, .tribuna__buyingDoneMessage .fa-times {
        position: absolute;
        top: -20px;
        right: 0;
        color: #fff;
        cursor: pointer;
        font-size: 15px;
    }

    .tribuna__buyingDoneMessage {
        display: none;
        padding: 20px;
        position: fixed;
        z-index: 99999;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        min-width: 200px;
        max-width: 500px;
        height: 65px;
        background: #fff;
        margin: auto;
        box-shadow: 0 5px 8px rgba(0, 0, 0, .2);
        font-size: 36px;
        text-align: center;
    }

    .postCard__label {
        bottom: 30px;
        top: auto;
        left: auto;
        right: 16px;
    }

    @media screen and (min-width: 1280px) {
        .posts__item-md:last-child, .posts__item:last-child {
            padding-right: 5px;
        }
    }


</style>
<div class="tribuna__buyingWindow">
    <div class="tribuna__buyingDoneMessage">
        <i class="fal fa-times close"></i>
        Дякуємо за замовлення!
    </div>
    <form class="tribuna__buyingForm">
        <input type="hidden" name="title" value="Футболка: Краще б кадетський відремонтували">
        <i class="fal fa-times close"></i>
        <header class="tribuna__buyingHeader">
            <img src="https://www.fatline.com.ua/images/products/backs/m_f_14.png" width="50px" height="50px" alt="">
            <h3 class="tribuna__buyingTitle">Футболка: Краще б кадетський відремонтували</h3>
        </header>


        <div class="tribuna__buyingMeta" id="sizes">
            <div class="tribuna__buyingMetaTitle">Розмір:</div>
            <div class="tribuna__buyingMetaContainer">

            </div>
        </div>
        <div class="tribuna__buyingMeta" id="colors">
            <div class="tribuna__buyingMetaTitle">Колір:</div>
            <div class="tribuna__buyingMetaContainer">

            </div>
        </div>
        <div class="tribuna__buyingMeta" id="gender">
            <div class="tribuna__buyingMetaTitle">Модель:</div>
            <div class="tribuna__buyingMetaContainer">

            </div>
        </div>
        <input type="text" class="tribuna__buyingInput" name="phone" placeholder="+380__-___-__-__" required>
        <button class="tribuna__buyingBtn" type="submit">Купить</button>

    </form>
</div>
<section class="posts lightgallery">
    <div class="container">
        <div class="postItem__head"><h1 class="postItem__title"> Трибуна: магазин атрибутики </h1>
            <div class="postItem__labels"></div>
            <div class="clearfix"></div>
        </div>
        <div class="posts__list" style="margin-top: 30px;">
            <div class="row">
                <?php $itemN = 0;
                $postsData = array();
                if (have_rows("item")) : while (have_rows("item")) :
                the_row();
                $itemN++;
                $postsData["item-" . $itemN] = array(
                    "colors" => get_sub_field("color"),
                    "gender" => get_sub_field("gender"),
                    "sizes" => get_sub_field("size")
                );

                $colors = "[";
                foreach (get_sub_field("color") as $i => $value) {
                    if ($i != 0) {
                        $colors .= ", ";
                    }
                    if ($value == "white") {
                        $colors .= $value . ':' . 'Білий';
                    }
                    if ($value == "grey") {
                        $colors .= $value . ':' . 'Сірий';
                    }
                    if ($value == "black") {
                        $colors .= $value . ':' . 'Чорний';
                    }
                }
                $colors .= "]";


                ?>
                <?php if ($itemN % 5 == 0) : ?>
            </div>
            <div class="row">
                <?php endif; ?>
                <div class="posts__item">
                    <div class="postCard">
                        <a href="#" class="postCard__label"
                           data-title="<?php the_sub_field("title"); ?>"
                           data-item="item-<?php echo $itemN; ?>">Купити</a>
                        <div class="postCard__imgContainer">
                            <?php foreach (get_sub_field("photos") as $photo) : ?>

                                <a
                                        href="<?php echo $photo["url"] ?>"> <img
                                            width="318" height="200"
                                            src="<?php echo $photo["sizes"]["medium"]; ?>"
                                            class="postCard__img wp-post-image"
                                            alt="<?php the_sub_field("title"); ?>">
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <h3 class="postCard__title"><?php the_sub_field("title"); ?></h3>
                        <div class="postCard__meta">
                            <div>

                                <div class="postCard__date">
                                    Колір:
                                    <?php
                                    //                                    dump(get_sub_field("color"));
                                    foreach (get_sub_field("color") as $i => $value) {
                                        if ($i != 0) {
                                            echo ", ";
                                        }
                                        if ($value == "white") {
                                            echo "Білий";
                                        }
                                        if ($value == "grey") {
                                            echo "Сірий";
                                        }
                                        if ($value == "black") {
                                            echo "Чорний";
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="postCard__category"> <?php the_sub_field("price"); ?> грн</div>
                        </div>
                    </div>
                </div>

                <?php endwhile;
                endif; ?>
            </div>
        </div>
    </div>
</section>
<script>
    jQuery(document).ready(function ($) {
        var items = <?php echo json_encode($postsData); ?>;

        $(".tribuna__buyingForm").submit(function (event) {
            var data = $(this).serializeArray();
            var allData = {
                action: 'buy',
                data: data
            }
            jQuery.post(myajax.url, allData, function (response) {
                if (response == "done") {
                    $(".tribuna__buyingForm").hide();
                    $(".tribuna__buyingDoneMessage").show();
                }
            });
            event.preventDefault();
        });
        $(".close").click(function () {
            $(".tribuna__buyingDoneMessage").hide();
            $(".tribuna__buyingWindow").fadeOut(300);
            $(".tribuna__buyingRadio").remove();
        });
        $(".postCard__label").click(function () {
            var title = $(this).attr("data-title");
            var colors = $(this).attr("data-colors");
            var item = $(this).attr("data-item");
            // console.log(JSON.parse()colors);
            var i = 0;
            var checked = "";
            items[item].sizes.forEach(function (element) {
                element = element.toUpperCase();
                i++;
                if (i == 1) {
                    checked = "checked";
                }
                $("#sizes .tribuna__buyingMetaContainer").append('<div class="tribuna__buyingRadio"><input type="radio" name="size" id="size' + element + '" value="' + element + '" ' + checked + '><label for="size' + element + '">' + element + '</label></div>');
                checked = "";
            });
            var gender = "";
            i = 0;
            items[item].gender.forEach(function (element) {
                i++;
                if (i == 1) {
                    checked = "checked";
                }
                if (element == "famele"){
                    gender = "Жіноча";
                }
                if (element == "male"){
                    gender = "Чоловіча";
                }
                console.log(element);
                $("#gender .tribuna__buyingMetaContainer").append('<div class="tribuna__buyingRadio"><input type="radio" name="gender" id="gender'+element+'" value="'+gender+'" '+checked+'><label for="gender'+element+'">'+gender+'</label></div>');
                checked = "";

            });

            var color = "";
            i = 0;
            items[item].colors.forEach(function (element) {
                i++;
                if (i == 1) {
                    checked = "checked";
                }
                if (element == "white") {
                    color = "Білий";
                }
                if (element == "grey") {
                    color = "Сірий";
                }
                if (element == "black") {
                    color = "Чорний";
                }
                $("#colors .tribuna__buyingMetaContainer").append('<div class="tribuna__buyingRadio"><input type="radio" name="color" id="' + element + 'Color" value="' + color + '" ' + checked + '><label for="' + element + 'Color">' + color + '</label></div>');
                checked = "";
            });
            $(".tribuna__buyingDoneMessage").hide();
            $(".tribuna__buyingTitle").html(title);
            $(".tribuna__buyingForm input[name=title]").val(title);
            $(".tribuna__buyingForm").show();
            $(".tribuna__buyingWindow").fadeIn(300);


            return false;
        });
    });
</script>
<?php get_footer(); ?>
