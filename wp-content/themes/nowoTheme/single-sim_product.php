<?php get_header();

$product = SIM_Product::getById(get_the_ID());
$terms = wp_get_post_terms($product->id, 'sim_product_category');
$values = array_values($terms);
$term = array_shift($values);
if ($term->parent > 0) {
    $term = get_term($term->parent, 'sim_product_category');
}
?>


<section class="breadcrumb-block">
    <?php echo dimox_breadcrumbs(); ?>
    <div class="clearfix"></div>
</section>

<section class="page-content inline">


    <div class="product content">

        <div class="col-sm-6 image-block no-padding-left">
            <img src="<?php echo apply_filters('post_image_url', get_the_ID(), 'large') ?>" alt="" class="product-image img-responsive">

            <div class="thumbnails">
                <?php echo apply_filters('pim_gallery', $product->id, false); ?>
            </div>
        </div>

        <div class="col-sm-6 ">
            <div class="price-block">
                <div class="title text-uppercase">
                    <div class="price">
                        <?php if($product->product_price): ?>
                            <?php $parent_term = $term->parent == 0 ? $term : apply_filters('top_level_parent_term', $term->term_id, $term->taxonomy); ?>

                            <price class="text-lowercase product_price">
                                <?php echo SIM_Helper::format_price($product->product_price); ?>
                            </price>
                        <?php else: ?>
                            <?php echo __('N/d', 'nowotheme'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <h1 class="heading"><?php echo get_the_title(); ?></h1>

            <?php echo apply_filters('the_content', $product->post->post_content); ?>

            <div class="button-block">
                <hr>
                <a href="#" class="btn btn-exclusive html_popup">
                    <span><?php echo __('Order form', 'sensme'); ?></span>
                </a>
            </div>

            <div class="popup_content hidden">

                <div class="form-container">

                    <h2 class="heading"><?php echo __('Order form', 'nowotheme'); ?></h2>

                    <div class="form-block form-exclusive">

                        <?php echo do_shortcode('[contact-form-7 id="105" title="Užsakymo forma"]'); ?>
                    </div>

                </div>

            </div>
            <div class="popup_x hidden">
                <div class="popup_close"><?php echo __('Close', 'nowotheme'); ?></div>
            </div>

        </div>

        <div class="clearfix"></div>


        <?php if($product->product_has_parameters): ?>
            <h4><?php echo __('Technical info', 'nowotheme'); ?></h4>

            <div class="full-width scrollablex">
                <table class="table table-bordered table-parameters">
                    <?php foreach (SIM_Product::$parameters as $group => $arrfields): ?>
                        <tr>
                            <?php foreach ($arrfields['fields'] as $id_field => $name): ?>
                                <?php if($product->$id_field): ?>
                                    <th><?php echo $name; ?>:</th>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <?php foreach ($arrfields['fields'] as $id_field => $name): ?>

                                <?php if($product->$id_field): ?>
                                    <td><?php echo $product->$id_field; ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>

    </div>

    <div class="clearfix"></div>

</section>

<?php $assoc_products = $product->get_product_assoc_products() ? $product->get_product_assoc_products() :
    array_map(function($single_post){return $single_post->ID; }, apply_filters('get_random_posts', SIM_Product::$post_type)) ?>
<?php if($assoc_products): ?>
    <section class="inline">
        <h2 class="header section-title">
            <!--            <img class="category-icon" src="--><?php //echo get_template_directory_uri() . '/img/icons/' ?><!--" alt="">-->
            <?php echo __('Associated products', 'nowotheme'); ?></h2>

        <div class="associated-products product-block-list grid row products-slider owl-carousel">
            <?php foreach($assoc_products as $id_product): ?>
                <?php $product = SIM_Product::getById($id_product); ?>
                <div class="item">
                    <div class="product-block square-block">

                        <?php $main_term = apply_filters('get_post_main_term', $product->id, 'sim_product_category'); ?>
                        <div class="category-title" style="background-color: <?php echo apply_filters('taxonomy_custom_field', 'sim_product_category', $main_term->term_id, 'object_color'); ?>"><?php echo $main_term->name; ?></div>

                        <div class="bottom-block">
                            <h4 class="title element left-element">
                                <a href="<?php echo get_permalink($product->id); ?>">
                                    <?php echo $product->post->post_title; ?>
                                </a>
                            </h4>

                            <div class="price element right-element">
                                <?php if($product->product_price): ?>
                                    <div class="block no-border">
                                        <?php echo SIM_Helper::format_price($product->product_price); ?><span></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="square-block" style="background-image: url(<?php echo get_template_directory_uri() . '/img/cat_bg_image_square.jpg' ?>)">
                            <a href="<?php echo get_permalink($product->id); ?>"></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="clearfix"></div>
    </section>
<?php endif; ?>




<?php get_footer(); ?>
