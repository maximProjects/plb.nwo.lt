<?php
/**
 * Template Name: Istorija
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
<div class="container history">
    <div class="bg">
        <?= file_get_contents(get_template_directory_uri()."/img/history.svg") ?>
    </div>
    <div class="row">
        <div class="col col-lg-12">
            <h1 class="title">
                <?php echo get_the_title(); ?>

            </h1>
        </div>
    </div>
    <div class="row row-eq-height" id="history-slider">
        <?php
        $posts = get_posts(array(
            'posts_per_page'	=> -1,
            'post_type'			=> 'sim_timeline',
        ));
        ?>
        <?php if( $posts ): ?>
        <?php foreach( $posts as $post ):?>
            <div class="col-12 col-md-12 text-left">
                <div class="title"><?php the_title(); ?></div>
                <div class="content"><?= wpautop( $post->post_content, true ) ?></div>
            </div>
        <?php endforeach;?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <div class="cls">&nbsp;</div>
    <?php
    $f = get_field('file');
    if($f) {

        ?>

        <a class="download button" href="<?= $f ?>" target="_blank"> <?= file_get_contents(get_template_directory_uri()."/img/".getExtension($f).".svg") ?><?php echo get_the_title(); ?></a>
    <?php
    }
    ?>

</div>

<?php
get_footer();
?>
