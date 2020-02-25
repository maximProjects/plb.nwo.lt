<?php
global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request));

$countries = get_terms( 'post_country', array(
    'hide_empty' => false,
) );

$category = get_queried_object();

$args = array('category' => $category->term_id, 'post_type'	=> 'post',  'posts_per_page'	=> 1);


$country_select = __('Country', nowotheme_DOMAIN);
$filter = 0;
if($_GET['filter']) {
    $filter = $_GET['filter'];

    $args['meta_query'] = array(

        array(
            'key'		=> 'filter_values',
            'value'		=> '"'.$filter.'"',
            'compare'	=> 'LIKE'
        )

    );
}

if($_GET['country']) {
    $filter = $_GET['country'];
    $country = get_term( $filter, 'post_country');
    $country_select = $country->name;
    $args['tax_query'] = array(

        array(
            'taxonomy'		=> 'post_country',
            'field'		=> 'term_id',
            'terms'	=> $filter
        )

    );
}

$posts = get_posts($args);
?>
<div class="container section">
    <div class="row">
        <div class="col col-lg-12">
            <h1 class="title">
                    <span class="icon">
                        <?= file_get_contents($data['catThmbUrl']) ?>
                    </span>
                <?php single_cat_title(); ?>
            </h1>
        </div>
    </div>

    <div class="row filter row-eq-height">
        <div class="col-12 col-lg-6 align-self-center">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <div class="navbar-collapse collapse show" id="navbarFilter">
                    <ul id="filter-menu" class="navbar-nav nav-fill w-100">
                        <li class="nav-item"><a href="<?= $current_url ?>?filter=news" class="nav-link">Naujausi</a></li>
                        <li class="nav-item"><a href="<?= $current_url ?>?filter=popular" class="nav-link">Populiariausi</a></li>
                        <li class="nav-item"><a href="<?= $current_url ?>?filter=video" class="nav-link">Video medžiaga</a></li>
                        <li class="nav-item"><a href="<?= $current_url ?>?filter=photos" class="nav-link">Nuotraukos</a></li>
                        <li class="nav-item"><a href="<?= $current_url ?>?filter=posts" class="nav-link">Straipsniai</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-60 nav-item active dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbar-dropdown-menu-link-60" aria-haspopup="true" aria-expanded="false"><?= $country_select ?></a>
                            <div class="sub-menu dropdown-menu" aria-labelledby="navbar-dropdown-menu-link-60">
                                <?php

                                foreach($countries as $c) {
                                    ?>
                                    <a href="<?= $current_url ?>?country=<?= $c->term_id ?>" class="dropdown-item"><?= $c->name ?></a>
                                <?php
                                }
                                ?>

                            </div>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
        <div class="col col-lg-6 text-right align-self-center ">
            <div class="search-box">
                <input type="text" placeholder="<?= __('Search', nowotheme_DOMAIN) ?>"><?= file_get_contents(get_template_directory_uri()."/img/search.svg") ?>
            </div>
    </div>
</div>
<div class="row">


            <?php
            foreach( $posts as $post ) {
                $t = get_field('filter_values');

            $thmbUrl = get_the_post_thumbnail_url(get_the_ID(), 'category_thmb');
            ?>
            <div class="col-12 col-lg-12 d-sm-flex news-box">
                    <div class="news-image">
                        <a href="<?= get_permalink() ?>">
                            <img src="<?= $thmbUrl?>" />
                        </a>
                    </div>
                    <div class="news-content">
                        <h3><a href="<?= get_permalink() ?>"><?= $post->post_title ?></a></h3>
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
                        <p>
                            <?= the_excerpt() ?>
                        </p>
                        <a href="<?= get_permalink() ?>" class="button">
                            <?= __('Read more', nowotheme_DOMAIN) ?>
                        </a>
                    </div>

            </div>

        <?php } ?>



    </div>


</div>


