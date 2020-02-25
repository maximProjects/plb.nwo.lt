<?php

define('SIM_VERSION', '1.0.2');
define('SIM_DOMAIN', 'sim');
define('SIM_BASE', plugin_dir_path(__FILE__));
define('SIM_BASE_URL', plugin_dir_url(__FILE__));
define('SIM_TEMPLATE_PATH', plugin_dir_path(__FILE__) . 'templates/');
define('SIM_RESOURCES_URL', SIM_BASE_URL . 'src/resources/');
define('SIM_MAIN_FILE', __FILE__);


class SimprasAdmin{


    public function __construct()
    {
        //Include Post Type Classes
        include_once(SIM_BASE . '/class/Singleton.php');
        include_once(SIM_BASE . '/class/SIM_Base.php');
        include_once(SIM_BASE . '/class/SIM_Helper.php');
        include_once(SIM_BASE . '/class/SIM_Product.php');
        include_once(SIM_BASE . '/class/SIM_SpecialOffer.php');
        include_once(SIM_BASE . '/class/SIM_Service.php');
        include_once(SIM_BASE . '/class/SIM_Partner.php');
        include_once(SIM_BASE . '/class/SIM_Employee.php');
        include_once(SIM_BASE . '/class/SIM_Review.php');
        include_once(SIM_BASE . '/class/SIM_City.php');
        include_once(SIM_BASE . '/class/SIM_Declaration.php');
        include_once(SIM_BASE . '/class/SIM_Node.php');
        include_once(SIM_BASE . '/class/SIM_News.php');
        include_once(SIM_BASE . '/class/SIM_Video.php');
        include_once(SIM_BASE . '/class/SIM_Gallery.php');
        include_once(SIM_BASE . '/class/SIM_Slide.php');
        include_once(SIM_BASE . '/class/SIM_Timeline.php');



        //Include frontend functions
        include_once(SIM_BASE . 'includes/SIM_Functions.php');
        include_once(SIM_BASE . 'includes/SIM_Admin_Functions.php');
        include_once(SIM_BASE . 'includes/SIM_Ajax_Functions.php');

        //include Admin metaboxes
        include_once(SIM_BASE . '/admin/metaboxes/SIM_Metabox.php');
        include_once(SIM_BASE . '/admin/taxonomies/SIM_Taxonomy_Fields.php');

        //include admin filters and columns
        include_once(SIM_BASE . 'admin/filters/SIM_Filter.php');
        include_once(SIM_BASE . 'admin/columns/SIM_Column.php');

        //Loading scripts
//        add_action( 'init', array( $this, 'load_styles' ), 2 );
        add_action( 'init', array( $this, 'load_scripts' ), 2 );

        // Adding action to post type creation
        add_action( 'admin_print_scripts-post-new.php', array( $this, 'post_admin_scripts' ) );
        add_action( 'admin_print_scripts-post.php', array( $this, 'post_admin_scripts' ) );

        add_action( 'init', array( $this, 'register_post_types' ), 2 );
        add_action('init', array($this, 'load_plugin_textdomain'));
    }





    function post_admin_scripts()
    {
        /*
         * Custom scripts for post type admin pages
         */

//        global $post_type;
//        if (in_array($post_type, array())) {
//
//            wp_register_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array(), '1.0', 'all');
//            wp_enqueue_style('bootstrap'); // Enqueue it!
//        }

    }


    public function load_scripts()
    {
        if(is_admin())
        {
            /**
             * admin scripts here
             * wp_register_script('', SIM_RESOURCES_URL . '../components/../', array(''), '');
             * wp_enqueue_script('');
             */
        }
    }


