<?php
/**
 * Template Name: EVENT
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
    <div class="container events">
        <div class="row">
            <div class="col col-lg-12 calendar-content">
                <div class="calculator-box">
                    <div class="cal1"></div>
                </div>
                <div class="events-lists">
                    <h2><?= __('Nearest events', nowotheme_DOMAIN) ?></h2>
                    <div class="events-box">
                        <div class="main-news-box">
                        <?php
                        $posts = get_posts(array(
                            'posts_per_page'	=> -1,
                            'post_type'			=> 'post',
                            'meta_query'	=> array(
                                array(
                                    'key'	 	=> 'event',
                                    'value'	  	=> '"1"',
                                    'compare' 	=> 'LIKE',
                                )
                            ),
                        ));
                        ?>

                        <?php foreach( $posts as $post ):

                            //setup_postdata( $post );

                                ?>
                                <div class="news-vertical-box bg-white d-flex" data-id="<?= $post->ID ?>" data-date="<?= get_field('start_date') ?>">
                                    <?php
                                    $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'event-thmb');


                                    $cats = get_the_category();
                                    $cat = $cats[0];

                                //    $catThmb = get_field('thumb', $cat);
                                 //   $catThmbUrl = wp_get_attachment_url($catThmb);



                                    ?>
                                    <div class="thmb">
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?= $thmbUrl ?>" />
                                        </a>
                                    </div>
                                    <div class="content flex-grow-1 text-left ">
                                        <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                                        <div class="date">
                                <span class="icon calendar">
                                    <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                                </span>
                                            <span class="txt">
                                    <?= get_field('start_date') ?> - <?= get_field('end_date') ?>
                                </span>
                                        </div>

                                        <?php
                                        $location = get_field('event_location');
                                        if($location) {
                                            ?>
                                            <div class="date">
                                                <span class="icon calendar">
                                                     <?= file_get_contents(get_template_directory_uri()."/img/address.svg") ?>
                                                </span>
                                                                <span class="txt">
                                                    <?= $location ?>
                                                </span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="cls"></div>
                                </div>

                        <?php endforeach; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="single-event">

        </div>

    </div>
<?php get_footer(); ?>