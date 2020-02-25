<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-05-22
 * Time: 15:07
 */


class Declarations{

    private $post_type;

    public function __construct()
    {

        $this->post_type = \SIM_Product::$post_type;

        add_action('manage_'.$this->post_type.'_posts_columns', array($this, 'ch_manage_project_task_posts_columns'), 10, 1);
        add_action( 'manage_'.$this->post_type.'_posts_custom_column', array($this,'ch_manage_project_task_posts_custom_column'), 10, 2 );
    }


    public function ch_manage_project_task_posts_columns($defaults)
    {
        $defaults['sim_project_declaration'] = __('Declaration', 'sim');

        return $defaults;
    }


    public function ch_manage_project_task_posts_custom_column($column_name, $post_id)
    {
        if ($column_name == 'sim_project_declaration') {

            $manufacturers = wp_get_post_terms($post_id, 'sim_product_factory');

            $attach = false;

            foreach($manufacturers as $manufacturer) {

                $attachments = SIM_Declaration::get_pdf_attachments($post_id, $manufacturer->term_id, false);

                if($attachments)
                {
                    foreach($attachments as $attachment)
                    {
                        echo $manufacturer->name . '  ' . get_post_meta($attachment->ID, '_declaration_strength', true) . ',<br/>';
                    }
                }
            }


        }
    }

}

return new Declarations();