<?php
/**
 * Template Name: Front Page Template
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
    <div class="container main-section">
<?php
$posts = get_posts(array(
    'posts_per_page'	=> 3,
    'post_type'			=> 'post',
    'meta_query'	=> array(
        array(
            'key'	 	=> 'home_page_banner',
            'value'	  	=> '"1"',
            'compare' 	=> 'LIKE',
        ),
        array(
            'key'	 	=> 'confirmed',
            'value'	  	=> '"1"',
            'compare' 	=> 'LIKE',
        )
    ),
));
?>



<?php if( $posts ): ?>
    <div class="row row-eq-height m-bottom">
    <?php foreach( $posts as $post ):

        //setup_postdata( $post );
        $show = get_field('home_page_banner');
        if($show) {
            ?>
            <div class="col-12  col-lg-4 col-md-6 col-sm-12 text-center home_banner  bg-white">
                <?php
                $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'home_banner');


                $cats = get_the_category();
                $cat = $cats[0];

                $catThmb = get_field('thumb', $cat);
                $catThmbUrl = wp_get_attachment_url($catThmb);



                ?>
                <img src="<?= $thmbUrl ?>" />
                <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                <div class="date">
                        <span class="icon">
                            <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                        </span>
                    <span class="txt">
                            <?= get_the_date('Y-m-d') ?>
                        </span>

                </div>

                   <div class="banner-bottom">

                       <div class="category">
                        <span class="icon">
                            <?= file_get_contents($catThmbUrl) ?>
                        </span>
                           <span class="txt">
                            <a href="<?= get_term_link($cat->term_id) ?>">
                                <?= $cat->cat_name ?> (<?= $cat->category_count ?>)
                            </a>
                        </span>
                           <?= get_field('line_color', 'category_'.$category->cat_id); ?>
                           <div class="line" style="background-color: <?= get_field('line_color', 'category_'.$cat->term_id); ?>;"></div>
                       </div>
                       <div class="views">
                        <span class="icon">
                            <?= file_get_contents(get_template_directory_uri()."/img/eye.svg") ?>
                        </span>
                           <span class="txt">
                            55
                        </span>
                       </div>
                       <div class="cls"></div>
                   </div>
                <div class="banner-button">
                    <a href="<?= get_permalink() ?>" class="read-more"><?= __('Read more', nowotheme_DOMAIN) ?></a>
                </div>

            </div>
            <?php
        }
            ?>
    <?php endforeach; ?>

    <?php wp_reset_postdata(); ?>
    </div>
<?php endif; ?>

    </div>
    <div class="container-fluid bg-white home-subscribe">
        <div class="row">
            <div class="col col-12 text-center">
                <?= do_shortcode("[sibwp_form id=2]") ?>
                <?php
                /*
                ?>
                <form class="subscribe">
                    <span class="txt"><?= __("Don't miss subscribtion", nowotheme_DOMAIN) ?></span>   <span class="txt-line">&#8212;</span>   <input type="text" placeholder="<?= __("email", nowotheme_DOMAIN) ?>" />
                    <span class="submit-box">
                        <input type="submit" value="<?= __("Subscribe", nowotheme_DOMAIN) ?>" class="button-danger" />
                    </span>
                </form>
                */
                ?>
            </div>
        </div>

    </div>

<?php get_template_part('news-block'); ?>


    <div class="container m-bottom text-center">
        <div id="partners">
            <?php
            $arg = [
                'post_type' => 'sim_partner',
            ];
            $posts = get_posts($arg);
            ?>
            <div class="sponsors">
                <h4><?= __('Sponsors', nowotheme_DOMAIN) ?></h4>
                <?php
                    foreach (SIM_Partner::get_list() as $post) {
                        $thmbUrl = get_the_post_thumbnail_url($post->id, 'full');
                        $type = get_field('type', $post->id);
                        if($type == 1) {
                            ?>
                            <a target="_blank" href="<?= $post->partner_url ?>">
                                <img src="<?= $thmbUrl ?>" />
                            </a>
                            <?php
                        }
                    }
                ?>
            </div>
            <div class="partners">
                <h4><?= __('Partners', nowotheme_DOMAIN) ?></h4>
                <?php
                foreach (SIM_Partner::get_list() as $post) {
                    $thmbUrl = get_the_post_thumbnail_url($post->id, 'full');
                    $type = get_field('type', $post->id);
                    if($type == 2) {
                        ?>
                        <a target="_blank" href="<?= $post->partner_url ?>">
                            <img src="<?= $thmbUrl ?>" />
                        </a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>