    // Including post types
    public function register_post_types()
    {

        $post_types = array(
            array(
                'id' => SIM_DOMAIN . '_product',
                'name_single' => __('Product', 'sim'),
                'name_plural' => __('Products', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('product', 'sim')),
                    'supports' => array('title', 'editor', 'excerpt' ,'thumbnail')
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_service',
                'name_single' => __('Service', 'sim'),
                'name_plural' => __('Services', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('service', 'sim')),
                    'supports' => array('title', 'editor', 'excerpt' ,'thumbnail')
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_special_offer',
                'name_single' => __('Special offer', 'sim'),
                'name_plural' => __('Special offers', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('special-offer', 'sim')),
                    'supports' => array('title', 'editor', 'excerpt' ,'thumbnail')
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_city',
                'name_single' => __('City', 'sim'),
                'name_plural' => __('Cities', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('city', 'sim')),
                    'supports' => array('title', 'editor', 'thumbnail')
                )
            ),
            array(
                'id' => 'sim' . '_slide',
                'name_single' => __('Slide', 'sim'),
                'name_plural' => __('Slides', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('slide', 'sim')),
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'exclude_from_search' => true
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_partner',
                'name_single' => __('Partner', 'sim'),
                'name_plural' => __('Partners', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('where-to-buy', 'sim')),
                    'supports' => array('title', 'thumbnail'),
                    'exclude_from_search' => true
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_news',
                'name_single' => __('News', 'sim'),
                'name_plural' => __('News', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('news', 'sim')),
                    'supports' => array('title', 'editor', 'thumbnail')
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_video',
                'name_single' => __('Video', 'sim'),
                'name_plural' => __('Videos', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('our-video', 'sim')),
                    'supports' => array('title', 'editor', 'thumbnail')
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_review',
                'name_single' => __('Review', 'sim'),
                'name_plural' => __('Reviews', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('reviews', 'sim')),
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'exclude_from_search' => true
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_document',
                'name_single' => __('Document', 'sim'),
                'name_plural' => __('Documents', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('documents', 'sim')),
                    'supports' => array('title', 'thumbnail', 'editor'),
                    'exclude_from_search' => true
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_employee',
                'name_single' => __('Employee', 'sim'),
                'name_plural' => __('Employee', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('employee', 'sim')),
                    'supports' => array('title', 'thumbnail', 'editor')
                )
            ),
//            array(
//                'id' => SIM_DOMAIN . '_gallery',
//                'name_single' => __('Gallery', 'sim'),
//                'name_plural' => __('Galleries', 'sim'),
//                'args' => array(
//                    'rewrite' => array('slug' => __('gallery', 'sim')),
//                    'supports' => array('title', 'editor', 'thumbnail')
//                )
//            ),
//            array(
//                'id' => SIM_DOMAIN . '_declaration',
//                'name_single' => __('Declarations', 'sim'),
//                'name_plural' => __('Declarations', 'sim'),
//                'args' => array(
//                    'show_in_menu' => false,
//                    'rewrite' => array('slug' => __('declaration', 'sim')),
//                    'supports' => array('title')
//                )
//            ),
//            array(
//                'id' => SIM_DOMAIN . '_node',
//                'name_single' => __('Node', 'sim'),
//                'name_plural' => __('Nodes', 'sim'),
//                'args' => array(
//                    'rewrite' => array('slug' => __('node', 'sim')),
//                    'supports' => array('title')
//                )
//            ),
            array(
                'id' => SIM_DOMAIN . '_timeline',
                'name_single' => __('Timeline', 'sim'),
                'name_plural' => __('Timeline', 'sim'),
                'args' => array(
                    'rewrite' => array('slug' => __('timeline', 'sim')),
                    'supports' => array('title', 'editor')
                )
            ),
        );


        $taxonomies = array(
            array(
                'id' => SIM_DOMAIN . '_product_category',
                'name_single' => 'Product category',
                'name_plural' => 'Product categories',
                'posts' => array(SIM_DOMAIN . '_product', ),
                'args' => array(
                    'rewrite' => array( 'slug' => __('Product-category', 'sim') )
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_gallery_category',
                'name_single' => 'Gallery category',
                'name_plural' => 'Gallery categories',
                'posts' => array(SIM_DOMAIN . '_gallery'),
                'args' => array(
                    'rewrite' => array( 'slug' => __('Gallery-category', 'sim') )
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_employee_position',
                'name_single' => 'Employee position',
                'name_plural' => 'Employee positions',
                'posts' => array(SIM_DOMAIN . '_employee', ),
                'args' => array(
                    'rewrite' => array( 'slug' => __('employee-position', 'sca') )
                )
            ),
//            array(
//                'id' => SIM_DOMAIN . '_service_pricelist',
//                'name_single' => 'Price list',
//                'name_plural' => 'Price lists',
//                'posts' => array(SIM_DOMAIN . '_service'),
//                'args' => array(
//                    'rewrite' => array( 'slug' => __('price-list', 'sim') )
//                )
//            ),
//            array(
//                'id' => SIM_DOMAIN . '_product_declaration_category',
//                'name_single' => 'Declaration category',
//                'name_plural' => 'Declarations categories',
//                'posts' => array(SIM_DOMAIN . '_product', ),
//                'args' => array(
//                    'rewrite' => array( 'slug' => __('Product-declarations-category', 'sim') )
//                )
//            ),
//            array(
//                'id' => SIM_DOMAIN . '_product_manufacturer',
//                'name_single' => 'Product manufacturer',
//                'name_plural' => 'Product manufacturers',
//                'posts' => array(SIM_DOMAIN . '_product', SIM_DOMAIN . '_declaration',),
//                'args' => array(
//                    'rewrite' => array( 'slug' => __('Product-manufacturer', 'sim') )
//                )
//            ),
//            array(
//                'id' => SIM_DOMAIN . '_product_factory',
//                'name_single' => 'Product factory',
//                'name_plural' => 'Product factories',
//                'posts' => array(SIM_DOMAIN . '_product',),
//                'args' => array(
//                    'rewrite' => array( 'slug' => __('product-factory', 'sim') )
//                )
//            ),
            array(
                'id' => 'post_community',
                'slug' => 'community',
                'name_single' => 'Community',
                'name_plural' => 'Community',
                'posts' => array('post' ),
                'args' => array(
                    'rewrite' => array( 'slug' => __('community', 'sim') ),
                    'hierarchical' => false
                )
            ),

            array(
                'id' => 'post_community_contact',
                'slug' => 'community_contact',
                'name_single' => 'Community contact',
                'name_plural' => 'Community contacts',
                'posts' => array('post' ),
                'args' => array(
                    'rewrite' => array( 'slug' => __('community-contact', 'sim') ),
                    'hierarchical' => false
                )
            ),




            array(
                'id' => 'post_country',
                'name_single' => 'Country',
                'name_plural' => 'Countries',
                'posts' => array('post' ),
                'args' => array(
                    'rewrite' => array( 'slug' => __('country', 'sim') ),
                    'hierarchical' => false
                )
            ),


//            array(
//                'id' => SIM_DOMAIN . '_news_community',
//                'name_single' => 'Community',
//                'name_plural' => 'Community',
//                'posts' => array(SIM_DOMAIN . '_news', ),
//                'args' => array(
//                    'rewrite' => array( 'slug' => __('community', 'sim') ),
//                    'hierarchical' => false
//                )
//            ),
//
//            array(
//                'id' => SIM_DOMAIN . '_news_category',
//                'name_single' => 'Category',
//                'name_plural' => 'Category',
//                'posts' => array(SIM_DOMAIN . '_news', ),
//                'args' => array(
//                    'rewrite' => array( 'slug' => __('category', 'sim') ),
//                    'hierarchical' => false
//                )
//            ),
//
//
//            array(
//                'id' => SIM_DOMAIN . '_news_country',
//                'name_single' => 'Country',
//                'name_plural' => 'Countries',
//                'posts' => array(SIM_DOMAIN . '_news', ),
//                'args' => array(
//                    'rewrite' => array( 'slug' => __('country', 'sim') ),
//                    'hierarchical' => false
//                )
//            ),



            array(
                'id' => SIM_DOMAIN . '_city_country',
                'name_single' => 'Country',
                'name_plural' => 'Countries',
                'posts' => array(SIM_DOMAIN . '_city', ),
                'args' => array(
                    'rewrite' => array( 'slug' => __('country', 'sim') ),
                    'hierarchical' => false
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_declaration_category',
                'name_single' => 'Declaration category',
                'name_plural' => 'Declaration categories',
                'posts' => array(SIM_DOMAIN . '_declaration', ),
                'args' => array(
                    'rewrite' => array( 'slug' => __('declaration-category', 'sim') ),
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_node_category',
                'name_single' => 'Node category',
                'name_plural' => 'Node categories',
                'posts' => array(SIM_DOMAIN . '_node', ),
                'args' => array(
                    'rewrite' => array( 'slug' => __('node-category', 'sim') ),
                )
            ),
            array(
                'id' => SIM_DOMAIN . '_document_category',
                'name_single' => 'Document category',
                'name_plural' => 'Documents categories',
                'posts' => array(SIM_DOMAIN . '_document', ),

                'args' => array(
                    'rewrite' => array( 'slug' => __('document-category', 'sim') ),

                    'hierarchical' => true
                )
            ),
        );

        foreach($post_types as $post_type)
        {
            // Add new custom post type
            $labels = array(
                'name' => __($post_type['name_plural'], 'Product plural name', 'sim'),
                'singular_name' => __($post_type['name_single'], 'Product singular name', 'sim'),
                'menu_name' => __($post_type['name_plural'], 'admin menu', 'sim'),
                'name_admin_bar' => __($post_type['name_single'], 'add new on admin bar', 'sim'),
                'add_new' => __('Add New', $post_type['name_single'], 'sim'),
                'add_new_item' => __('Add New ' . $post_type['name_single'], 'sim'),
                'new_item' => __('New ' . $post_type['name_single'], 'sim'),
                'edit_item' => __('Edit ' . $post_type['name_single'], 'sim'),
                'view_item' => __('View ' . $post_type['name_single'], 'sim'),
                'all_items' => __('Our ' . $post_type['name_plural'], 'sim'),
                'search_items' => __('Search ' . $post_type['name_plural'], 'sim'),
                'parent_item_colon' => __('Parent ' . $post_type['name_single'] . ':', 'sim'),
                'not_found' => __('No '. $post_type['name_plural'] .' found.', 'sim'),
                'not_found_in_trash' => __('No '. $post_type['name_plural'] .' found in Trash.', 'sim')
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'menu_icon' => get_template_directory_uri() . '/img/favicon/favicon-16x16.png'
            );

            $args = array_merge($args, $post_type['args']);


            register_post_type($post_type['id'], $args);
        }


        foreach ($taxonomies as $taxonomy) {

            // Add new taxonomy, NOT hierarchical (like tags)
            $labels = array(
                'name'                       => __( $taxonomy['name_plural'], 'taxonomy general name', 'sim' ),
                'singular_name'              => __( $taxonomy['name_plural'], 'taxonomy singular name', 'sim' ),
                'search_items'               => __( 'Search ' . $taxonomy['name_single'], 'sim' ),
                'popular_items'              => __( 'Popular ' . $taxonomy['name_plural'], 'sim' ),
                'all_items'                  => __( 'All ' . $taxonomy['name_plural'], 'sim' ),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __( 'Edit ' . $taxonomy['name_single'], 'sim' ),
                'update_item'                => __( 'Update ' . $taxonomy['name_single'], 'sim' ),
                'add_new_item'               => __( 'Add New ' . $taxonomy['name_single'], 'sim' ),
                'new_item_name'              => __( 'New ' . $taxonomy['name_single'] . ' Name', 'sim' ),
                'separate_items_with_commas' => __( 'Separate ' . $taxonomy['name_plural'] . ' with commas', 'sim' ),
                'add_or_remove_items'        => __( 'Add or remove ' . $taxonomy['name_plural'], 'sim' ),
                'choose_from_most_used'      => __( 'Choose from the most used ' . $taxonomy['name_plural'], 'sim' ),
                'not_found'                  => __( 'No ' . $taxonomy['name_plural'] . ' found.', 'sim' ),
                'menu_name'                  => __( $taxonomy['name_plural'], 'sim' ),
            );

            $args = array(
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'archive'               => true,
                'show_admin_column'     => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var'             => true,
            );

            $args = array_merge($args, $taxonomy['args']);

            register_taxonomy( $taxonomy['id'], $taxonomy['posts'], $args );
        }


    }




    /**
     * Localisation
     */
    public function load_plugin_textdomain()
    {
        $locale = apply_filters('plugin_locale', get_locale(), 'sim');
        $dir = trailingslashit(WP_LANG_DIR);

        load_textdomain(SIM_DOMAIN, $dir . SIM_DOMAIN . DIRECTORY_SEPARATOR . SIM_DOMAIN . '-' . $locale . '.mo');
        load_plugin_textdomain(SIM_DOMAIN, false, dirname(plugin_basename(__FILE__)) . DIRECTORY_SEPARATOR . 'languages');
    }



}


return new SimprasAdmin();