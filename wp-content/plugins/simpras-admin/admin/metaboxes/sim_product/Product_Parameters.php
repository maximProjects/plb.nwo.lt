<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Product_Parameters{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_product_parameters';
        $this->title = __('Product parameters', 'sim');
        $this->context = 'side';
        $this->priority = 'default';
        $this->post_types = array('sim_product');

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $product = SIM_Product::getById($post_id);

        ?>

        <table>
            <tr>
                <td><?php echo __('Price', 'sim') ?></td>
                <td><input type="text" name="product_main_parameters[product_price]" value="<?php echo $product->product_price; ?>"> Eur</td>
            </tr>
            <tr>
                <td><?php echo __('Hide price', 'sim') ?></td>
                <td><input type="checkbox" name="product_main_parameters[hide_product_price]" value="1" <?php echo $product->hide_product_price? 'checked' : ''; ?>></td>
            </tr>
            <tr>
                <td><?php echo __('Units', 'sim') ?></td>
                <td>
                    <select name="product_main_parameters[product_units]">
                        <option value="m3" <?php echo $product->product_units == 'm3' ? 'selected' : ''; ?>><?php echo __('m3', 'sim'); ?></option>
                        <option value="unit" <?php echo $product->product_units == 'unit' ? 'selected' : ''; ?>><?php echo __('unit', 'sim'); ?></option>
                    </select>
                </td>
            </tr>
        </table>


    <?php
    }

    function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {


            $product = SIM_Product::getById($post_id);

            if(isset($_POST['product_main_parameters']) && !empty($_POST['product_main_parameters']))
            {

                foreach($_POST['product_main_parameters'] as $id => $value)
                {
                    switch ($id){
                        case 'product_price':

                            if($value)
                            {
                                $product->$id = number_format($value, 2);

                            }else{
                                $product->delete_meta_key('product_price');
                            }

                            break;

                        default:
                            $product->$id = $value;
                    }
                }

                if(!isset($_POST['product_main_parameters']['hide_product_price']))
                {
                    $product->delete_meta_key('hide_product_price');
                }

                $product->save();

            }else{
//                $product->product_url = '';
//                $product->save();

            }

        }


    }


}

return new Product_Parameters();