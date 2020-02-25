<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-09-03
 * Time: 09:30
 */


class SIM_Employee extends SIM_Base
{


    public $id;

    public $post;
    
    public static $post_type = 'sim_employee';

    protected $employee_name;

    protected $employee_surname;

    protected $employee_specialization;

    protected $employee_email;

    protected $employee_phone;

    protected $employee_region;

    protected $employee_linkedin;


    /**
     * Saving Room parameters to meta
     */
    public function save()
    {
        $this->save_meta_value('_sim_employee_name', $this->employee_name);
        $this->save_meta_value('_sim_employee_surname', $this->employee_surname);
        $this->save_meta_value('_sim_employee_email', $this->employee_email);
        $this->save_meta_value('_sim_employee_specialization', $this->employee_specialization);
        $this->save_meta_value('_sim_employee_phone', $this->employee_phone);
        $this->save_meta_value('_sim_employee_region', $this->employee_region);
        $this->save_meta_value('_sim_employee_linkedin', $this->employee_linkedin);
    }

    /**
     * Initializing object parameters from meta
     */
    public function init()
    {
//        $this->set_room_mainColor($this->get_meta_value('_'.self::$post_type.'_main_color'));
    }


    public function getRegionsArray()
    {
        if($this->get_meta_value('_sim_employee_region', true))
        {
            return unserialize($this->get_meta_value('_sim_employee_region', true));
        }
        return array();
    }

    public function get_position()
    {
        $terms = wp_get_post_terms($this->id, 'sim_employee_position');

        $position = array();

        foreach($terms as $terms)
        {
            array_push($position, $terms->name);
        }

        if(!empty($position))
            return implode(',', $position);
        return false;
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



    /**
     * @param $region_id
     * Search posts by meta value region_id
     * @return array of posts
     */
    public static function getByRegionId($region_id)
    {
        $args = array(
            'post_type' => self::$post_type,
            'posts_number' => '-1',
            'meta_query' => array(
                array(
                    'key' => '_sim_employee_region',
                    'value' => '"'.$region_id.'"',
                    'compare' => 'LIKE'
                )
            )
        );

        $posts = get_posts($args);

        return $posts;
    }
}