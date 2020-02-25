<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-23
 * Time: 13:46
 */


class SIM_Functions{


    public function __construct()
    {

        add_action('admin_menu', array( $this, 'add_global_custom_options'), 0, 2);

        //Global functions
        add_filter('post_type_list', array($this, 'sim_post_type_list'), 0, 1);
        add_filter('index_post_type_list', array($this, 'sim_index_post_type_list'), 0, 1);
        add_filter('tax_term_list', array($this, 'sim_tax_term_list'), 0, 2);
        add_filter('posts_by_term', array($this, 'sim_posts_by_term'), 0, 4);
        add_filter('group_by_post_type', array($this , 'sim_group_by_post_type'), 0, 1);
        add_filter('group_in_array', array($this , 'sim_group_in_array'), 0, 2);
        add_filter('sidebar_menu', array($this , 'sim_sidebar_menu'), 0, 0);
        add_filter('youtube_video_display', array( $this, 'sim_youtube_video_display'), 0, 4);
        add_filter('company_address_locations', array( $this, 'sim_company_address_locations'), 0, 0);



        //Format functions
        add_filter('url_format', array($this, 'sim_url_format'), 0, 1);

        //Catalog
        add_filter('post_sort_by_request', array( $this, 'sim_post_sort_by_request'), 0, 4);
        add_filter('get_random_posts', array( $this, 'sim_get_random_posts'), 0, 2);
        add_filter('get_post_main_term', array( $this, 'sim_get_post_main_term'), 0, 2);

        //Taxonomies
        add_filter('top_level_parent_term', array($this , 'sim_top_level_parent_term'), 0, 2);
        add_filter('bottom_level_term', array($this , 'sim_bottom_level_term'), 0, 2);
        //Post functions
        add_filter('top_level_parent', array($this , 'sim_top_level_parent'), 0, 1);

        //Images
        add_filter('post_image_url', array($this , 'sim_post_image_url'), 0, 2);
        add_filter('display_image_gallery', array($this, 'sim_post_image_gallery'), 0, 3);

        //Search
        add_filter('taxonomies_search', array($this , 'sim_taxonomies_search'), 0, 2);

        //Contact forms seven
        add_filter('wpcf7_before_send_mail', array($this, 'sim_dynamic_recipient'), 10, 2);
        add_filter('wpcf7_dynamic_recipient_address', array($this, 'sim_dynamic_recipient_address'), 10, 1);


        //Advanced custom post type plugin
        add_filter('taxonomy_custom_field', array($this, 'sim_taxonomy_custom_field'), 0, 4);

        //WPML
        add_filter('post_by_current_language', array($this, 'sim_post_by_current_language'), 0, 2);

        //Meta slider
//        add_filter('metaslider_image_nivo_slider_markup', array($this, 'sim_metaslider_image_coin_slider_markup'), 10, 3);

        //Download attachment
        add_filter('da_display_attachments', array($this, 'sim_da_display_attachments'), 0, 2);

        add_action('wp_loaded', array($this, 'sim_shortcode_cleanup'));


}


    public function sim_shortcode_cleanup()
    {

        remove_shortcode('download-attachments');
        add_shortcode( 'download-attachments', array(&$this, 'sim_download_attachment') );
    }

    //Global functions

    /**
     * Adding plugin option page admin menu
     */
    public function add_global_custom_options()
    {
        add_options_page('Plugin options', 'Plugin options', 'manage_options', 'functions','global_custom_options');
    }


    /**
     * @param $post_type
     * @return mixed
     * Getting post type list
     */
    public function sim_post_type_list($post_type)
    {
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => -1
        );

