<!doctype html>
<html <?php language_attributes(); ?> class="no-js <?php echo is_front_page() ? 'front-page' : '' ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(); ?></title>

    <link href="//www.google-analytics.com" rel="dns-prefetch">

    <link rel="apple-touch-icon" sizes="57x57"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-57x57.png"; ?>">
    <link rel="apple-touch-icon" sizes="60x60"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-60x60.png"; ?>">
    <link rel="apple-touch-icon" sizes="72x72"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-72x72.png"; ?>">
    <link rel="apple-touch-icon" sizes="76x76"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-76x76.png"; ?>">
    <link rel="apple-touch-icon" sizes="114x114"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-114x114.png"; ?>">
    <link rel="apple-touch-icon" sizes="120x120"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-120x120.png"; ?>">
    <link rel="apple-touch-icon" sizes="144x144"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-144x144.png"; ?>">
    <link rel="apple-touch-icon" sizes="152x152"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-152x152.png"; ?>">
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo get_template_directory_uri()."/img/favicon/apple-icon-180x180.png"; ?>">
    <link rel="icon" type="image/png" sizes="192x192"
          href="<?php echo get_template_directory_uri()."/img/favicon/android-icon-192x192.png"; ?>">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo get_template_directory_uri()."/img/favicon/favicon-32x32.png"; ?>">
    <link rel="icon" type="image/png" sizes="96x96"
          href="<?php echo get_template_directory_uri()."/img/favicon/favicon-96x96.png"; ?>">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo get_template_directory_uri()."/img/favicon/favicon-16x16.png"; ?>">
    <link rel="manifest" href="/manifest.json">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <meta name="google-site-verification" content="nxvC1F_-9-p0euUr4ypUv_R91n89gBT3NXH50P-reoY"/>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
</head>

<body>
<div id="paypal-box">
    <?= do_shortcode('[paypal-donation]') ?>
</div>
<?php
$langsArr = apply_filters('language_switcher_display', $post);
?>
<a href="#" class="scroll-top"><?= file_get_contents(get_template_directory_uri()."/img/scroll_icon.svg") ?></a>
<div class="header-box">
    <div class="container-fluid container-header">
        <div class="row no-gutters mobile-padding">
            <div class="col col-lg-5  align-self-center d-none d-sm-none d-lg-block">
                <span class="txt"><?= __('Follow', nowotheme_DOMAIN) ?></span>&#8212;<span class="soc-links"><a target="_blank" href="https://www.facebook.com/worldLTcomm/">Fb</a> <a target="_blank" href="https://www.youtube.com/channel/UCum_OrO-p-f3BikBvyOmo5Q/">Yt</a></span>

            </div>
            <div class="col col-lg-2 col-sm-12 col-xs-12 logo text-center">
                <a href="<?= home_url() ?>"><img src="<?= get_template_directory_uri() ?>/img/logo.png" /></a>
            </div>
            <div class="col col-lg-5 align-self-center text-right d-none d-sm-none d-lg-block">
                <div class="lang-switcher">
                    <?php
                    foreach($langsArr as $code => $lng) {
                        $l_class = "";
                        if($lng["active"]) {
                            $l_class = "active";
                        }
                        ?>
                        <a href="<?= $lng['url'] ?>" class="<?= $l_class ?>"><img src="<?= $lng["country_flag_url"] ?>"></a>
                    <?php
                    }
                    ?>
                </div>
                <a target="_blank" href="#" target="_blank" class="actual button"><?= __('Donate', nowotheme_DOMAIN) ?> <?= file_get_contents(get_template_directory_uri()."/img/actual.svg") ?></a>
            </div>
        </div>
    </div>

    <div class="header-separator"></div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container menu">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar10">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbar10">
                <?php
                wp_nav_menu( array(
                    'menu'        => 'main_menu',
                    'container'      => false,
                    'depth'          => 2,
                    'menu_class'     => 'navbar-nav nav-fill w-100',
                    'walker'         => new Bootstrap_NavWalker(), // This controls the display of the Bootstrap Navbar
                    'fallback_cb'    => 'Bootstrap_NavWalker::fallback', // For menu fallback
                ) );
                ?>
                <?php
                /*
                ?>
                <div class="mobile-menu-items">
                    lvsplsvdl
                </div>
                */
                ?>
                <div class="mobile-menu-part d-lg-none d-md-flex d-flex">
                    <div class="social">
                        <span class="soc-links"><a target="_blank" href="https://www.facebook.com/worldLTcomm/">Fb</a> <a target="_blank" href="https://www.youtube.com/channel/UCum_OrO-p-f3BikBvyOmo5Q/">Yt</a></span>
                    </div>
                    <div class="languages">
                        <div class="lang-switcher">
                            <?php
                            foreach($langsArr as $code => $lng) {
                                $l_class = "";
                                if($lng["active"]) {
                                    $l_class = "active";
                                }
                                ?>
                                <a href="<?= $lng['url'] ?>" class="<?= $l_class ?>"><img src="<?= $lng["country_flag_url"] ?>"></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="donate w-50 text-right">
                        <a href="https://www.paypal.com/donate/?token=BpuJ_O7eH-RBHwETOqlhLwyMvlB_zWBWGBJAANyNlsvL1j7fSH3DilGXbPvJ7Ij7Y5TE-0&country.x=GB&locale.x=GB" target="_blank" class="actual button"><?= __('Donate', nowotheme_DOMAIN) ?> <?= file_get_contents(get_template_directory_uri()."/img/actual.svg") ?></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>



