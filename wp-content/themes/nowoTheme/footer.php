<footer>
    <div class="container">
        <div class="row">
            <div class="col col-lg-4 text-left">

                <nav class="navbar navbar-expand-lg navbar-expand-md navbar-expand-sm">
                    <div class="menu">

                        <div class="navbar-collapse collapse show" id="navbarFooter">
                            <?php
                            wp_nav_menu( array(
                                'menu'        => 'footer_menu',
                                'container'      => false,
                                'depth'          => 2,
                                'menu_class'     => 'navbar-nav nav-fill w-100',
                                'walker'         => new Bootstrap_NavWalker(), // This controls the display of the Bootstrap Navbar
                                'fallback_cb'    => 'Bootstrap_NavWalker::fallback', // For menu fallback
                            ) );
                            ?>
                        </div>
                    </div>
                </nav>

            <p class="desctop">
              &copy; <?= __('Pasaulio Lietuvių Bendruomenė', nowotheme_DOMAIN) ?>
            </p>

            </div>
            <div class="col-12 col-md-8 col-lg-8 text-right">
                <a href="https://www.paypal.com/donate/?token=BpuJ_O7eH-RBHwETOqlhLwyMvlB_zWBWGBJAANyNlsvL1j7fSH3DilGXbPvJ7Ij7Y5TE-0&country.x=GB&locale.x=GB" target="_blank" class="actual button"><?= __('Donate', nowotheme_DOMAIN) ?> <?= file_get_contents(get_template_directory_uri()."/img/actual.svg") ?></a>
                <div class="home-subscribe">
                    <?php
                    /*
                    ?>
                    <form class="subscribe">
                        <input type="text" placeholder="<?= __("email", nowotheme_DOMAIN) ?>" />
                        <span class="submit-box">
                            <input type="submit" value="<?= __("Subscribe", nowotheme_DOMAIN) ?>" class="button-danger" />
                        </span>
                    </form>
*/
                    ?>
                    <?= do_shortcode("[sibwp_form id=3]") ?>
                </div>
            </div>
            <div class="col col-sm-12 d-lg-none d-sm-block text-center">
                <p>
                    &copy; <?= __('Pasaulio Lietuvių Bendruomenė', nowotheme_DOMAIN) ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>


</body>
</html>