        return get_posts($args);
    }


    /**
     * @param $arr_list array of Post objects
     * @return array|bool
     */
    public function sim_index_post_type_list($arr_list)
    {
        if(!$arr_list || empty($arr_list))
            return false;

        $ret_arr = array();


        foreach($arr_list as $post)
        {
            $ret_arr[$post->ID] = $post;
        }

        return $ret_arr;

    }

    /**
     * @param $taxanomy
     * @param bool|false $args
     * @return mixed
     * Get taxonomy terms list
     */
    public function sim_tax_term_list($taxonomy, $args = false)
    {
        $args_def = array(
            'hide_empty' => false
        );

        if(is_array($args))
        {
            $args = array_merge($args_def, $args);
        }

        return get_terms($taxonomy, $args);
    }


    /**
     * @param $post_type
     * @param $taxanomy
     * @param $term
     * @return mixed
     * Get posts in term
     */
    public function sim_posts_by_term($post_type, $taxanomy, $term, $args = array())
    {
        $args_default = array(
            'post_type' => $post_type,
            'posts_per_page'=>-1,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxanomy,
                    'field' => 'id',
                    'terms' => $term->term_id
                )
            )
        );

        $args = array_merge($args_default, $args);

        return get_posts($args);
    }


    /**
     * @param $posts
     * @return array|bool
     * Grouping posts by post type
     */
    public function sim_group_by_post_type($posts)
    {
        if(!$posts && !empty($posts))
            return false;

        $ret_arr = array();

        foreach ($posts as $post) {
            $ret_arr[$post->post_type][] = $post;
        }

        return $ret_arr;

    }


    public function sim_group_in_array($posts, $quantity_in_array = 4)
    {
        $ret_array = array();
        $i = 0;

        foreach($posts as $post)
        {
            $ret_array[$i][] = $post;

            if(isset($ret_array[$i]) && !(count($ret_array[$i]) < $quantity_in_array))
            {
                $i++;
            }
        }

        return $ret_array;
    }


    public function sim_sidebar_menu()
    {
        global $wp_query, $post;

        $menu_items = '';
        $parent_term = '';

        if($post->post_parent === 0)
        {
            $menu_items = get_pages("title_li=&child_of=".$post->ID."&sort_column=menu_order&show_date=modified");
        }
        elseif(is_page())
        {
            $menu_items = get_pages("title_li=&child_of=".$post->post_parent."&sort_column=menu_order&show_date=modified");

        }else{

            if(is_singular(array(SIM_Product::$post_type)))
            {
                $product = SIM_Product::getById(get_the_ID());

                $terms = wp_get_post_terms( $product->id, 'sim_product_category' );

                foreach($terms as $term)
                {
                    if($term->parent > 0)
                    {
                        $tax = $term;
                        break;
                    }
                }
            }else{
                $tax = $wp_query->get_queried_object();
            }

            $parent_term = $tax->parent == 0 ? $tax : apply_filters('top_level_parent_term', $tax->term_id, $tax->taxonomy);
            $menu_items = get_term_children($parent_term->term_id, $tax->taxonomy);

        }

        ob_start();
        ?>


        <?php if(!is_a($menu_items, 'WP_Error') && $menu_items): ?>
            <ul class="nav nav-pills nav-stacked list-group sidebar">
                <?php if(is_page()): ?>
                    <?php foreach($menu_items as $post_item): ?>
                        <li role="presentation" class="<?php echo get_the_ID() == $post_item->ID ? 'active' : ''; ?> list-group-item">
                            <a href="<?php echo get_permalink($post_item->ID); ?>"><?php echo $post_item->post_title; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>

                    <?php foreach($menu_items as $term_id): ?>
                        <?php $term = get_term($term_id); ?>
                        <?php if($term->parent == $parent_term->term_id): ?>
                            <li role="presentation" class="<?php echo $tax->term_id == $term_id ? 'active' : ''; ?> list-group-item">
                                <a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?>
                                </a>
                            </li>
                        <?php endif ?>
                    <?php endforeach; ?>
                <?php endif ?>
            </ul>
        <?php endif; ?>

        <?php

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }


    public function sim_youtube_video_display($url, $width = '640', $height = '385', $id_only = false)
    {
        preg_match(
            '/[\\?\\&]v=([^\\?\\&]+)/',
            $url,
            $matches
        );
        $id = $matches[1];

        if($id_only)
        {
            return $id;
        }else{

            echo "<iframe width='$width' height='$height' src='https://www.youtube.com/embed/{$id}?rel=0' frameborder='0' allowfullscreen></iframe>";
        }
    }


    public function sim_company_address_locations()
    {

    }


    //Format functions
    public function sim_url_format($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }

    public function sim_post_by_current_language($post_id, $post_type = 'post')

    {

        return get_post(icl_object_id($post_id, $post_type, false));

    }


    //Meta slider functions
    public function sim_metaslider_image_coin_slider_markup($html, $slide, $settings) {

        return $html .= "<a class='btn btn-default'>View</a>";
    }


    //Catalog functions
    public function sim_post_sort_by_request($taxonomy, $category_terms, $order_by, $per_page)
    {

        global $wp_query;

        $def_args = array(
            'posts_per_page' => $per_page,
            'offset' => isset($wp_query->query_vars['paged']) && $wp_query->query_vars['paged'] > 0 ? $wp_query->query_vars['paged'] * $per_page - $per_page : 0,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $category_terms,
                    'operator' => 'IN',
                )
            ),
        );


        $args = array();

        switch($order_by){
            case 'desc_name':
                $args = array(
                    'orderby' => 'title',
                    'order' => 'desc',
                );
                break;

            case 'asc_name':
                $args = array(
                    'orderby' => 'title',
                    'order' => 'asc',
                );
                break;

            case 'desc_price':
                $args = array(
                    'meta_key' => '_sim_product_price',
                    'orderby' => 'meta_value_num',
                    'order' => 'desc',
                    'meta_query' => array(
                        array(
                            'key'     => '_sim_product_price',
                            'value'   => null,
                            'compare' => '!='
                        )
                    ),
                );
                break;

            case 'asc_price':
                $args = array(
                    'meta_key' => '_sim_product_price',
                    'orderby' => 'meta_value_num',
                    'order' => 'asc',
                    'meta_query' => array(
                        array(
                            'key'     => '_sim_product_price',
                            'value'   => null,
                            'compare' => '!='
                        )
                    ),
                );
                break;

//            case 'desc_manuf':
//                $args = array(
//                    'meta_key' => 'sim_product_manufacturer',
//                    'orderby' => 'meta_value',
//                    'order' => 'desc',
//                    'meta_query' => array(
//                        array(
//                            'key'     => 'sim_product_manufacturer',
//                            'value'   => null,
//                            'compare' => '!='
//                        )
//                    ),
//                );
//                break;
//
//            case 'asc_manuf':
//                $args = array(
//                    'meta_key' => 'sim_product_manufacturer',
//                    'orderby' => 'meta_value',
//                    'order' => 'asc',
//                    'meta_query' => array(
//                        array(
//                            'key'     => 'sim_product_manufacturer',
//                            'value'   => null,
//                            'compare' => '!='
//                        )
//                    ),
//                );
//                break;
            default:
                $args = array(
                    'orderby' => 'menu_order',
                    'order' => 'asc',
                );
                break;
        }

        $args = array_merge($args, $def_args);

        $result = new WP_Query( $args );

