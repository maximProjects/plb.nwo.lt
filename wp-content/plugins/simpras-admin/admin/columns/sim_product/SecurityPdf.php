<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-05-22
 * Time: 15:07
 */


class SecurityPdf{

    private $post_type;

    public function __construct()
    {

        $this->post_type = \SIM_Product::$post_type;

        add_action('manage_'.$this->post_type.'_posts_columns', array($this, 'ch_manage_project_task_posts_columns'), 10, 1);
        add_action( 'manage_'.$this->post_type.'_posts_custom_column', array($this,'ch_manage_project_task_posts_custom_column'), 10, 2 );
    }


    public function ch_manage_project_task_posts_columns($defaults)
    {
        $defaults['sim_security_pdf'] = __('Security pdf', 'sim');

        return $defaults;
    }


    public function ch_manage_project_task_posts_custom_column($column_name, $post_id)
    {
        if ($column_name == 'sim_security_pdf') {

            $product = SIM_Product::getById($post_id);

            $sim_security_pdf = $product->get_security_attachment();


            if($sim_security_pdf)
            {
                echo '+';
            }


        }
    }

}

return new SecurityPdf();