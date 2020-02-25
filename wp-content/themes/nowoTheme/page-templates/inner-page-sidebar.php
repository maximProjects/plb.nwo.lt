<?php
/**
 * Template Name: Inner page sidebar
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



<section class="overflow-block-container page-content inline">

    <h1 class="heading"><?php echo get_the_title(); ?></h1>

    <div class="col-md-3">
        <?php echo get_sidebar(); ?>
    </div>
    <div class="col-md-9">
        <div class="content">
            <?php echo apply_filters('the_content', get_the_content()); ?>

        </div>
    </div>

    <div class="clearfix"></div>

</section>


<?php
get_footer();
?>
