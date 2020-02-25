<?php
get_header(); ?>
<div class="container documents documents-constitution archyve">
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

    <?php
    $childs = get_terms( array(
        'taxonomy'      => 'sim_document_category',
        'parent'        => $term->term_id,
        'hide_empty'    => false,
    ) );


    ?>
    <?php if( $childs ): ?>
    <div class="row cats-menu">
        <div class="col col-12">
            <div class="cats-box">
                <div class="cats-scroll">
                    <div class="cats-line">
        <?php foreach( $childs as $child ):?>
                <a href="<?= get_term_link($child->term_id) ?>"><?= $child->name ?></a>
        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>


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
                <div class="col-6 col-md-2 col-lg-2 text-left block">
                    <div class="block-box">
                        <?php
                        $f = get_field('file');
                        $url = get_field('url');
                        if($url)  {
                            ?>
                            <a class="download button" href="<?= $url ?>" target="_blank"> <?= file_get_contents(get_template_directory_uri()."/img/url.svg") ?><?= __('link') ?></a>
                            <?php
                        } else {
                            ?>
                            <a class="download button" href="<?= $f ?>" target="_blank"> <?= file_get_contents(get_template_directory_uri()."/img/".getExtension($f).".svg") ?><?= __('document') ?></a>
                            <?php
                        }
                        ?>
                        <div class="content">
                            <?= wpautop( $post->post_content, true ) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>


</div>
<?php
get_footer();
?>
