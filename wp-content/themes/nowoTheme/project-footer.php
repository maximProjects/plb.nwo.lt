<div class="row tasks-footer-container">
    <div class="col-md-6 col-md-push-3 task-footer">
        <h3>
            <?php echo ot_custom_get_option('project_social_text') ?>
        </h3>
        <div class="social-block">
            <div class="col-tn-6 col-xs-6 text-right">
                <a target="popup" onclick="window.open('http://www.facebook.com/sharer/sharer.php?u=#<?php echo get_site_url(); ?>','name','width=600,height=400')" href="http://www.facebook.com/sharer/sharer.php?u=#<?php echo get_site_url(); ?>">
                    <img src="<?php echo get_template_directory_uri() . '/img/icons/Facebook.png' ?>" alt="" title="facebook"/>
                </a>
            </div>

            <div class="col-tn-6 col-xs-6 text-left">
                <a target="popup" onclick="window.open('https://www.linkedin.com/cws/share?url=<?php echo get_site_url(); ?>','name','width=600,height=400')" href="https://www.linkedin.com/cws/share?url=<?php echo get_site_url(); ?>">
                    <img src="<?php echo get_template_directory_uri() . '/img/icons/IN.png' ?>" alt="" title="LinkedIn"/>
                </a>
            </div>
        </div>
        <hr/>
        <?php echo ot_custom_get_option('site_logo_bottom') != "" ?
            '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" rel="home" class="logo-footer"><img alt="logo" class="img-responsive" src="' . ot_custom_get_option('site_logo_bottom') . '" /></a>' :
            '<a href="<?php echo home_url(); ?>"><img alt="logo" src="' . get_template_directory_uri() . '/img/logo.svg" alt="Logo" class="logo-img"></a>'; ?>
    </div>
</div>