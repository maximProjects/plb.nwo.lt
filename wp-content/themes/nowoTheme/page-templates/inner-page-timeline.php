<?php
/**
 * Template Name: Timeline
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



<section class="overflow-block-container page-content text-content inline">

    <div class="content">
        <h1 class="heading"><?php echo get_the_title(); ?></h1>
        <?php echo apply_filters('the_content', get_the_content()); ?>

        <div class="timeline">
            <ul>
                <?php foreach (SIM_Timeline::get_list() as $timeline): ?>
                    <li data-date="<?php echo $timeline->post->post_title; ?>"><?php echo $timeline->post->post_content; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</section>


<?php
get_footer();
?>
