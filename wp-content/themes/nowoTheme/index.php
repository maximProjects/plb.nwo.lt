<?php get_header(); ?>

	<main role="main" class="row">
        <div class="col-md-12">
            <!-- section -->
            <section>

                <h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

                <?php get_template_part('loop'); ?>

                <?php get_template_part('pagination'); ?>

            </section>
            <!-- /section -->
        </div>
	</main>


<?php get_footer(); ?>
