<?php
/*
 * Template Name: Projects
 * Template Post Type: post, page, product
 */

get_header();  ?>



<div class="container project section">
    <div class="row row-eq-height">
        <div class="col-12 d-block d-md-none d-lg-none align-self-center text-right">
            <a class="link-back" href="#"><?= file_get_contents(get_template_directory_uri()."/img/back.svg") ?> <?php echo __('Back', 'nowotheme'); ?></a>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <h1 class="title">
                <?php echo get_the_title(); ?>
                <span class="line"></span>
            </h1>
        </div>
    </div>
    <div class="project-content bg-white">
    <div class="row pre-post">

        <div class="col-12 col-lg-6">

                <?php
                $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'project_thmb');
                ?>
                <img src="<?= $thmbUrl ?>" />

        </div>
        <div class="col-12 col-lg-6">
            <div class="post-excerpt">
                <?= $post->post_excerpt ?>
            </div>
                    <?php
                    $first_text = get_field('first_text');
                    if($first_text) {
                        ?>
                        <div class="first-text">
                            <?= $first_text ?>
                        </div>
                        <?php
                    }
                    ?>

        </div>
    </div>
        <div class="row">






        <div class="col col-lg-12 align-self-center">

        </div>


        <div class="col-12 col-lg-12">

            <div class="article-content">

                <?php echo apply_filters('the_content', get_the_content()); ?>



            </div>
            <?php
            get_template_part('socials');
            ?>
        </div>

        </div>

    </div>

</div>





<?php get_footer(); ?>
