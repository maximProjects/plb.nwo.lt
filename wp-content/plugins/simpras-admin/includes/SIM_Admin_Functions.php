<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-23
 * Time: 13:46
 */


class SIM_Admin_Functions{


    public function __construct()
    {

        add_filter('file_upload_form', array( $this, 'sim_file_upload_form'), 0, 3);

        add_filter('file_upload_form_native', array( $this, 'sim_file_upload_form_native'), 0, 3);

//        add_action('admin_menu', array( $this, 'sim_add_global_custom_options'), 0, 2);

        //Adding post type menu as submenu of another post type
        add_action('admin_menu', array( $this, 'sim_add_menu_shops'), 0, 2);

        add_action('admin_init', array($this, 'sim_update_options'));

        /**
         * ToDO: only started doing this one, so you have to finish. Add theme video support and complete file save
         */
        add_filter('video_upload_form', array( $this, 'ch_video_upload_form'), 0, 3);

        //taxonomy-term-image
        add_filter( 'taxonomy-term-image-taxonomy', array($this, 'sim_taxonomy_term_image_taxonomy'));

    }

    //Global
    function sim_file_upload_form($post_id, $meta_name, $form_title)
    {

        ob_start();

        $existing_image_id = get_post_meta($post_id, $meta_name, true);
        $arr_existing_image = wp_get_attachment_image_src($existing_image_id, 'large');
        $existing_image_url = $arr_existing_image[0];
        $file_title = get_the_title($existing_image_id);
        $file_link = wp_get_attachment_url($existing_image_id);


        ?>

        <h2><?php echo $form_title; ?></h2>

        <table>
            <?php if(is_numeric($existing_image_id)): ?>
                <tr>
                    <td>
                        <a target="_blank" href="<?php echo $file_link; ?>">
                            <span class="dashicons dashicons-media-text"></span>
                            <?php echo $file_title; ?>
                            <hr>
                        </a>
                    </td>
                    <td>
                        Delete file: <input type="checkbox" name="delete_files[<?php echo $existing_image_id; ?>][<?php echo $meta_name; ?>]"
                                            id="delete_[<?php echo $existing_image_id; ?>][<?php echo $meta_name; ?>]" />
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>
                    Upload file: <input type="file" name="<?php echo $meta_name; ?>" id="<?php echo $meta_name; ?>" />
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>


        <?php
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }


    public function sim_file_upload_form_native($post_id, $meta_name, $form_title)
    {

        $upload_id = '_sim_declaration_pdf';

        $svalue = ""; // this will be initial value of the above form field. Image urls.

        $multiple = true; // allow multiple files upload

        $width = null; // If you want to automatically resize all uploaded images then provide width here (in pixels)

        $height = null; // If you want to automatically resize all uploaded images then provide height here (in pixels)

        $attachments = SIM_Declaration::get_pdf_attachments($post_id, $meta_name, false);

        $meta_name = 'product_declarations['.$meta_name.']';
        ?>


        <div class="row">
            <label><?php echo $form_title; ?></label>

            <div class="clear"></div>
            <?php wp_nonce_field('pim-form-save', 'pim-save-form-nonce'); ?>
            <input type="hidden" name="<?php echo $meta_name."[".$upload_id."][new]"; ?>" id="<?php echo $upload_id; ?>" value="<?php echo $svalue; ?>" class="img-id" data-target="<?php echo $meta_name."[".$upload_id."]"; ?>"/>
            <input type="hidden" name="<?php echo $upload_id; ?>_base" id="<?php echo $upload_id; ?>_base" value="<?php echo $svalue; ?>" class="img-id" />
            <div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $upload_id; ?>plupload-upload-ui">
                <input id="<?php echo $upload_id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button modal-upload-btn" data-target="<?php echo $meta_name."[".$upload_id."]"; ?>" />
                <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($upload_id . 'pluploadan'); ?>"></span>
                <?php if ($width && $height): ?>
                    <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
                    <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
                <?php endif; ?>
                <div class="filelist"></div>
            </div>
            <div class="images plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $upload_id; ?>plupload-thumbs">
            </div>

            <div class="clear"></div>
            <div class="images plupload-attach"  data-target="<?php echo $meta_name."[".$upload_id."]"; ?>">
                <?php if($attachments): ?>
                    <?php $url = SIM_RESOURCES_URL.'img/icons/pdf_ico.png' ?>
                    <?php foreach($attachments as $attachment): ?>
                        <div class="thumb sortable" id="attachment_<?php echo $upload_id; ?>">
                            <img src="<?php echo $url; ?>" alt="">
                            <input type="hidden" name="<?php echo $meta_name."[".$upload_id."][]"; ?>" class="images_order" value="<?php echo $attachment->ID; ?>">
                            <a href="#" data-attachment-edit="<?php echo $upload_id; ?>" class="delete_attachment modal-edit-btn">
                                <span class="dashicons dashicons-edit"></span>
                            </a>
                            <a href="#" data-attachment-remove="<?php echo $upload_id; ?>" class="delete_attachment modal-remove-btn" style="float: right;">
                                <span class="dashicons dashicons-trash"></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>


        <?

        return '';
    }

    /**
     * Adding plugin option page admin menu
     */
    public function sim_add_global_custom_options()
    {
        add_options_page('Scandagra theme settings', 'Scandagra settings', 'manage_options', 'functions', array($this, 'theme_custom_options'));
    }


    public function sim_add_menu_shops()
    {
        global $submenu;

        if(!post_type_exists('sim_city_shop'))
            return false;

        $url = 'edit.php?post_type=sim_city_shop';

        $submenu['edit.php?post_type=sim_city'][] = array(__('Shops', 'sim'), 'manage_options', $url);
    }


    public function sim_update_options() {

        if (!isset($_POST['scandagra_theme_options']))
            return false;

        $input_options = array();
        $input_options['objects'] = isset($_POST['objects']) ? $_POST['objects'] : '';
        $input_options['objects_slide'] = isset($_POST['objects_slide']) ? $_POST['objects_slide'] : '';
        $input_options['tags'] = isset($_POST['tags']) ? $_POST['tags'] : '';

        update_option('scandagra_theme_options', $input_options);

        wp_redirect('admin.php?page=pimorder-settings&msg=update');
    }


    public function sim_taxonomy_term_image_taxonomy( $taxonomy ) {
        // use for tags instead of categories
        return 'sim_product_category';
    }

    public function sim_global_custom_options()
    {
        include_once(PLUGINNAME_BASE . '/settings.php');
    }

}

return new SIM_Admin_Functions();