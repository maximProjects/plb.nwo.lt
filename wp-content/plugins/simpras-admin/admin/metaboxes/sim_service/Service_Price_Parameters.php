<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Service_Price_Parameters{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_service_parameters';
        $this->title = __('Service price parameters', 'sim');
        $this->context = 'side';
        $this->priority = 'default';
        $this->post_types = array('sim_service');

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $service = SIM_Service::getById($post_id);

        ?>

        <table>
            <tr>
                <td><?php echo __('Hide price', 'sim') ?></td>
                <td><input type="checkbox" name="service_main_parameters[service_hide_price]" value="1" <?php echo $service->service_hide_price? 'checked' : ''; ?>></td>
            </tr>
        </table>


    <?php
    }

    function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {


            $service = SIM_Service::getById($post_id);

            if(isset($_POST['service_main_parameters']) && !empty($_POST['service_main_parameters']))
            {

                foreach($_POST['service_main_parameters'] as $id => $value)
                {
                    if(in_array($id, array('service_price', 'service_price_registered')))
                    {
                        if($value)
                        {
                            $service->$id = number_format($value, 2);

                        }else{
                            $service->delete_meta_key('service_price');
                        }
                    }else{
                        $service->$id = $value;
                    }
                }




            }else{

                if(!isset($_POST['service_main_parameters']['service_hide_price']))
                {
                    $service->delete_meta_key('service_hide_price');
                }

            }

            $service->save();
        }


    }


}

return new Service_Price_Parameters();