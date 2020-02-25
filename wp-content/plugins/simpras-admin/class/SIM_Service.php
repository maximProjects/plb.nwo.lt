<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-09-03
 * Time: 09:30
 */


class SIM_Service extends SIM_Base
{


    public $id;

    public $post;
    
    public static $post_type = 'sim_service';


    protected $service_price;
    protected $service_price_registered;
    protected $service_hide_price;



    /**
     * Saving Room parameters to meta
     */
    public function save()
    {
        $this->save_meta_value('_sim_service_price', $this->service_price);
        $this->save_meta_value('_sim_service_price_registered', $this->service_price_registered);
        $this->save_meta_value('_sim_service_hide_price', $this->service_hide_price);
    }

    /**
     * Initializing object parameters from meta
     */
    public function init()
    {

    }





    /**
     * Getting list of objects list
     */
    public function get_list_categorised($tax)
    {
        if(!$tax)
            $tax = self::$post_type.'_type';

        $post_type = self::get_class_post_type();

        $tax_terms = get_terms( $tax, 'parent=0&orderby=name&order=ASC');


        $ret_array = array();

        if ($tax_terms) {
            foreach ($tax_terms  as $tax_term) {
                $args = array(
                    'post_type'			=> $post_type,
                    "$tax"				=> $tax_term->slug,
                    'post_status'		=> 'publish',
                    'suppress_filters' => false,
                    'posts_per_page'	=> -1
                );

                $ret_array[$tax_term->term_id] =  get_posts($args);

            }
        }


        return $ret_array;
    }


    /**
     * Getting list of objects list
     */
    public function get_categorised_services($tax, $parent = 0)
    {
        if(!$tax)
            $tax = self::$post_type.'_type';

        $post_type = self::get_class_post_type();

        $tax_terms = get_terms( $tax, 'parent='.$parent.'&orderby=name&order=ASC');


        $ret_array = array();

        if ($tax_terms) {
            foreach ($tax_terms  as $tax_term) {
                $args = array(
                    'post_type'			=> $post_type,
                    "$tax"				=> $tax_term->slug,
                    'post_status'		=> 'publish',
                    'suppress_filters' => false,
                    'posts_per_page'	=> -1
                );

                $ret_array[$tax_term->term_id] =  get_posts($args);

            }
        }


        return $ret_array;
    }


    /**
     * @return mixed
     * Getting list of class objects
     */
    public static function get_list()
    {
        $args = array(
            'post_type' => self::$post_type,
            'posts_per_page' => '-1'
        );

        $posts = get_posts($args);

        array_walk($posts, array(__CLASS__, 'translate_to_class_object'));

        return $posts;
    }



    /**
     * Getting current class post_type
     */
    public static function get_class_post_type()
    {
        return self::$post_type;
    }




    public function get_price_list($parent = 0)
    {
        $args = array(
            'parent' => $parent
        );
        return wp_get_post_terms($this->id, 'sim_service_pricelist', $args);
    }


    public function get_price_list_price($term)
    {
        $price = get_term_meta($term->term_id, 'service_pricelist_price', true);

        return $price;
    }

    public function get_price_list_price_registered($term)
    {
        $price = get_term_meta($term->term_id, 'service_pricelist_price_registered', true);

        return $price;
    }

}