<div class="logo">

    <?php $logo =  'site_logo'; ?>
    <?php echo ot_custom_get_option($logo) != "" ?
        '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" rel="home"><img alt="logo" class="img-responsive" src="' . ot_custom_get_option($logo) . '" /></a>' :
        '<a href="<?php echo home_url(); ?>"><img alt="logo" src="' . get_template_directory_uri() . '/img/logo.svg" alt="Logo" class="logo-img"></a>'; ?>
</div>