<?php
/**
 * Created by PhpStorm.
 * User: vadimk
 * Date: 2014-11-21
 * Time: 10:57
 */

class SIM_Filter{

	public function __construct() {

		add_action( 'admin_init', array( $this, 'include_filter_handlers' ) );

	}
    

	/**
	 * Include filter handlers
	 */
	public function include_filter_handlers() {

		include('sim_post_type/FunctionalityFilter.php');
	}


}

return new SIM_Filter();