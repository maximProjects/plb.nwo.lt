<?php
/**
 * Template Name: Management
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>



<div class="container management-header">
    <div class="row">
        <div class="col col-lg-12 text-center bg-white content-box">
            <?php
            $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'management_image');
            ?>
            <img src="<?= $thmbUrl ?>" />
            <h1><?= the_title() ?></h1>
            <div class="content text-left">
                <?php echo apply_filters('the_content', get_the_content()); ?>
            </div>

        </div>
    </div>
</div>

<div class="container management-list">
    <div class="row">
        <div class="col col-lg-12">
            <h2 class="title"><?= __("The board", nowotheme_DOMAIN) ?></h2>
        </div>
    </div>
        <?php
        $posts = get_posts(array(
            'posts_per_page'	=> -1,
            'post_type'			=> 'sim_employee',
        ));

        ?>

        <?php if( $posts ): ?>
          <div class="row row-eq-height">
            <?php foreach( $posts as $post ): ?>
                <?php
                $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'management_list');
                ?>
                <div class="col col-lg-4 text-center">
                    <div class="manager-box">
                        <img src="<?= $thmbUrl ?>" />
                        <div class="bottom">
                            <div class="title">
                                <?= get_post_meta(get_the_ID(),'_sim_employee_name', true); ?> <?= get_post_meta(get_the_ID(),'_sim_employee_surname', true); ?>
                            </div>
                            <div class="specialization">
                                <?= get_post_meta(get_the_ID(),'_sim_employee_specialization', true); ?>
                            </div>
                            <div class="email-link">
                                <a href="mailto:<?= get_post_meta(get_the_ID(),'_sim_employee_email', true); ?>"><?= file_get_contents(get_template_directory_uri()."/img/envelope.svg") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
          </div>
    <?php wp_reset_postdata(); ?>

<?php endif; ?>




    </div>
</div>



<?php get_footer(); ?>
