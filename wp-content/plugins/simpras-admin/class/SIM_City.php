<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-09-03
 * Time: 09:30
 */


class SIM_City extends SIM_Base
{


    public $id;

    public $post;
    
    public static $post_type = 'sim_city';

    protected $product_url;

    protected $city_main_info;

    protected $city_shops;


    /**
     * Saving Room parameters to meta
     */
    public function save()
    {
        $this->save_meta_value('_sim_city_main_info', $this->city_main_info);

        $this->save_meta_value('_sim_city_shops', $this->city_shops);
    }


    /**
     * Initializing object parameters from meta
     */
    public function init()
    {

    }


    public function get_shops()
    {
        $data = unserialize(get_post_meta($this->id, '_sim_city_shops', true));


        if(is_array($data))
        {
            foreach($data as &$arr)
            {
                array_walk($arr, function(&$value, $key){

                    if($key == '_city_shop_file')
                    {
                        $arrImg = explode(',', $value);
                        $value = get_post($arrImg[0])->guid;
                    }else{

                        $value = stripslashes($value);
                    }
                });
            }


            return SIM_Helper::array_to_object($data);
        }else{
            return SIM_Helper::array_to_object(unserialize($data));
        }
    }


    public function get_city_main_info()
    {
        $data = get_post_meta($this->id, '_sim_city_main_info', true);


        return SIM_Helper::array_to_object(unserialize($data));
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
            ),
            '_city_address' => array(
                'type' => 'geocode',
                'title'=> __('City address', 'sim'),
                'length'=>250
            ),
        );

        return $fields;
    }


    /**
     * @param $str
     * @return array of attachments
     * Parse string of comma separated image ids
     */
    public static function getImages($str, $key_to_ids = false, $to_object = false)
    {
        if(!$str)
            return false;

        $images = explode(',', $str);

        return PIM_Gallery::getImageAttachments($images, $key_to_ids, $to_object);

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
                'type' => 'geocode',
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
            ),
            '_city_shop_hide' => array(
                'type' => 'checkbox',
                'title'=> __('Hide shop from map', 'sim'),
                'length'=>2
            ),
            '_city_shop_file' => array(
                'type' => 'file',
                'title'=> __('City icon', 'sim'),
                'length'=>250
            ),
        );

        return $fields;
    }
}