<?php
if (get_field("photos")) {
    $media = get_field("photos");
} else {
    $media = get_attached_media('image');
}

if (!empty($media) && count($media) > 1):
    $template_url = get_bloginfo('template_url');
    ?>
    <div id="jssor_1"
         style="position:relative;margin:0 auto;top:0px;left:0px;width:800px;height:500px;overflow:hidden;visibility:hidden;background-color:#24262e;">
        <!-- Loading Screen -->
        <div data-u="loading"
             style="position:absolute;top:0px;left:0px;background:url('<?= $template_url ?>/dist/img/loading.gif') no-repeat 50% 50%;background-color:rgba(0, 0, 0, 0.7);"></div>
        <div data-u="slides"
             style="cursor:default;position:relative;top:0px;left:0px;width:800px;height:500px;overflow:hidden;">
            <?php foreach ($media as $image): ?>
                <div>
                    <?php
                        if (get_field("photos")) {
                            echo wp_get_attachment_image($image["ID"], 'large', false, ['data-u' => 'image']);
                            echo wp_get_attachment_image($image["ID"], 'little-thumb', false, ['data-u' => 'thumb']);
                        }else{
                            echo wp_get_attachment_image($image->ID, 'large', false, ['data-u' => 'image']);
                            echo wp_get_attachment_image($image->ID, 'little-thumb', false, ['data-u' => 'thumb']);
                        }
                    ?>

                </div>
            <?php endforeach ?>
        </div>
        <!-- Thumbnail Navigator -->
        <div data-u="thumbnavigator" class="jssort01"
             style="position:absolute;left:0px;bottom:0px;width:800px;height:100px;" data-autocenter="1">
            <!-- Thumbnail Item Skin Begin -->
            <div data-u="slides" style="cursor: default;">
                <div data-u="prototype" class="p">
                    <div class="w">
                        <div data-u="thumbnailtemplate" class="t"></div>
                    </div>
                    <div class="c"></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora05l" style="top:158px;left:8px;width:40px;height:40px;"></span>
        <span data-u="arrowright" class="jssora05r" style="top:158px;right:8px;width:40px;height:40px;"></span>
    </div>
<?php endif ?>