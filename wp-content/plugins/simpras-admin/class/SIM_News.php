<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-09-03
 * Time: 09:30
 */


class SIM_News extends SIM_Base
{


    public $id;

    public $post;
    
    public static $post_type = 'sim_news';

    protected $article_videos;


    /**
     * Saving Room parameters to meta
     */
    public function save()
    {
        $this->save_meta_value('_sim_article_videos', $this->article_videos);

    }


    /**
     * Initializing object parameters from meta
     */
    public function init()
    {

    }


    public function get_article_videos($decode = false)
    {
        if($decode)
            return json_decode(get_post_meta($this->id, '_sim_article_videos', true));
        return get_post_meta($this->id, '_sim_article_videos', true);

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
    public static function get_list_args($args)
    {
        $args_def = array(
            'post_type' => self::$post_type,
            'posts_per_page' => '-1'
        );

        $args = array_merge($args_def, $args);

        $posts = get_posts($args);

        array_walk($posts, function(&$post){

            $post =  self::getById($post->ID);
        });

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
            )
        );

        return $fields;
    }



    public static function get_video_fields()
    {
        $fields = array(
            '_article_video_title' => array(
                'type' => 'input',
                'title'=> __('Video title', 'sim'),
                'length'=>250
            ),
            '_article_video_description' => array(
                'type' => 'textarea',
                'title'=> __('Description', 'sim'),
                'length'=>400
            ),
            '_article_video_url' => array(
                'type' => 'input',
                'title'=> __('Video url', 'sim'),
                'length'=>600
            )
        );

        return $fields;
    }
}