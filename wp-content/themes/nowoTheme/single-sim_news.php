<?php get_header();


?>


<section>

    <div class="container">

        <h2 class="title section-header">
            <span><?php echo get_the_title(); ?></span>
        </h2>

        <div class="content-container page-content news-container">
            <div class="row">
                <article class="col-md-12 content news-content">
                    <time><?php echo date('Y-m-d', strtotime($post->post_date)); ?></time>
                    <?php echo apply_filters('the_content', get_the_content()); ?>

                    <a class="link-back" href="<?php echo get_permalink(get_page_by_template('inner-page-news')); ?>"><?php echo __('Back to all articles', 'nowotheme'); ?></a>
                </article>
            </div>
        </div>

    </div>


</section>


<section class="dark">
    <div class="container news-container">

        <h3 class="title subsection-header">
            <span><?php echo __('Related news', 'nowotheme'); ?></span>
        </h3>

        <div class="row">
            <?php foreach(SIM_News::get_list() as $article): ?>
                <div class="col-tn-12 col-xs-6 col-sm-6 col-md-4">
                    <div class="news-article">
                        <img class="img-responsive" src="<?php echo apply_filters('post_image_url', $article->id, 'article_list_medium') ?>" alt="">

                        <time><?php echo date('Y-m-d', strtotime($article->post->post_date)); ?></time>
                        <h4 class="title"><?php echo $article->post->post_title; ?></h4>

                        <div class="content">
                            <?php echo apply_filters('the_content', SIM_Helper::truncateHtml($article->post->post_content, 100)); ?>
                        </div>

                        <a href="<?php echo get_permalink($article->id); ?>" class="btn btn-exclusive">
                            <?php echo __('Read more', 'nowotheme'); ?>
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>
