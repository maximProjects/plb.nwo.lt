<p><?php echo ot_custom_get_option('project_inquiry_text') ?></p>
<span class="tel"><?php echo ot_custom_get_option('project_inquiry_phone') ?></span>
<?php //echo apply_filters('global_submit_button_popup', '#ffffff', '#ffffff', __('Contact us', 'nwagency'), array('popup', 'invert'), 'contact_form_pop'); ?>

<div style="display:none" class="fancybox-hidden">
    <div id="contact_form_pop" class="popup_form">
        <h3>Jūsų projektas prasideda čia</h3>
        <h1>Susisiekime</h1>
        <?php echo do_shortcode('[contact-form-7 id="143" title="Kontaktai"]'); ?>
    </div>
</div>