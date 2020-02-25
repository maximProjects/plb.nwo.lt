<?php
/**
 * Template Name: Map
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
<?php
$categories = get_terms( array(
    'post_per_page' => -1,
    'taxonomy'      => 'post_community'
) );
?>
 <div class="container map">
  <div class="row">
    <div class="col col-lg-12 text-center d-none d-md-block">
    <div id="map-container">

        <?= file_get_contents(get_template_directory_uri()."/img/map1.svg") ?>
    </div>


    </div>
      <?php

      ?>

<?php

foreach ($categories as $cat) {
    $title = $cat->name;
    if (get_field('map_title', 'post_community_' . $cat->term_id)) {
        $title = get_field('map_title', 'post_community_' . $cat->term_id);
    }
    ?>
    <div class="col-12 d-block d-md-none d-lg-none name-row">
        <h2><a href="<?= get_term_link($cat->term_id) ?>"><?= file_get_contents(get_template_directory_uri()."/img/team.svg") ?> <?= $title = $cat->name; ?></a></h2>
    </div>
    <?php
}
    ?>

  </div>

 </div>
<?php

foreach ($categories as $cat) {
    $title = $cat->name;
    if(get_field('map_title', 'post_community_'.$cat->term_id)) {
        $title = get_field('map_title', 'post_community_'.$cat->term_id);
    }
    ?>
    <div class="community-box" data-cat-id="<?= $cat->term_id ?>">
        <a href="#" class="close"><?= file_get_contents(get_template_directory_uri()."/img/close.svg") ?></a>
        <h2>
            <span><?= $title ?></span>
        </h2>
        <div class="content">
            <?= $cat->description ?>
        </div>
        <div class="links">
            <a href="<?= get_term_link($cat->term_id) ?>"><?= file_get_contents(get_template_directory_uri()."/img/attach.svg") ?> <?= __("Articles", nowotheme_DOMAIN) ?></a>

            <?php
            $contacts_id = get_field('contacts_page', 'post_community_'.$cat->term_id);
            if($contacts_id) {
                ?>
                <a href="<?= get_permalink($contacts_id[0]) ?>"><?= file_get_contents(get_template_directory_uri()."/img/envelope.svg") ?> <?= __("Contacts", nowotheme_DOMAIN) ?></a>
                <?php
            }
            ?>

        </div>

    </div>
    <?php
}
?>
<?php get_footer(); ?>