//        debugvar($result->request);
//        exit;

        return $result;

    }


    public function sim_get_random_posts($post_type, $qnt = 3)
    {
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => $qnt,
            'orderby' => 'rand'
        );

        return get_posts($args);
    }


    public function sim_get_post_main_term($post_id, $taxanomy)
    {
        $terms = wp_get_post_terms($post_id, $taxanomy);

        if($terms)
        {
            return $terms[0];
        }
        return false;
    }


    //Taxonomy functions
    public function sim_top_level_parent_term($term_id, $taxonomy)
    {
        // start from the current term
        $parent  = get_term_by( 'id', $term_id, $taxonomy);

        if($parent->parent == 0){
            return $parent;
        }

        // climb up the hierarchy until we reach a term with parent = '0'
        while ($parent->parent != '0'){
            $term_id = $parent->parent;

            $parent  = get_term_by( 'id', $term_id, $taxonomy);
        }
        return $parent;
    }

    public function sim_bottom_level_term($term_id, $taxonomy)
    {
        // start from the current term
        $parent  = get_term_by( 'id', $term_id, $taxonomy);

        $children = get_term_children($term_id, $taxonomy);

        if($parent->parent == 0){
            return $parent;
        }

        // climb up the hierarchy until we reach a term with parent = '0'
        while ($parent->parent != '0'){
            $term_id = $parent->parent;

            $parent  = get_term_by( 'id', $term_id, $taxonomy);
        }
        return $parent;
    }

    //Post functions
    public function sim_top_level_parent($post_id)
    {
        // start from the current term
        $parent  = get_post_ancestors($post_id);
        return $parent[0];

        // climb up the hierarchy until we reach a term with parent = '0'
        while ($parent->parent != '0'){
            $term_id = $parent->parent;

            $parent  = get_term_by( 'id', $term_id, $taxonomy);
        }
        return $parent;
    }


    //Image functions

    public function sim_post_image_url($post_id, $size = 'thumbnail')
    {
        $feat_image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size );

        return $feat_image[0];
    }


    public function sim_post_image_gallery($post_id, $title_image = false, $only_button = true)
    {
        ob_start();


        ?>

        <?php $images = apply_filters('pim_gallery_images', $post_id, false); ?>

        <?php if($images): ?>
        <?php $gal_id = $images[0]->ID; ?>
        <div class="gallery-images text-center">

            <?php if($title_image): ?>
                <a href="<?php echo $images[0]->guid ?>" title="<?php echo __('Gallery', 'scandagra'); ?>" data-rel="lightbox_<?php echo $gal_id; ?>">
                    <img src="<?php echo apply_filters('pim_image_url', $images[0]->ID, 'large'); ?>" alt="" class="img-responsive no-shadow center-block">
                    <hr class="blank">
                </a>
                <?php unset($images[0]); ?>
            <?php else: ?>
                <a href="<?php echo $images[0]->guid; ?>" data-rel="lightbox_<?php echo $gal_id; ?>" title="<?php echo __('Gallery', 'scandagra'); ?>" class="lightbox btn btn-exclusive hollow">
                    <?php echo __('Gallery', 'scandagra'); ?>
                </a>
            <?php endif; ?>

            <div class="thumbnails nav gallery-slider">

                <?php foreach($images as $image): ?>
                    <div class="slide">
                        <a href="<?php echo $image->guid; ?>" data-rel="lightbox_<?php echo $gal_id; ?>">
                            <img src="<?php echo apply_filters('pim_image_url', $image->ID, 'small'); ?>" alt="" class="img-responsive no-shadow center-block">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
        <div class="clearfix"></div>

        <?

        $html = ob_get_contents();
        ob_end_clean();

        echo $html;
    }


    //Search functions

    /**
     * @param $query
     * @param bool|false $taxonomies
     * @return array
     * Modify instant-search-suggest plugin to search in taxonomies
     */
    public function sim_taxonomies_search($query, $taxonomies = false)
    {
        // taxononomies
        $tax_query = array();
        $tax_args = array();
        $tax_output = 'objects';
        $tax_operator = 'and';
        $tax = get_taxonomies( $tax_args, $tax_output, $tax_operator );

        if(!$taxonomies)
            $taxonomies = $tax;

        $results = wp_cache_get( 'sim_' . sanitize_title_with_dashes( $query ), 'sim_search' );


        if($results == false){


            if ( !empty( $taxonomies ) ) {

                foreach ( $taxonomies as $tax ) {

                    $tax_query[] = $tax->name;
                }
            }


            if ( !empty( $tax_query ) ) {

                $terms = get_terms( $tax_query, 'search='.$query );

                if ( ! empty( $terms ) ) {

                    foreach ( $terms as $term ) {

                        $results[] = array(
                            'title' => $term->name,
                            'permalink' => get_term_link( $term->name, $term->taxonomy ),
                            'taxonomy' => $taxonomies[$term->taxonomy]->labels->singular_name,
                            'count' => $term->count,
                            'type' => 'taxonomy'
                        );
                    }
                }
            }
        }

        if ( ! empty( $results ) ) {

            wp_cache_set( 'sim_' . sanitize_title_with_dashes( $query ), $results, 'sim_search', 3600 );

        }

        return $results;
    }



    //Contact forms 7

    /**
     * @param $form
     * Modifies recipient list to add custom address
     */
    public function sim_dynamic_recipient($form) {

        $mail = $form->properties;
        $properites = $form->get_properties();

        if (!isset($_POST['dynamic-recipient-id'])) {
            return;
        }

        $new_recipient = apply_filters('wpcf7_dynamic_recipient_address', $_POST['dynamic-recipient-id']);
        $properites['mail']['recipient'] .= ','. $new_recipient;

        $form->set_properties($properites);
    }



    public function sim_dynamic_recipient_address($id_job_offer)
    {
        $joboffer = SCA_JobOffer::getById($id_job_offer);

        return $joboffer->joboffer_recipients;
    }


    //Advanced custom post type plugin

    /**
     * @param $taxonomy
     * @param $term_id
     * @param $field
     * @param string $size
     * @return mixed
     * Getting taxonomy custom field
     */
    public function sim_taxonomy_custom_field($taxonomy, $term_id, $field, $size = false)
    {

        $field = get_field($field, $taxonomy . '_' . $term_id);

        if($size)
        {
            if(isset($field['sizes'][$size]))
            {
                return $field['sizes'][$size];
            }
        }

        return $field;
    }


    public function sim_da_display_attachments($post_id = 0, $args = array())
    {

        $post_id = (int) (empty( $post_id ) ? get_the_ID() : $post_id);

        $options = get_option( 'download_attachments_general' );

        $defaults = array(
            'container'				 => 'div',
            'container_class'		 => 'download-attachments',
            'container_id'			 => '',
            'style'					 => isset( $options['display_style'] ) ? esc_attr( $options['display_style'] ) : 'list',
            'link_before'			 => '',
            'link_after'			 => '',
            'content_before'		 => '',
            'content_after'			 => '',
            'display_index'			 => isset( $options['frontend_columns']['index'] ) ? (int) $options['frontend_columns']['index'] : false,
            'display_user'			 => (int) $options['frontend_columns']['author'],
            'display_icon'			 => (int) $options['frontend_columns']['icon'],
            'display_count'			 => (int) $options['frontend_columns']['downloads'],
            'display_size'			 => (int) $options['frontend_columns']['size'],
            'display_date'			 => (int) $options['frontend_columns']['date'],
            'display_caption'		 => (int) $options['frontend_content']['caption'],
            'display_description'	 => (int) $options['frontend_content']['description'],
            'display_empty'			 => 0,
            'display_option_none'	 => __( 'No attachments to download', 'download-attachments' ),
            'use_desc_for_title'	 => 0,
            'exclude'				 => '',
            'include'				 => '',
            'title'					 => __( 'Download Attachments', 'download-attachments' ),
            'title_container'		 => 'p',
            'title_class'			 => 'download-title',
            'orderby'				 => 'menu_order',
            'order'					 => 'asc',
            'echo'					 => 1
        );

        $args = apply_filters( 'da_display_attachments_defaults', array_merge( $defaults, $args ), $post_id );

        $args['display_index'] = apply_filters( 'da_display_attachments_index', (int) $args['display_index'] );
        $args['display_user'] = apply_filters( 'da_display_attachments_user', (int) $args['display_user'] );
        $args['display_icon'] = apply_filters( 'da_display_attachments_icon', (int) $args['display_icon'] );
        $args['display_count'] = apply_filters( 'da_display_attachments_count', (int) $args['display_count'] );
        $args['display_size'] = apply_filters( 'da_display_attachments_size', (int) $args['display_size'] );
        $args['display_date'] = apply_filters( 'da_display_attachments_date', (int) $args['display_date'] );
        $args['display_caption'] = apply_filters( 'da_display_attachments_caption', (int) $args['display_caption'] );
        $args['display_description'] = apply_filters( 'da_display_attachments_description', (int) $args['display_description'] );
        $args['display_empty'] = apply_filters( 'da_display_attachments_empty', (int) $args['display_empty'] );
        $args['use_desc_for_title'] = (int) $args['use_desc_for_title'];
        $args['echo'] = (int) $args['echo'];
        $args['style'] = (in_array( $args['style'], array( 'list', 'table', 'none', '' ), true ) ? $args['style'] : $defaults['style']);
        $args['orderby'] = (in_array( $args['orderby'], array( 'menu_order', 'attachment_id', 'attachment_date', 'attachment_title', 'attachment_size', 'attachment_downloads' ), true ) ? $args['orderby'] : $defaults['orderby']);
        $args['order'] = (in_array( $args['order'], array( 'asc', 'desc' ), true ) ? $args['order'] : $defaults['order']);
        $args['link_before'] = trim( $args['link_before'] );
        $args['link_after'] = trim( $args['link_after'] );
        $args['display_option_none'] = (($info = trim( $args['display_option_none'] )) !== '' ? $info : $defaults['display_option_none']);

        $args['title'] = apply_filters( 'da_display_attachments_title', trim( $args['title'] ) );

        $attachments = da_get_download_attachments(
            $post_id, apply_filters(
                'da_display_attachments_args', array(
                    'include'	 => $args['include'],
                    'exclude'	 => $args['exclude'],
                    'orderby'	 => $args['orderby'],
                    'order'		 => $args['order']
                )
            )
        );

        $count = count( $attachments );
        $html = '';

        if ( ! ($args['display_empty'] === 0 && $count === 0) ) {
            //start container
            if ( $args['container'] !== '' )
                $html .= '<' . $args['container'] . ($args['container_id'] !== '' ? ' id="' . $args['container_id'] . '"' : '') . ($args['container_class'] !== '' ? ' class="' . $args['container_class'] . '"' : '') . '>';

            //title
//            if ( $args['title'] !== '' )
//                $html .= ($args['title'] !== '' ? '<' . $args['title_container'] . ' class="' . $args['title_class'] . '">' . $args['title'] . '</' . $args['title_container'] . '>' : '');
        }

        $html .= $args['content_before'];

        if ( $count > 0 ) {
            $i = 1;

            if ( $args['style'] === 'list' ) {
                $item_container = 'span';
                $html .= '<ul>';
            } else {
                $item_container = 'td';

                $html .= '<table class="table"><thead>';

                if ( $args['display_index'] === 1 )
                    $html .= '<th class="attachment-index">#</th>';

                $html .= '<th class="attachment-title">' . __( 'File', 'download-attachments' ) . '</th>';

                if ( $args['display_caption'] === 1 || ( $args['display_description'] === 1 && $args['use_desc_for_title'] === 0 ) )
                    $html .= '<th class="attachment-about">' . __( 'Description', 'download-attachments' ) . '</th>';

                if ( $args['display_date'] === 1 )
                    $html .= '<th class="attachment-date">' . __( 'Date added', 'download-attachments' ) . '</th>';

                if ( $args['display_user'] === 1 )
                    $html .= '<th class="attachment-user">' . __( 'Added by', 'download-attachments' ) . '</th>';

                if ( $args['display_size'] === 1 )
                    $html .= '<th class="attachment-size">' . __( 'File size', 'download-attachments' ) . '</th>';

                if ( $args['display_count'] === 1 )
                    $html .= '<th class="attachment-downloads">' . __( 'Downloads', 'download-attachments' ) . '</th>';

                $html .= '
				</thead><body>';
            }

            foreach ( $attachments as $attachment ) {
                if ( $attachment['attachment_exclude'] )
                    continue;

                if ( $args['use_desc_for_title'] === 1 && $attachment['attachment_description'] !== '' ) {
                    $title = apply_filters( 'da_display_attachment_title', $attachment['attachment_description'] );
                } else {
                    $title = apply_filters( 'da_display_attachment_title', $attachment['attachment_title'] );
                }

                // start single attachment style
                if ( $args['style'] === 'list' ) {
                    $html .= '<li class="attachment '  . $attachment['attachment_type'] . '">';
                } elseif ( $args['style'] === 'table' ) {
                    $html .= '<tr class="' . $attachment['attachment_type'] . '">';
                } else {
                    $html .= '<span class="' . $attachment['attachment_type'] . '">';
                }

                // index
                if ( $args['display_index'] === 1 )
                    $html .= '<' . $item_container . ' class="attachment-index">' . $i . '</' . $item_container . '> ';

                // title
                if ( $args['style'] === 'table' )
                    $html .= '<td class="attachment-title">';

                // type
                if ( $args['display_icon'] === 1 )
                    $html .= '<a target="__blank" href="' . ($options['pretty_urls'] === true ? home_url( '/' . $options['download_link'] . '/' . $attachment['attachment_id'] . '/' ) : DOWNLOAD_ATTACHMENTS_URL . '/includes/download.php?id=' . $attachment['attachment_id'] ) . '" class="attachment-link" title="' . esc_html( $title ) . '">' .
                        '<img class="attachment-icon" src="' . get_template_directory_uri() . '/img/icons/svg/'.$attachment['attachment_type'].'_icon.svg' . '" alt="' . $attachment['attachment_type'] . '" /> '
                        . '</a>';

                // link before
                if ( $args['link_before'] !== '' )
                    $html .= '<span class="attachment-link-before">' . $args['link_before'] . '</span>';

                // link
//                $html .= '<a target="__blank" href="' . ($options['pretty_urls'] === true ? home_url( '/' . $options['download_link'] . '/' . $attachment['attachment_id'] . '/' ) : DOWNLOAD_ATTACHMENTS_URL . '/includes/download.php?id=' . $attachment['attachment_id'] ) . '" class="attachment-link" title="' . esc_html( $title ) . '">' . $title . '</a>';

                // link after
                if ( $args['link_after'] !== '' )
                    $html .= '<span class="attachment-link-after">' . $args['link_after'] . '</span>';

                if ( $args['style'] === 'table' ) {
                    $html .= '</td>';
                } else {
                    $html .= '<br />';
                }

                if ( $args['style'] === 'table' && ($args['display_caption'] === 1 || ($args['display_description'] === 1 && $args['use_desc_for_title'] === 0)) )
                    $html .= '<td class="attachment-about">';

                // caption
                if ( $args['display_caption'] === 1 && $attachment['attachment_caption'] !== '' )
                    $html .= '<span class="attachment-caption">' . $attachment['attachment_caption'] . '</span><br />';

                // description
                if ( $args['display_description'] === 1 && $args['use_desc_for_title'] === 0 && $attachment['attachment_description'] !== '' )
                    $html .= '<span class="attachment-description">' . $attachment['attachment_description'] . '</span><br />';

                if ( $args['style'] === 'table' && ($args['display_caption'] === 1 || ($args['display_description'] === 1 && $args['use_desc_for_title'] === 0)) )
                    $html .= '</td>';

                // date
                if ( $args['display_date'] === 1 )
                    $html .= '<' . $item_container . ' class="attachment-date">' . ($args['style'] != 'table' ? '<span class="attachment-label">' . __( 'Date added', 'download-attachments' ) . ':</span> ' : '') . $attachment['attachment_date'] . '</' . $item_container . '> ';

                // user
                if ( $args['display_user'] === 1 )
                    $html .= '<' . $item_container . ' class="attachment-user">' . ($args['style'] != 'table' ? '<span class="attachment-label">' . __( 'Added by', 'download-attachments' ) . ':</span> ' : '') . $attachment['attachment_user_name'] . '</' . $item_container . '> ';

                // size
                if ( $args['display_size'] === 1 )
                    $html .= '<' . $item_container . ' class="attachment-size">' . ($args['style'] != 'table' ? '<span class="attachment-label">' . __( 'File size', 'download-attachments' ) . ':</span> ' : '') . $attachment['attachment_size'] . '</' . $item_container . '> ';

                // downloads
                if ( $args['display_count'] === 1 )
                    $html .= '<' . $item_container . ' class="attachment-downloads">' . ($args['style'] != 'table' ? '<span class="attachment-label">' . __( 'Downloads', 'download-attachments' ) . ':</span> ' : '') . $attachment['attachment_downloads'] . '</' . $item_container . '> ';

                // end single attahcment style
                if ( $args['style'] === 'list' ) {
                    $html .= '</li>';
                } elseif ( $args['style'] === 'table' ) {
                    $html .= '</tr>';
                } else {
                    $html .= '</span>';
                }

                $i ++;
            }

            if ( $args['style'] === 'list' ) {
                $html .= '</ul>';
            } elseif ( $args['style'] === 'table' ) {
                $html .= '</tbody></table>';
            }
        } elseif ( $args['display_empty'] === 1 ) {
            $html .= $args['display_option_none'];
        }

        $html .= $args['content_after'];

        if ( ! ($args['display_empty'] === 0 && $count === 0) && $args['container'] !== '' )
            $html .= '</' . $args['container'] . '>';



        if ( $args['echo'] === 1 ) {
            echo $html;
        } else {
            return $html;
        }


    }

    public function sim_download_attachment($args)
    {
        $defaults = array(
            'post_id'				 => 0,
            'container'				 => 'div',
            'container_class'		 => 'download-attachments',
            'container_id'			 => '',
            'style'					 => isset( Download_Attachments()->options['general']['display_style'] ) ? esc_attr( Download_Attachments()->options['general']['display_style'] ) : 'list',
            'link_before'			 => '',
            'link_after'			 => '',
            'display_index'			 => isset( $options['frontend_columns']['index'] ) ? (int) $options['frontend_columns']['index'] : 0,
            'display_user'			 => (int) Download_Attachments()->options['general']['frontend_columns']['author'],
            'display_icon'			 => (int) Download_Attachments()->options['general']['frontend_columns']['icon'],
            'display_count'			 => (int) Download_Attachments()->options['general']['frontend_columns']['downloads'],
            'display_size'			 => (int) Download_Attachments()->options['general']['frontend_columns']['size'],
            'display_date'			 => (int) Download_Attachments()->options['general']['frontend_columns']['date'],
            'display_caption'		 => (int) Download_Attachments()->options['general']['frontend_content']['caption'],
            'display_description'	 => (int) Download_Attachments()->options['general']['frontend_content']['description'],
            'display_empty'			 => 0,
            'display_option_none'	 => __( 'No attachments to download', 'download-attachments' ),
            'use_desc_for_title'	 => 0,
            'exclude'				 => '',
            'include'				 => '',
            'title'					 => __( 'Download Attachments', 'download-attachments' ),
            'title_container'		 => 'p',
            'title_class'			 => 'download-title',
            'orderby'				 => 'menu_order',
            'order'					 => 'asc',
            'echo'					 => 1
        );

        // we have to force return in shortcodes
        $args['echo'] = 0;

        if ( ! isset( $args['title'] ) ) {
            $args['title'] = '';

            if ( Download_Attachments()->options['general']['label'] !== '' )
                $args['title'] = Download_Attachments()->options['general']['label'];
        }

        $args = shortcode_atts( $defaults, $args );

        // reassign post id
        $post_id = (int) (empty( $args['post_id'] ) ? get_the_ID() : $args['post_id']);

        // unset from args
        unset( $args['post_id'] );

        return apply_filters('da_display_attachments', $post_id, $args );
    }
    
}

return new SIM_Functions();