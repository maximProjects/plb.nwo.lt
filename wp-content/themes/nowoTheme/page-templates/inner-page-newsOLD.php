<?php
/**
 * Template Name: NaujienosXXX
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


?>

<?php get_header(); ?>

<div class="container news">

    <?php
    $posts = get_posts(array(
        'posts_per_page'	=> 4,
        'post_type'			=> 'post',
        'meta_query'	=> array(
            array(
                'key'	 	=> 'home_page_banner',
                'value'	  	=> '"1"',
                'compare' 	=> 'LIKE',
            )
        ),
    ));
    ?>



    <?php if( $posts ): ?>
        <div class="row row-eq-height m-bottom">
            <div class="col col-sm-12 col-lg-6 text-center no-padding">
                <div class="main-news-box">
                <?php
                $post = $posts[0];
                unset($posts[0]);
                ?>
                <?php
                $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'news_main_post');


                $cats = get_the_category();
                $cat = $cats[0];

                $catThmb = get_field('thumb', $cat);
                $catThmbUrl = wp_get_attachment_url($catThmb);



                ?>
                <a href="<?= get_permalink() ?>"><img src="<?= $thmbUrl ?>" /></a>
                <div class="content main-new">
                    <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                    <div class="date">
                            <span class="icon calendar">
                                <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                            </span>
                        <span class="txt">
                                <?= get_the_date('Y-m-d') ?>
                            </span>

                    </div>
                    <div class="d-none d-lg-block">
                        <?php echo  wp_trim_words(get_the_excerpt(), 37); ?>
                    </div>
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
                            <div class="line"></div>
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
            </div>

            </div>

            <div class="col col-sm-12 col-lg-6 text-center news-vertical-col">
            <?php foreach( $posts as $post ):

                //setup_postdata( $post );
                $show = get_field('home_page_banner');
                if($show) {
                    ?>
                    <div class="news-vertical-box bg-white d-flex">
                        <?php
                        $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'news_list');


                        $cats = get_the_category();
                        $cat = $cats[0];

                        $catThmb = get_field('thumb', $cat);
                        $catThmbUrl = wp_get_attachment_url($catThmb);



                        ?>
                        <div class="thmb">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?= $thmbUrl ?>" />
                            </a>
                        </div>
                        <div class="content text-left ">
                            <a href="<?php the_permalink(); ?>" class="title n-list"><?php the_title(); ?></a>
                            <div class="date">
                                <span class="icon calendar">
                                    <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                                </span>
                                        <span class="txt">
                                    <?= get_the_date('Y-m-d') ?>
                                </span>
                            </div>
                            <div class="banner-bottom d-flex flex-row">
                                <div class="cat w-50">
                                    <span class="icon">
                                        <?= file_get_contents($catThmbUrl) ?>
                                    </span>
                                    <span class="txt">
                                        <a href="<?= get_term_link($cat->term_id) ?>">
                                            <?= $cat->cat_name ?> (<?= $cat->category_count ?>)
                                        </a>
                                    </span>
                                    <div class="line"></div>
                                </div>
                                <div class="views w-50 text-right">
                                    <span class="icon">
                                        <?= file_get_contents(get_template_directory_uri()."/img/eye.svg") ?>
                                    </span>
                                    <span class="txt">
                                        55
                                    </span>
                                </div>
                                <div class="cls"></div>
                            </div>
                        </div>
                        <div class="cls"></div>
                    </div>
                    <?php
                }
                ?>
            <?php endforeach; ?>
            </div>
            <?php wp_reset_postdata(); ?>

    <?php endif; ?>

</div>
<div class="container">
    <?php get_template_part('news-block'); ?>
</div>

<?php get_footer(); ?>
