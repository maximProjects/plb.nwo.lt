<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-09-03
 * Time: 09:30
 */


class SIM_Product extends SIM_Base
{


    public $id;

    public $post;
    
    public static $post_type = 'sim_product';

    public static $parameters;

    protected $product_price;

    protected $hide_product_price;

    protected $product_units;

    protected $product_url;

    protected $product_pdf;

    protected $product_declaration;

    protected $product_assoc_products;

    //Product parameters
    protected $product_has_parameters;

    protected $product_name;

    protected $product_dimension;

    protected $product_weight;

    protected $product_in_package;

    protected $product_total_weight;

    protected $product_thermal_resistance;

    protected $product_fire_class;

    protected $product_cold_resistance;

    protected $product_volume_weight;

    protected $product_units_in_24_tonn;

    protected $product_masonry_yield;

    protected $product_strength_class;

    protected $product_consumption_duration;

    protected $product_ultimate_strength;

    protected $product_storage_time;

    //Product tabs
    protected $product_has_tabs;

    protected $product_purpose;

    protected $product_features;

    protected $product_preparation;

    protected $product_mortar_preparation;

    protected $product_water_qnt;

    protected $product_bricklaying;

    protected $product_attention;

    protected $product_packing;

    protected $product_costs;



    /**
     * Saving Room parameters to meta
     */
    public function save()
    {
        $this->save_meta_value('_sim_product_price', $this->product_price);
        $this->save_meta_value('_sim_hide_product_price', $this->hide_product_price);
        $this->save_meta_value('_sim_product_units', $this->product_units);
        $this->save_meta_value('_sim_product_url', $this->product_url);
        $this->save_meta_value('_sim_product_pdf', $this->product_pdf);
        $this->save_meta_value('_sim_product_declaration', $this->product_declaration, false);
        $this->save_meta_value('_sim_product_assoc_products', $this->product_assoc_products, false);

        $this->save_meta_value('_sim_product_has_parameters', $this->product_has_parameters);
        //Setting parameters
        $this->save_meta_value('_sim_product_name', $this->product_name);
        $this->save_meta_value('_sim_product_dimension', $this->product_dimension);
        $this->save_meta_value('_sim_product_weight', $this->product_weight);
        $this->save_meta_value('_sim_product_in_package', $this->product_in_package);
        $this->save_meta_value('_sim_product_total_weight', $this->product_total_weight);

        $this->save_meta_value('_sim_product_thermal_resistance', $this->product_thermal_resistance);
        $this->save_meta_value('_sim_product_fire_class', $this->product_fire_class);
        $this->save_meta_value('_sim_product_cold_resistance', $this->product_cold_resistance);
        $this->save_meta_value('_sim_product_volume_weight', $this->product_volume_weight);
        $this->save_meta_value('_sim_product_units_in_24_tonn', $this->product_units_in_24_tonn);
        $this->save_meta_value('_sim_product_masonry_yield', $this->product_masonry_yield);
        $this->save_meta_value('_sim_product_strength_class', $this->product_strength_class);
        $this->save_meta_value('_sim_product_consumption_duration', $this->product_consumption_duration);
        $this->save_meta_value('_sim_product_ultimate_strength', $this->product_ultimate_strength);
        $this->save_meta_value('_sim_product_storage_time', $this->product_storage_time);


        $this->save_meta_value('_sim_product_has_tabs', $this->product_has_tabs);
        //Product tabs
        $this->save_meta_value('_sim_product_purpose', $this->product_purpose);
        $this->save_meta_value('_sim_product_features', $this->product_features);
        $this->save_meta_value('_sim_product_preparation', $this->product_preparation);
        $this->save_meta_value('_sim_product_mortar_preparation', $this->product_mortar_preparation);
        $this->save_meta_value('_sim_product_water_qnt', $this->product_water_qnt);
        $this->save_meta_value('_sim_product_bricklaying', $this->product_bricklaying);
        $this->save_meta_value('_sim_product_attention', $this->product_attention);
        $this->save_meta_value('_sim_product_packing', $this->product_packing);
        $this->save_meta_value('_sim_product_costs', $this->product_costs);
    }

    /**
     * Initializing object parameters from meta
     */
    public function init()
    {
        self::$parameters = self::get_parameters();
    }

    public static function get_parameters()
    {
        return array(
            'blocks' => array(
                'title' => __('Blocks', 'sim'),
                'fields' => array(
                    'product_name' => __('Product name', 'sim'),
                    'product_dimension' => __('Product dimension', 'sim'),
                    'product_weight' => __('Product weight', 'sim'),
                    'product_in_package' => __('In package', 'sim'),
                    'product_total_weight' => __('Total package weight', 'sim'),

                    'product_thermal_resistance' => __('Thermal resistance', 'sim'),
                    'product_fire_class' => __('Fire class', 'sim'),
                    'product_cold_resistance' => __('Resistance to cold', 'sim'),
                    'product_volume_weight' => __('Volume weight', 'sim'),
                    'product_units_in_24_tonn' => __('Units in 24 tons car', 'sim'),
                    'product_masonry_yield' => __('Calculate masonry yield', 'sim'),
                    'product_strength_class' => __('Strength class', 'sim'),
                    'product_consumption_duration' => __('Consumption duration', 'sim'),
                    'product_ultimate_strength' => __('Ultimate strength after 28 days', 'sim'),
                    'product_storage_time' => __('Storage time', 'sim'),
                )
            )
        );
    }


