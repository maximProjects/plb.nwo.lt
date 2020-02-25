<?php
/**
 * Created by PhpStorm.
 * User: vadimk
 * Date: 2014-11-21
 * Time: 10:57
 */


class SIM_Column{

    public function __construct() {

        add_action( 'admin_init', array( $this, 'include_columns_handlers' ) );

    }


    /**
     * Include meta box handlers
     */
    public function include_columns_handlers() {

//        include('sim_product/Declarations.php');
        include('sim_product/Price.php');
//        include('sim_product/SecurityPdf.php');
//        include('sim_employee/Employee_Title.php');

    }


}

return new SIM_Column();