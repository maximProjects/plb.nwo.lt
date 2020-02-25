<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-05-22
 * Time: 15:07
 */


class Employee_Title{

    private $post_type;

    public function __construct()
    {

        $this->post_type = 'sim_employee';

        add_action('manage_'.$this->post_type.'_posts_columns', array($this, 'ch_manage_project_task_posts_columns'), 10, 1);
        add_action( 'manage_'.$this->post_type.'_posts_custom_column', array($this,'ch_manage_project_task_posts_custom_column'), 10, 2 );
    }


    public function ch_manage_project_task_posts_columns($defaults)
    {
        unset($defaults['title']);
        $defaults['a_title'] = __('Employee', 'sca');

        ksort($defaults, SORT_STRING);

        return $defaults;
    }


    public function ch_manage_project_task_posts_custom_column($column_name, $post_id)
    {

        if ($column_name == 'a_title') {

            $employee = SIM_Employee::getById($post_id);

            $edit_url = get_edit_post_link($post_id);

            echo "<a href='".$edit_url."'>".$employee->employee_name . ' ' . $employee->employee_surname. '</a><br>';
        }
    }

}

return new Employee_Title();