    public static function get_tabs()
    {
        $fields = array(
            'product_purpose' => array(
                'type' => 'textarea',
                'title'=> __('Purpose', 'sim'),
                'length'=>1000
            ),
            'product_features' => array(
                'type' => 'textarea',
                'title'=> __('Features', 'sim'),
                'length'=>1000
            ),
            'product_preparation' => array(
                'type' => 'textarea',
                'title'=> __('Preparation', 'sim'),
                'length'=>1000
            ),
            'product_mortar_preparation' => array(
                'type' => 'textarea',
                'title'=> __('Mortar preparation', 'sim'),
                'length'=>1000
            ),
            'product_water_qnt' => array(
                'type' => 'textarea',
                'title'=> __('Water qnt', 'sim'),
                'length'=>1000
            ),
            'product_bricklaying' => array(
                'type' => 'textarea',
                'title'=> __('Bricklaying', 'sim'),
                'length'=>1000
            ),
            'product_attention' => array(
                'type' => 'textarea',
                'title'=> __('Attention', 'sim'),
                'length'=>1000
            ),
            'product_packing' => array(
                'type' => 'textarea',
                'title'=> __('Packing and storage', 'sim'),
                'length'=>1000
            ),
            'product_costs' => array(
                'type' => 'textarea',
                'title'=> __('Costs', 'sim'),
                'length'=>1000
            )
        );

        return $fields;
    }

    /**
     * Getters for object fields
     */
    public function get_product_url()
    {
        return json_decode($this->get_meta_value('_sim_product_url'), false);
    }

    public function get_security_attachment()
    {
        return $this->get_meta_value('_sim_security_pdf', true);
    }

    public function get_installation_attachment()
    {
        return $this->get_meta_value('_sim_installation_pdf', true);
    }

    public function get_certificate_attachment()
    {
        return $this->get_meta_value('_sim_certificate_pdf', true);
    }

    public function get_product_declaration()
    {
        return $this->get_meta_value('_sim_declaration_pdf', false);
    }

    //Getting first available attachment by factory
    public function get_single_declaration()
    {
        $manufacturers = wp_get_post_terms($this->id, 'sim_product_factory');

        $attachments = SIM_Declaration::get_pdf_attachments($this->id, $manufacturers[0]->term_id, false);

        if(isset($attachments[0]))
            return $attachments[0]->ID;
        return false;

    }

    public function get_product_assoc_products()
    {
        return $this->get_meta_value('_sim_product_assoc_products', false);
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
    public function get_categorised_products($tax, $parent = 0)
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


    public static function get_products_manufacturers($arr_posts)
    {
        $manufacturers = array();
//
//        foreach($arr_posts as $product)
//        {
//            $manuf = wp_get_post_terms($product->ID, 'sim_product_manufacturer');
//            foreach($manuf as $man)
//            {
//                if(!isset($manufacturers[$man->term_id]))
//                {
//                    $manufacturers[$man->term_id] = $man;
//                }
//            }
//        }

        $manuf = apply_filters('tax_term_list', 'sim_product_manufacturer');

        foreach($manuf as $man)
        {
            if(!isset($manufacturers[$man->term_id]))
            {
                $manufacturers[$man->term_id] = $man;
            }
        }

        return $manufacturers;
    }


    public static function get_products_factories($arr_posts)
    {
        $factories = array();
//
        foreach($arr_posts as $product)
        {
            $manuf = wp_get_post_terms($product->ID, 'sim_product_factory');
            foreach($manuf as $man)
            {
                if(!isset($factories[$man->term_id]))
                {
                    $factories[$man->term_id] = $man;
                }
            }
        }

//        $manuf = apply_filters('tax_term_list', 'sim_product_factory');
//
//        foreach($manuf as $man)
//        {
//            if(!isset($factories[$man->term_id]))
//            {
//                $factories[$man->term_id] = $man;
//            }
//        }

        return $factories;
    }


    //Terrible realization and not optimized at all, but it worked and i have no time to optimize it ;) cheers mate :D
    public static function groupDeclarationsByStrength($products, $factories)
    {
        $retArr = array();
        $arr_streight = array();
        $arr_factoriesIds = array();

        foreach($products as $product){

            foreach($factories as $factory){

                $arr_factoriesIds[$product->ID][] = $factory->term_id;

                $attachments = SIM_Declaration::get_pdf_attachments($product->ID, $factory->term_id, false);

                foreach($attachments as $attachment){
                    $strength = get_post_meta($attachment->ID, '_declaration_strength', true);
                    if($strength)
                    {
                        if(!in_array($strength, $arr_streight))
                        {
                            array_push($arr_streight, $strength);
                        }
                        $retArr[$product->ID][$strength][$factory->term_id] = $attachment->ID ;
                    }

                }
            }
            if(is_array($retArr[$product->ID]))
            {
                foreach($retArr[$product->ID] as $strength => &$arrFactoriesAttachs)
                {

                    foreach($arr_factoriesIds[$product->ID] as $id)
                    {
                        if(!isset($arrFactoriesAttachs[$id]))
                        {
                            $arrFactoriesAttachs[$id] = '';
                        }
                    }
                }
            }


        }
        return $retArr;
    }

    /**
     * Getting current class post_type
     */
    public static function get_class_post_type()
    {
        return self::$post_type;
    }



    public function get_manufacturer_logo()
    {
        $manufacturers = wp_get_post_terms($this->id, 'sim_product_manufacturer');

        $logo = apply_filters('taxonomy_custom_field', $manufacturers[0]->taxonomy, $manufacturers[0]->term_id, 'product_manufacturer_logo', 'small');

        return $logo['sizes']['medium'];
    }
}