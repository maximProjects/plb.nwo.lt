<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Declaration_Attachments{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_declaration_attachments';
        $this->title = __('Declaration Attachments', 'sim');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_product');

        $this->upload_id = "_sim_declaration_pdf";

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

        add_action( 'admin_enqueue_scripts', array( $this, 'styles_and_scripts' ) );
    }


    /**
     * Add admin styles
     */
    public function styles_and_scripts()
    {

        global $post, $woocommerce, $wp_scripts;


        if(isset($post) && $post && !in_array($post->post_type, $this->post_types))// adjust this if-condition according to your theme/plugin
            return;

        wp_enqueue_script('plupload-all');


        wp_register_script('pim_popupformjs', SIM_RESOURCES_URL.'js/popup-form.js', array('jquery'));
        wp_enqueue_script('pim_popupformjs');


        wp_register_style('myplupload', SIM_RESOURCES_URL.'css/myplupload.css');
        wp_enqueue_style('myplupload');

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $product = SIM_Product::getById($post_id);


        $svalue = ""; // this will be initial value of the above form field. Image urls.

        $multiple = true; // allow multiple files upload

        $width = null; // If you want to automatically resize all uploaded images then provide width here (in pixels)

        $height = null; // If you want to automatically resize all uploaded images then provide height here (in pixels)

//        debugvar($post_id);
//        debugvar(get_post_meta($post_id));
//        exit;

        $form = '';

        $manufacturers = wp_get_post_terms($post_id, 'sim_product_factory');

        echo '<h1>'.__('Declaration Attachments', 'sim').'</h1><hr>';

        foreach($manufacturers as $manufacturer)
        {
            $form .= apply_filters('file_upload_form_native', $post_id, $manufacturer->term_id, sprintf("%s %s", $manufacturer->name, __('declaration pdf', 'sim')));
        }

        echo $form;

        ?>



    <?php
    }





    function meta_box_save($post_id)
    {

        //TODO implement native wordpress media upload

//        if($post_id == 245)
//        {
//            debugvar($_FILES);
//            debugvar($_POST);
//            exit;
//        }

        if (in_array(get_post_type($post_id), $this->post_types)) {

            if(!isset($_POST['_inline_edit']))
            {

                $product = SIM_Product::getById($post_id);

                if(isset($_POST['product_declarations']) && $_POST['product_declarations'])
                {

                    delete_post_meta($post_id, '_sim_declaration_pdf');
                    foreach($_POST['product_declarations'] as $id_manufacturer => $attachments)
                    {

                        if($attachments['_sim_declaration_pdf'] != '')
                        {
                            $attach_ids = array();

                            if(isset($attachments['_sim_declaration_pdf']['new']))
                            {

                                $arr_ids =  array_filter(explode(',', $attachments['_sim_declaration_pdf']['new']));

                                foreach($arr_ids as $id)
                                {
                                    array_push($attach_ids, $id);
                                }
                            }



                            unset($attachments['_sim_declaration_pdf']['new']);

                            if(is_array($attachments['_sim_declaration_pdf']))
                            {
                                foreach ($attachments['_sim_declaration_pdf'] as $attach) {
                                    $attach_ids[] = $attach;
                                }

                            }

                            debugvar(array($id_manufacturer =>$attach_ids));
//                            exit;

                            /*
                             * Array
                                (
                                    [0] => 1095
                                    [1] => 1092
                                )
                             */
                            add_post_meta($post_id, '_sim_declaration_pdf', serialize(array($id_manufacturer =>$attach_ids)));
                        }
                    }

//                    exit;


                }
            }

        }

    }


}

return new Declaration_Attachments();