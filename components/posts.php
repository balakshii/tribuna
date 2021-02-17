<section class="posts">
    <div class="container">
        <div class="posts__list excluded_area" id="posts-2">
            <div class="row">
                <?php $posts = get_posts(array("offset" => 4, 'numberposts' => 8, 'post_type' => ['news']));

                ?>
                <?php foreach ($posts as $post) : ?>
                    <div class="posts__item">
                        <?php tribunaPostCard($post); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button class="btn btn-white" data-load-more="posts-2" data-last-post-id="992">Більше матеріалів
            <div class="btn__load"><i class="fas fa-sync fa-spin"></i></div>
        </button>
    </div>
</section>