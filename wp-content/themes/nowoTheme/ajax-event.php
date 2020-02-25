<?php
$article = get_post($article_id);
?>
<div class="project-content bg-white">
    <div class="row pre-post">

        <div class="col-12 col-lg-4">

            <?php
            $thmbUrl = get_the_post_thumbnail_url($article->ID, 'event-single');
            ?>
            <img src="<?= $thmbUrl ?>" />

        </div>
        <div class="col-12 col-lg-8">
            <div class="pre-content">
                <h2>
                    <?= $article->post_title ?>
                </h2>
                <span class="icon calendar">
                                        <?= file_get_contents(get_template_directory_uri()."/img/date_icon.svg") ?>
                                    </span>
                <span class="txt">
                                        <?= get_field('start_date', $article->ID) ?> - <?= get_field('end_date', $article->ID) ?>
                                    </span>

                <?php
                $location = get_field('event_location', $article->ID);
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

                $first_text = get_field('first_text', $article->ID);
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
    </div>
    <div class="row">

        <div class="col-12 col-lg-12 align-self-center">

        </div>

        <div class="col-12 col-lg-12">

            <div class="article-content">

                <?php echo apply_filters('the_content', $article->post_content); ?>

            </div>
            <div class="socials text-right">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/facebook.svg") ?></a>
                <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/linkedin.svg") ?></a>
                <a target="_blank" href="https://www.facebook.com/dialog/send?app_id=260937461564689&link=<?= get_permalink() ?>&redirect_uri=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/messenger.svg") ?></a>
                <a target="_blank" href="http://twitter.com/share?text=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/twitter.svg") ?></a>
                <a target="_blank" href="mailto:?subject=<?= the_title() ?>&body=<?= get_permalink() ?>"><?= file_get_contents(get_template_directory_uri()."/img/envelope.svg") ?></a>
                <span><?= file_get_contents(get_template_directory_uri()."/img/share.svg") ?> <span><?= __('Share', nowotheme_DOMAIN) ?></span></span>
            </div>
        </div>

    </div>


</div>
