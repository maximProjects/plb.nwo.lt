<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-23
 * Time: 13:46
 */


class SIM_Ajax_Functions{


    public function __construct()
    {

        //Svg map
        add_filter('wp_ajax_nopriv_map_region_info', array($this, 'sim_map_region_info'), 0, 0);
        add_filter('wp_ajax_map_region_info', array($this, 'sim_map_region_info'), 0, 0);

        add_filter('wp_ajax_nopriv_map_regions_info', array($this, 'sim_map_regions_info'), 0, 0);
        add_filter('wp_ajax_map_regions_info', array($this, 'sim_map_regions_info'), 0, 0);

        add_filter('wp_ajax_nopriv_cities_info', array($this, 'sim_cities_info'), 0, 0);
        add_filter('wp_ajax_cities_info', array($this, 'sim_cities_info'), 0, 0);

        add_filter('wp_ajax_nopriv_get_node_elements', array($this, 'sim_node_elements'), 0, 0);
        add_filter('wp_ajax_get_node_elements', array($this, 'sim_node_elements'), 0, 0);

        add_filter('wp_ajax_nopriv_get_geocode_result', array($this, 'sim_get_geocode_result'), 0, 0);
        add_filter('wp_ajax_get_geocode_result', array($this, 'sim_get_geocode_result'), 0, 0);


    }



    //Svg map

    /**
     * Get single region info
     */
    public function sim_map_region_info()
    {
        $country_code = isset($_POST['country_code']) ? $_POST['country_code'] : false;
        $path_id = isset($_POST['path_id']) ? $_POST['path_id'] : false;

        if($path_id)
        {
            $employees = SIM_Employee::getByRegionId($path_id);

            $ret_arr = '';

            foreach ($employees as $employee) {
                $employee = SIM_Employee::getById($employee->ID);
                $ret_arr = array(
                    'employee_name' => $employee->employee_name,
                    'employee_surname' => $employee->employee_surname,
                    'employee_email' => $employee->employee_email,
                    'employee_position' => $employee->get_position(),
                    'employee_image' => apply_filters('post_image_url', $employee->id, 'full'),
                );
            }

            echo json_encode($ret_arr);
        }

        die();
    }


    /**
     * Get all regions info
     */
    public function sim_map_regions_info()
    {
        $path_ids = isset($_POST['path_ids']) ? $_POST['path_ids'] : false;

        if($path_ids)
        {
            $ret_arr = '';

            foreach($path_ids as $path_id)
            {
                $employees = SIM_Employee::getByRegionId($path_id);

                foreach ($employees as $employee) {
                    $employee = SIM_Employee::getById($employee->ID);
//                    debugvar($employee);
                    $ret_arr[$path_id] = array(
                        'company_name' => ot_custom_get_option('company_name') ? ot_custom_get_option('company_name') : '',
                        'employee_name' => $employee->employee_name,
                        'employee_surname' => $employee->employee_surname,
                        'employee_email' => sprintf("%s %s", __('Email: ', 'sim'), $employee->employee_email),
                        'employee_phone' => sprintf("%s %s", __('Phone nb.: ', 'sim'), $employee->employee_phone),
                        'employee_position' => $employee->get_position(),
                        'employee_image' => apply_filters('post_image_url', $employee->id, 'full'),
                    );
                }
            }

            echo json_encode($ret_arr);
        }

        die();
    }


    /**
     * Get all cities info
     */
    public function sim_cities_info()
    {
        $ret_arr = '';

        $cities = SIM_City::get_list();


        $countries = get_terms('sim_city_country');

        foreach($countries as $country)
        {
            $cities = apply_filters('posts_by_term', SIM_City::$post_type, 'sim_city_country', $country);


            foreach ($cities as $city) {

                $city = SIM_City::getById($city->ID);

                $city_main_info = $city->get_city_main_info();
                $city_shops = $city->get_shops();

                if(!isset($ret_arr['countries'][$country->name])){

                    $ret_arr['countries'][$country->name]['title'] = $country->name;
                }

                $ret_arr['countries'][$country->name]['cities'][$city->post->post_title] = array(
                    'city_name' => $city->post->post_title,
                    'city_' => $city->post->post_title,
                    'city_lat' => $city_main_info->_city_lat,
                    'city_lon' => $city_main_info->_city_lon,
                    'city_shops' => $city_shops,
                );
            }
//            sort($ret_arr['countries'][$country->name]['cities']);

        }


//        debugvar($ret_arr);
//        exit;

        echo json_encode($ret_arr);

        die();
    }



    /**
     * Get all node elements
     */
    public function sim_node_elements()
    {
        $term_id = isset($_POST['term_id']) ? $_POST['term_id'] : false;

        if(!$term_id)
            die();

        $ret_arr = array();

        $term = get_term($term_id);

        $node_elements = apply_filters('posts_by_term', SIM_Node::$post_type, 'sim_node_category', $term);

        if(!$node_elements)
            die();

        $ret_arr['node']['node_title'] = $term->name;
        foreach ($node_elements as $element) {

            $node = SIM_Node::getById($element->ID);

            $ret_arr['node']['node_elements'][] = array(
                'element_name' => $element->post_title,
                'node_pdf' => wp_get_attachment_url($node->get_pdf_attachment()),
                'node_dwg' => wp_get_attachment_url($node->get_dwg_attachment()),
            );
        }

        echo json_encode($ret_arr);

        die();
    }


    function sim_get_geocode_result()
    {
        $address_string = isset($_POST['address_string']) ? $_POST['address_string'] : false;

        $ret_arr = array();


        $Geocoder = new GoogleMapsGeocoder();

        $Geocoder->setLanguage('lt');

        $Geocoder->setAddress($address_string);

        $response = $Geocoder->geocode();


        array_push($ret_arr, $address_string);

        echo json_encode($response);

        die();
    }
}

return new SIM_Ajax_Functions();