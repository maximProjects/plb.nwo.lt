<?php
get_header(); ?>
<div class="container documents documents-constitution chatrija">
    <div class="bg">
        <?= file_get_contents(get_template_directory_uri()."/img/chatrija.svg") ?>
    </div>
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
        <div class="col col-lg-12">
            <div class="descr">
                <?= wpautop( $term->description, true ) ?>
            </div>
        </div>
    </div>
    <div class="row row-eq-height" id="history-slider">
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
                <div class="col-md-12 text-left">
                    <div class="title"><?php the_title(); ?></div>
                    <div class="content"><?= wpautop( $post->post_content, true ) ?></div>
                </div>
            <?php endforeach;?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <div class="cls">&nbsp;</div>
    <?php
    $f = get_field('document', 'sim_document_category_'.$term->term_id);
    if($f) {

        ?>

        <a class="download button" href="<?= $f ?>" target="_blank"> <?= file_get_contents(get_template_directory_uri()."/img/".getExtension($f).".svg") ?><?= __("Chatrija", nowotheme_DOMAIN) ?></a>
        <?php
    }
    ?>


    <?php
    $stext = get_field('short_text', 'sim_document_category_'.$term->term_id);
    if($stext) {

        ?>
        <span class="short-text"><?= wpautop( $stext, true ) ?></span>
        <?php
    }
    ?>
</div>

<?php
get_footer();
?>
