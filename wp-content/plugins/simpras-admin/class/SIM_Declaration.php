<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-09-03
 * Time: 09:30
 */


class SIM_Declaration extends SIM_Base
{


    public $id;

    public $post;
    
    public static $post_type = 'sim_declaration';

    protected $declaration_strength;


    /**
     * Saving Room parameters to meta
     */
    public function save()
    {
        $this->save_meta_value('_sim_declaration_strength', $this->declaration_strength);

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
     * @return mixed
     * Getting list of class objects
     */
    public static function get_pdf_attachment($id_post, $manufacturer_id)
    {
        if(!$id_post)
            return false;

        $attachment_id = get_post_meta($id_post, '_sim_declaration_pdf', true);

        if(isset($attachment_id[$manufacturer_id]))
            return get_post($attachment_id[$manufacturer_id]);
        return false;
    }


    /**
     * @return mixed
     * Getting list of class objects
     */
    public static function get_pdf_attachments($id_post, $manufacturer_id = false, $unique = true)
    {
        if(!$id_post)
            return false;

        $attachments = get_post_meta($id_post, '_sim_declaration_pdf', $unique);

        if(!is_array($attachments))
            return array();

        array_walk($attachments, function(&$value){
            $value = unserialize($value);
        });

        if(!$manufacturer_id)
            return $attachments;

        foreach($attachments as $attachment_ids)
        {
            if(isset($attachment_ids[$manufacturer_id]))
            {
                array_walk($attachment_ids[$manufacturer_id], function(&$value){
                    $value = get_post(get_post($value));
                });

                if(!empty($attachment_ids[$manufacturer_id]))
                {
                    return $attachment_ids[$manufacturer_id];
                }
            }
        }

        return array();
    }


    /**
     * Getting current class post_type
     */
    public static function get_class_post_type()
    {
        return self::$post_type;
    }



    public static function getMainFields()
    {
        $fields = array(
            '_city_lat' => array(
                'type' => 'input',
                'title'=> __('City latitude', 'sim'),
                'length'=>250
            ),
            '_city_lon' => array(
                'type' => 'input',
                'title'=> __('City longitude', 'sim'),
                'length'=>250
            )
        );

        return $fields;
    }



    public static function getShopFileds()
    {
        $fields = array(
            '_city_shop_title' => array(
                'type' => 'input',
                'title'=> __('Shop name', 'sim'),
                'length'=>250
            ),
            '_city_shop_lat' => array(
                'type' => 'input',
                'title'=> __('Shop latitude', 'sim'),
                'length'=>250
            ),
            '_city_shop_lon' => array(
                'type' => 'input',
                'title'=> __('Shop longitude', 'sim'),
                'length'=>250
            ),
            '_city_shop_address' => array(
                'type' => 'input',
                'title'=> __('Shop address', 'sim'),
                'length'=>250
            ),
            '_city_shop_phone' => array(
                'type' => 'input',
                'title'=> __('Shop phone number', 'sim'),
                'length'=>250
            ),
            '_city_shop_working_hours' => array(
                'type' => 'textarea',
                'title'=> __('Shop working hours', 'sim'),
                'length'=>250
            )
        );

        return $fields;
    }
}