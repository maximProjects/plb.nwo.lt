<?php get_header(); ?>


    <section class="breadcrumb-block">
        <h1 class="heading breadcrumb"><?php echo post_type_archive_title(); ?></h1>
        <?php echo dimox_breadcrumbs(); ?>
        <div class="clearfix"></div>
    </section>

    <section class="page-content inline">

        <div class="galleries grid content">

            <?php foreach (apply_filters('post_type_list', SIM_Gallery::$post_type) as $post): ?>
                <div class="col-sm-12 no-padding dark stripped x4">
                    <div class="gallery flexview centered bordered">
                        <div class="col-xs-12 no-padding">
                            <img src="<?php echo apply_filters('post_image_url', $post->ID, 'article_list_medium'); ?>"
                                 class="img-responsive left-block" alt="<?php echo $post->post_title; ?>"
                                 width="290" height="200">
                        </div>

                        <div class="hover-layer hover-bg-block">
                        </div>

                        <div class="col-xs-12 title text-center">
                            <h4 class="heading center-block"><?php echo $post->post_title; ?></h4>
                            <p class="viewmore btn btn-exclusive"><?php echo __('view more', 'scandagra'); ?> <i class="fa fa-angle-right"></i></p>
                        </div>

                        <a class="bg-link fw fh" href="<?php echo get_permalink($post->ID); ?>"></a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="clearfix"></div>

        </div>

    </section>


<?php echo get_template_part('partners'); ?>

<?php echo get_template_part('info-widgets'); ?>




<?php get_footer(); ?>