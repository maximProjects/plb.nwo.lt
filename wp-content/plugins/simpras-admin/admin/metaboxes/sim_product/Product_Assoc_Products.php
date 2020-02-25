<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Product_Assoc_Products{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_product_assoc_products';
        $this->title = __('Product associated products', 'sim');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_product');

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $sim_product = SIM_Product::getById($post_id);

        $product_assoc_products = $sim_product->get_product_assoc_products();

        echo '<h1>'.__('Product associated products', 'sim').'</h1><hr>';
        ?>


        <select name="product_assoc_products[]" id="" multiple style="width: 100%; height: 250px;">
            <?php foreach(SIM_Product::get_list() as $product): ?>
                <?php if($product->id !== $sim_product->id): ?>
                    <option value="<?php echo $product->id ?>" <?php echo in_array($product->id, $product_assoc_products) ? 'selected' : ''; ?>><?php echo $product->post->post_title; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

    <?php
    }

    function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {

            $product = SIM_Product::getById($post_id);

            if(isset($_POST['product_assoc_products']) && $_POST['product_assoc_products'])
            {
                $product->delete_meta_key('product_assoc_products');

                $product->product_assoc_products = $_POST['product_assoc_products'];
                $product->save();
            }

        }


    }


}

return new Product_Assoc_Products();