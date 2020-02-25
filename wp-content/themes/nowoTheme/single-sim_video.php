<?php get_header();

$product = SIM_Product::getById(get_the_ID());
$terms = wp_get_post_terms($product->id, 'sim_product_category');
$term = array_shift(array_values($terms));
if ($term->parent > 0) {
    $term = get_term($term->parent, 'sim_product_category');
}
?>


<section class="breadcrumb-block">
    <h1 class="heading breadcrumb"><?php echo get_the_title(); ?></h1>
    <?php echo dimox_breadcrumbs(); ?>
    <div class="clearfix"></div>
</section>

<section class="page-content">

    <div class="news-single-block content">

        <div class="col-sm-8 image no-padding-left">
            <?php echo apply_filters('display_image_gallery', get_the_ID(), true, false); ?>
        </div>

        <div class="col-sm-10">
            <article>
                <h3 class="header"><?php echo get_the_title(); ?></h3>
                <p class="date"><?php echo date('d-m-Y', strtotime($post->post_date)); ?></p>
                <?php echo apply_filters('the_content', get_the_content()); ?>
            </article>
        </div>
        <div class="col-sm-6">
            <?php $article = SIM_News::getById(get_the_ID()); ?>
            <?php $videos = $article->get_article_videos(1); ?>
            <?php if($videos): ?>
                <h3 class="header"><?php echo __('Video', 'nowotheme'); ?></h3>
                <div class="row">
                    <?php foreach($videos as $video): ?>
                        <div class="col-tn-24 col-xs-12 col-md-24">
                            <?php echo apply_filters('youtube_video_display', $video->_article_video_url, '260', ''); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>

        <hr class="blank separator">

    </div>

    <div class="clearfix"></div>

</section>


<?php echo get_template_part('partners'); ?>

<?php echo get_template_part('info-widgets'); ?>



<?php get_footer(); ?>
