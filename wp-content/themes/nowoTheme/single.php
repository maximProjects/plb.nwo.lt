<?php get_header(); ?>

<?php
$cats = get_the_category();
$cat = $cats[0];

$catThmb = get_field('thumb', $cat);
$catThmbUrl = wp_get_attachment_url($catThmb);

?>


    <div class="container article section">
        <div class="row row-eq-height">
            <div class="col col-lg-6 align-self-center">
                <div class="category">
                        <span class="icon">
                            <?= file_get_contents($catThmbUrl) ?>
                        </span>
                    <span class="txt">
                            <a href="<?= get_term_link($cat->term_id) ?>">
                                <?= $cat->cat_name ?> (<?= $cat->category_count ?>)
                            </a>
                        </span>
                    <div class="line" style="background-color: <?= get_field('line_color', 'category_'.$cat->term_id); ?>;"></div>
                </div>
            </div>
            <div class="col col-lg-6 align-self-center text-right">
                <a class="link-back" href="<?= $_SERVER['HTTP_REFERER']?>"><?= file_get_contents(get_template_directory_uri()."/img/back.svg") ?> <?php echo __('Back', 'nowotheme'); ?></a>
            </div>
            <div class="col-12 col-lg-12">
                <h1 class="title">
                    <?php echo get_the_title(); ?>
                </h1>
            </div>
            <div class="col col-lg-12">
                <div class="icons">
                            <span class="date icon-info-box">
                                        <span class="icon calendar">
                                            <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                                        </span>
                                                <span class="txt">
                                            <?= get_the_date('Y-m-d') ?>
                                        </span>
                                            </span>

                    <span class="views icon-info-box">
                                        <span class="icon eye">
                                            <?= file_get_contents(get_template_directory_uri()."/img/eye.svg") ?>
                                        </span>
                                                <span class="txt">
                                            55
                                        </span>
                            </span>

                    <span class="views icon-info-box">
                                        <span class="icon eye">
                                            <?= file_get_contents(get_template_directory_uri()."/img/country.svg") ?>
                                        </span>
                                                <span class="txt">
                                            <?= get_country(get_the_ID()) ?>
                                        </span>
                            </span>
                </div>
            </div>
            <div class="col-12 col-lg-12 align-self-center">
            <?php
            $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'single_post');
            ?>
            <img src="<?= $thmbUrl ?>" />
            </div>
            <div class="col-12 col-lg-6 align-self-center">
                <?php
                $lm = get_the_author_meta('last_name');
                ?>
                <span class="post-author"><?= get_the_author_meta('first_name') ?> <?= strtoupper(get_the_author_meta('last_name')) ?></span>
            </div>
            <div class="col-12 col-lg-6">
                <?php
                get_template_part('socials');
                ?>
            </div>


            <div class="col-12 col-lg-12">

                <div class="article-content">
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
                            <?php echo apply_filters('the_content', get_the_content()); ?>



                </div>
                <?php
                get_template_part('socials');
                ?>
            </div>
        </div>
        <div class="row row-eq-height related-posts no-gutters">
            <div class="col-12 col-lg-12">
                <h2><?= __('Related posts', nowotheme_DOMAIN)?></h2>
            </div>


                <?php
                $arg = [
                    'numberposts'      => 3,
                    'exclude' => get_the_ID(),
                    'orderby'          => 'date',
                    'order'            => 'DESC',
                    'post_type'        => 'post',
                    'category__not_in' => array(1),
                ];
                $posts = get_posts($arg);
                ?>

                <?php
                if( $posts ) {
                    foreach( $posts as $post ) {
                        $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'related_post');
                        ?>
                        <div class="col-12 col-lg-4">
                            <div class="post-box">
                                <div class="news-image">
                                    <a href="<?= get_permalink() ?>">
                                        <img src="<?= $thmbUrl?>" />
                                    </a>
                                </div>
                                <div class="news-content">
                                    <h3><a href="<?= get_permalink() ?>"><?= $post->post_title ?></a></h3>
                                    <div class="info-bottom">
                                    <div class="date">
                                                                            <span class="icon">
                                        <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                                    </span>
                                            <span class="txt">
                                        <?= get_the_date('Y-m-d') ?>
                                    </span>
                                        </div>
                                    </span>
                                        <?php
                                        $cats = get_the_category();
                                        $cat = $cats[0];

                                        $catThmb = get_field('thumb', $cat);
                                        $catThmbUrl = wp_get_attachment_url($catThmb);

                                        ?>

                                        <span class="category">
                                            <span class="icon">
                                            <?= file_get_contents($catThmbUrl) ?>
                                            </span>
                                            <span class="txt">
                                            <a href="<?= get_term_link($cat->term_id) ?>">
                                                <?= $cat->cat_name ?> (<?= $cat->category_count ?>)
                                            </a>
                                            </span>
                                        </span>


                                    <span class="views">
                                        <span class="icon eye">
                                            <?= file_get_contents(get_template_directory_uri()."/img/eye.svg") ?>
                                        </span>
                                                <span class="txt">
                                            55
                                        </span>
                                            </span>
                                    </div>
                                </div>
                                <div class="line"></div>
                            </div>

                        </div>

                        <?php
                    }
                }
                ?>

        </div>
    </div>





<?php get_footer(); ?>
