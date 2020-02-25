<?php
/**
 * Template Name: Žemėlapis
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

<section class="breadcrumb-block">
    <h1 class="heading breadcrumb"><?php echo get_the_title(); ?></h1>
    <?php echo dimox_breadcrumbs(); ?>
    <div class="clearfix"></div>
</section>

<section>
    <div class="section-header inverse">
        <h2 class="section-title text-uppercase">
            <a href="<?php echo get_permalink(apply_filters('post_by_current_language', 224)); ?>">
                <?php echo __('Partners', 'nowotheme'); ?>
            </a>
        </h2>
    </div>
    <div class="partners partners-static col-xs-24">
        <div class="row logos-container limit">
            <?php $i = 0; ?>
            <?php foreach(SIM_Partner::get_list() as $partner): ?>
                <?php $image_url = apply_filters('post_image_url', $partner->id, 'large'); ?>
                <?php if($image_url): ?>
                    <div class="slide col-xs-12 col-sm-8 col-md-6 col-lg-15 <?php echo $i > 4 ? 'hidden' : '' ?>">
                        <a href="<?php echo $partner->partner_url ? $partner->partner_url : '' ?>" <?php echo $partner->partner_url ? 'target="_blank"' : '' ?>>
                            <img <?php echo ($i > 4) ? 'data-original' : 'src' ?>="<?php echo apply_filters('post_image_url', $partner->id, 'large'); ?>" alt="" class="grayscale <?php echo $i++ <= 4 ? 'lazy' : 'lazy-trigger' ?>">

                            <noscript>
                                <img src="<?php echo apply_filters('post_image_url', $partner->id, 'large'); ?>" alt="" class="grayscale lazy-trigger">
                            </noscript>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="section-header inverse">
        <a class="btn btn-default pull-right more trigger-lazy" href="#"><?php echo __('More partners', 'nowotheme'); ?></a>
        <a class="btn btn-default pull-right more disable-lazy hidden" href="#"><?php echo __('Hide', 'nowotheme'); ?></a>
    </div>
</section>

<section class="page-content shops-map-content">

    <section class="content">
        <h2 class="heading"><?php echo get_the_title(); ?></h2>


        <?php echo get_template_part('info-widgets'); ?>

    </section>

</section>


<?php
get_footer();
?>
