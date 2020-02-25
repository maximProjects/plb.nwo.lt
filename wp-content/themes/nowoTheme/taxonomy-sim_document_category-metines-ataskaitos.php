<?php
get_header(); ?>
<div class="container documents documents-constitution year-reports">
    <?php
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    ?>
    <div class="row">
        <div class="col col-lg-12">
            <h1 class="title">
                <?php echo single_term_title(); ?>
                <span class="line"></span>
            </h1>
        </div>
    </div>

    <div class="row row-eq-height">
        <?php
        $posts = get_posts(array(
            'posts_per_page'	=> -1,
            'post_type'			=> 'sim_document',
            'tax_query' => array(
                array(
                    'taxonomy' => 'sim_document_category',
                    'field' => 'slug',
                    'terms' => $term->slug
                )
            )

        ));
        ?>
        <?php if( $posts ): ?>
            <?php foreach( $posts as $post ):?>
                <div class="col-6 col-md-3 col-lg-3  text-center block">
                    <div class="title"><?php the_title(); ?></div>
                    <?php
                    $f = get_field('file');
                    if($f) {

                        ?>

                        <a class="download button" href="<?= $f ?>" target="_blank"> <?= file_get_contents(get_template_directory_uri()."/img/".getExtension($f).".svg") ?><?= __("Document", nowotheme_DOMAIN) ?></a>
                        <?php
                    }
                    ?>

                </div>
            <?php endforeach;?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>


</div>
<?php
get_footer();
?>
