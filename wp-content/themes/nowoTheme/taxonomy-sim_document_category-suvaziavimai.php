<?php
get_header(); ?>
<div class="container documents documents-constitution suvaziavimai">
    <?php
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    ?>
    <div class="row">
        <div class="col-12 col-lg-12">
            <h1 class="title">
                <?php echo single_term_title(); ?>
                <span class="line"></span>
            </h1>
        </div>
        <div class="col-12 col-lg-12">
            <div class="descr">
                <?= wpautop( $term->description, true ) ?>
            </div>
        </div>
    </div>
    <div class="row row-eq-height">
        <?php
        $childs = get_terms( array(
            'taxonomy'      => 'sim_document_category',
            'parent'        => $term->term_id,
            'hide_empty'    => false,
        ) );


        ?>
        <?php if( $childs ): ?>
            <?php foreach( $childs as $child ):?>
                <div class="col-md-3 text-left block">
                    <a href="<?= get_term_link($child->term_id) ?>"><?= $child->name ?></a>
                    <?= wpautop( $child->description, true ) ?>
                </div>
            <?php endforeach;?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>

</div>

<?php
get_footer();
?>
