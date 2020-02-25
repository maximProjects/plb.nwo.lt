<?php
/**
 * Template Name: Parduotuvės
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */


get_header(); ?>



<section class="page-content form-page inline">

    <div class="col-md-5 no-padding-left side-menu">
        <?php get_template_part('sidebar'); ?>
    </div>

    <div class="col-md-19 center-content">

        <div class="content">

            <div class="map-contacts">
                <div id="map_container" class="widget shop-maps-container">
                    <?php echo get_template_part('google-maps'); ?>
                </div>
            </div>
        </div>


    </div>

</section>

<hr class="blank">

<section class="form-page inline">

    <?php $cities = SIM_City::get_list(); ?>

    <h2 class="heading"><?php echo __('Shops', 'nowotheme'); ?></h2>

    <div class="page-content">
        <div class="col-md-12 content form-container">

            <div class="row">

                <?php foreach($cities as $city): ?>

                    <?php $shops = $city->get_shops(); ?>

                    <?php if($shops): ?>

                        <?php foreach($shops as $shop): ?>

                            <div class="col-md-6">
                                <div class="form-block">
                                    <h4 class="heading"><?php echo $shop->_city_shop_title; ?></h4>
                                    <?php echo $shop->_city_shop_address ? apply_filters('the_content', $shop->_city_shop_address) : ''; ?>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>


<?php
get_footer();
?>
