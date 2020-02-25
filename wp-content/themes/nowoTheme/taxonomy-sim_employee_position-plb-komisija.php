<?php
get_header(); ?>
<div class="container employeers">
    <?php
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    ?>

    <?php
    $childs = get_terms( array(
        'taxonomy'      => 'sim_employee_position',
        'parent'        => $term->term_id,
        'hide_empty'    => false,
    ) );

    ?>
    <?php if( $childs ): ?>

        <?php foreach( $childs as $child ):?>
            <?php
            $posts = get_posts(array(
                'posts_per_page'	=> 1,
                'post_type'			=> 'sim_employee',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'sim_employee_position',
                        'field' => 'slug',
                        'terms' => $child->slug
                    )
                )

            ));
            if($posts) {
                $employeer = $posts[0];
                $thmbUrl = get_the_post_thumbnail_url($employeer->ID, 'avatar');
                $form_mail = get_field('email', $employeer->ID);

                ?>
                <div id="<?= $child->term_id ?>" class="row block">
                    <div class="col col-lg-12 d-flex">
                        <div class="employee-thmb">
                            <img src="<?= $thmbUrl ?>"/>
                        </div>
                        <div class="employee-info flex-grow-1">
                            <h2>
                                <?= $child->name ?>
                            </h2>
                            <div class="title">
                                <?= get_post_meta(get_the_ID(),'_sim_employee_name', true); ?> <?= get_post_meta(get_the_ID(),'_sim_employee_surname', true); ?> - <?= get_post_meta(get_the_ID(),'_sim_employee_specialization', true); ?>
                            </div>
                            <div class="email-link">
                                <a href="mailto:<?= get_post_meta(get_the_ID(),'_sim_employee_email', true); ?>"><?= file_get_contents(get_template_directory_uri()."/img/envelope.svg") ?></a>
                            </div>
                            <div class="email-form">
                                <a href="#" class="close  d-block d-lg-none d-md-none"><?= file_get_contents(get_template_directory_uri()."/img/close.svg") ?></a>
                                <?php
                                get_template_part('cf-messages');
                                ?>
                                <?= do_shortcode('[contact-form-7 id="344" title="Employeer" destination-email="'.$form_mail.'" ]') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
 ?>
        <?php endforeach;?>

    <?php endif; ?>
    <?php wp_reset_postdata(); ?>


    <div class="row row-eq-height">
        <?php

        ?>
        <?php if( $posts ): ?>
            <?php foreach( $posts as $post ):?>
                <div class="col-md-2 text-left block">
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
