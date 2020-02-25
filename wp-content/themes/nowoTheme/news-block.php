<div class="container m-top m-bottom">
    <h1><?= __('Themes', nowotheme_DOMAIN) ?></h1>
    <div class="row row-eq-height">
        <?php
        $categories = get_categories( array(
            'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'orderby'    => 'name',
            'parent'     => 0,
            'hide_empty' => 1, // change to 1 to hide categores not having a single post
            'exclude' => array(1),
        ) );
        if(count($categories) > 0){
            foreach($categories as $cat) {
                $catThmb = get_field('thumb', $cat);
                $catThmbUrl = wp_get_attachment_url($catThmb);
                ?>
                <div class="col-12 col-lg-6 news-category-block">
                    <h2>
                        <a href="<?= get_term_link($cat->term_id) ?>">
                            <span class="icon">
                                <?= file_get_contents($catThmbUrl) ?>
                            </span>
                            <?= $cat->cat_name ?>
                            <span class="count">
                                (<?= $cat->count ?>)
                            </span>
                            <span class="line" style="background-color: <?= get_field('line_color', 'category_'.$cat->term_id); ?>;"></span>
                        </a>
                    </h2>
                    <?php
                    $arg = [
                        'numberposts'      => 2,
                        'category'         => $cat->term_id,
                        'orderby'          => 'date',
                        'order'            => 'DESC',
                        'post_type'        => 'post',
                        'meta_query'	=> array(
                            array(
                                'key'	 	=> 'confirmed',
                                'value'	  	=> '"1"',
                                'compare' 	=> 'LIKE',
                            )
                        ),
                    ];
                    $posts = get_posts($arg);
                    ?>

                    <?php
                    if( $posts ) {
                        foreach( $posts as $post ) {
                            $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'home_new');
                            ?>
                            <div class="news-box bg-white clearfix d-flex">
                                <div class="news-image">
                                    <a href="<?= get_permalink() ?>">
                                        <img src="<?= $thmbUrl?>" />
                                    </a>
                                </div>
                                <div class="news-content">
                                    <h3><a href="<?= get_permalink() ?>"><?= $post->post_title ?></a></h3>
                                    <span class="date">
                                    <span class="icon">
                                        <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                                    </span>
                                            <span class="txt">
                                        <?= get_the_date('Y-m-d') ?>
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

                            <?php
                        }
                    }
                    ?>

                </div>
                <?php
            }
        }
        ?>
    </div>
</div>