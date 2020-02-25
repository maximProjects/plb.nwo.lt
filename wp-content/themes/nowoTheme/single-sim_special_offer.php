<?php get_header();

?>


<section>

    <div class="container">

        <h2 class="title section-header">
            <span><?php echo get_the_title(); ?></span>
        </h2>

        <div class="content-container page-content">
            <div class="row">
                <div class="col-md-12 content">
<!--                    <time>--><?php //echo date('Y-m-d', strtotime($post->post_date)); ?><!--</time>-->
                    <?php echo apply_filters('the_content', get_the_content()); ?>

                    <a class="link-back" href="<?php echo get_permalink(get_page_by_template('inner-page-special-price')); ?>"><?php echo __('Back to all special offers', 'nowotheme'); ?></a>
                </div>
            </div>
        </div>

    </div>


</section>


<?php get_footer(); ?>
