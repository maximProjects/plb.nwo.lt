<?php
get_header(); ?>

    <?php
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    $parent = get_term($term->parent, 'sim_document_category');
    $back_link = get_term_link( $parent, 'sim_document_category');

    if($term->parent == 26) {
      //  echo "archyvas";
        get_template_part('archyve-single');

    } elseif($term->parent == 47) {
       // echo "naujienlaiskis";
        get_template_part('newsletter-single');
    } else {

    $title = $term->name;
    $single_title = get_field('single_title', 'sim_document_category_'.$term->term_id);
    if($single_title) {
        $title = $single_title;
    }
    if($term->parent) {
        $parent = get_term($term->parent, 'sim_document_category');
        if($parent->parent) {
            $title = $parent->name;
            $single_title = get_field('single_title', 'sim_document_category_'.$parent->term_id);
            if($single_title) {
                $title = $single_title.$parent->term_id;
            }
        }
    }
    ?>
<div class="container documents documents-constitution archyve archyve-single">
    <div class="row  row-eq-height">
        <div class="col-10 col-md-11 col-lg-11">
            <h1 class="title">
                <?php echo $title; ?>
                <div class="line"></div>
            </h1>
        </div>

        <div class="col-2 col-md-1 col-lg-1 align-self-center text-right">
            <a class="link-back" href="<?= $back_link?>"><?= file_get_contents(get_template_directory_uri()."/img/back.svg") ?> <?php echo __('Back', 'nowotheme'); ?></a>
        </div>

    </div>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="descr">
                <?= $term->description ?>
            </div>
        </div>
    </div>

    <?php
    $childs = get_terms( array(
        'taxonomy'      => 'sim_document_category',
        'parent'        => $term->term_id,
        'hide_empty'    => false,
    ) );


    ?>
    <div class="row cats-menu">
        <?php if( $childs ): ?>

            <div class="col col-12">
                <?php foreach( $childs as $child ):?>
                    <a href="<?= get_term_link($child->term_id) ?>"><?= $child->name ?></a>
                <?php endforeach;?>
            </div>

        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
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
    <?php
    }
    ?>

</div>
<?php
get_footer();
?>
