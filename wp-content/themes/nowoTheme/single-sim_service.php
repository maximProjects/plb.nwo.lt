<?php get_header();

$product = SIM_Product::getById(get_the_ID());
$terms = wp_get_post_terms($product->id, 'sim_product_category');
$term = array_shift(array_values($terms));
if ($term->parent > 0) {
    $term = get_term($term->parent, 'sim_product_category');
}
?>


<section>

    <div class="container">

        <h2 class="title section-header">
            <span><?php echo get_the_title(); ?></span>
        </h2>

        <div class="content-container page-content">
            <div class="row">
                <div class="col-md-12 content">

                    <?php echo apply_filters('the_content', get_the_content()); ?>

                    <?php $gallery = apply_filters('pim_gallery_images', get_the_ID(), false); ?>

                    <div class="row">
                        <div class="gallery-carousel" data-slide-nb="3">
                            <?php foreach($gallery as $image): ?>
                                <div class="slide col-md-4">
                                    <a href="<?php echo $image->guid; ?>" data-rel="lightbox_<?php echo get_the_ID(); ?>">
                                        <img src="<?php echo apply_filters('pim_image_url', $image->ID, 'large'); ?>" alt="" class="img-responsive">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="btn-group-exclusive">
                        <a href="<?php echo get_permalink(get_page_by_template('inner-page-pricelist')); ?>" class="btn btn-exclusive extra" target="_blank">
                            <?php echo __('Show prices', 'nowotheme'); ?>
                        </a>
                        <a href="" class="btn btn-exclusive extra" data-toggle="modal" data-target="#requestModal">
                            <?php echo __('Query form', 'nowotheme'); ?>
                        </a>
                    </div>


                    <a class="link-back" href="<?php echo get_permalink(get_page_by_template('inner-page-services')); ?>"><?php echo __('Back to all services', 'nowotheme'); ?></a>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content form-container">
                        <div class="form-block form-exclusive">

                            <h4 class="title"><?php echo __('Contact us', 'nowotheme'); ?></h4>

                            <?php echo do_shortcode('[contact-form-7 id="267" title="Užklausos forma"]'); ?>

                            <div class="modal-footer no-padding-right no-padding-left">
                                <button type="button" class="btn btn-exclusive pull-right" data-dismiss="modal"><?php echo __('Close', 'nowotheme'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</section>


<?php get_footer(); ?>
