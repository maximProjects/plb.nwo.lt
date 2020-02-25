<?php
/**
 * Template Name: Partneriai
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


<section>

    <div class="container">

        <h2 class="title section-header">
            <span><?php echo get_the_title(); ?></span>
        </h2>

        <div class="content-container page-content">
            <div class="row">
                <div class="col-md-12 content">
                    <?php echo apply_filters('the_content', $post->post_content); ?>
                </div>
            </div>
        </div>


        <div class="content-container partners-container">
            <div class="row">
                <?php foreach(SIM_Partner::get_list() as $partner): ?>
                    <div class="col-tn-12 col-xs-6 col-sm-4 col-md-3">
                        <div class="partner">
                            <a href="<?php echo $partner->partner_url; ?>" class="cell-view" target="_blank">
                                <img src="<?php echo apply_filters('post_image_url', $partner->id) ?>" alt="">
                                <span><h4 class="title"><?php echo $partner->post->post_title; ?></h4></span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>


</section>


<?php
get_footer();
?>
