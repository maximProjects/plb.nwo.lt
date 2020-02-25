<?php
/**
 * Template Name: Bendruomenių kontaktai
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

<div class="container documents-constitution community-contacts">
    <?php
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    ?>
    <div class="row">
        <div class="col col-lg-12">
            <h1 class="title">
                <?php echo get_the_title(); ?>
                <span class="line"></span>
            </h1>
        </div>
    </div>

    <?php
    $childs = get_posts( array(
        'post_type'      => 'page',
        'post_parent'        => $post->ID,
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

                    <a href="<?= get_permalink($child->ID) ?>"><?= $child->post_title ?></a>
                <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    <div class="row">
    <?php if( $childs ):
               foreach( $childs as $child ):

                   $blocks = get_field('blocks', $child->ID);
                   if($blocks) {
                       foreach ($blocks as $block) {
                           ?>
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="info-box bg-white text-center">
                                    <h2><?= $block['title'] ?></h2>
                                    <div class="contact-person">
                                        <?= $block['contact_person'] ?>
                                    </div>
                                    <div class="web">
                                        <?php
                                        if($block['website']){
                                            ?>
                                            <a href="<?= $block['website'] ?>" target="_blank"><?= file_get_contents(get_template_directory_uri()."/img/website.svg") ?><?= $block['website'] ?></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="email">
                                        <?php
                                        if($block['email']){
                                            ?>
                                            <a href="mailto:<?= $block['email'] ?>"><?= file_get_contents(get_template_directory_uri()."/img/envelope.svg") ?></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                       }
                   }

              endforeach;

     endif; ?>
    </div>
</div>
<?php
get_footer();
?>
