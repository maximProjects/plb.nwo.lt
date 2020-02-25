<div class="container documents documents-constitution newsletters">
    <?php
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

    $parent = get_term( $term->parent, 'sim_document_category');

    ?>
    <div class="row">
        <div class="col col-lg-12">
            <h1 class="title">
                <?php echo $parent->name; ?>
                <span class="line"></span>
            </h1>
        </div>
    </div>

    <?php
    $childs = get_terms( array(
        'taxonomy'      => 'sim_document_category',
        'parent'        => $parent->term_id,
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
                                <a href="<?= get_term_link($child->term_id) ?>" class="<?php if($child->term_id == $term->term_id) {echo "active";} ?>"><?= $child->name ?></a>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>


    <div class="row row-eq-height docs">
        <?php
        $posts = get_posts(array(
            'posts_per_page'	=> -1,
            'post_type'			=> 'sim_document',
            'tax_query' => array(
                array(
                    'taxonomy' => 'sim_document_category',
                    'field' => 'term_id',
                    'terms' => $term->term_id
                )
            )

        ));
        ?>
        <?php if( $posts ): ?>
            <?php foreach( $posts as $post ):?>
                <div class="col-6 col-md-2 text-center block">
                    <?php
                    $f = get_field('file');
                    if($f) {

                        ?>

                        <a class="download button" href="<?= $f ?>" target="_blank"> <?= file_get_contents(get_template_directory_uri()."/img/".getExtension($f).".svg") ?><?php the_title(); ?></a>
                        <?php
                    }
                    ?>

                </div>
            <?php endforeach;?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>


</div>