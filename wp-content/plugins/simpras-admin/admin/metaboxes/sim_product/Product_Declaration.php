<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Product_Declaration{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_product_declaration';
        $this->title = __('Product declaration', 'sim');
        $this->context = 'side';
        $this->priority = 'default';
        $this->post_types = array('sim_product');

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $product = SIM_Product::getById($post_id);

        $product_declaration = $product->get_product_declaration();

        ?>

        <select name="product_declaration[]" id="" multiple style="width: 100%;">
            <?php foreach(SIM_Declaration::get_list() as $declaration): ?>
                <option value="<?php echo $declaration->id ?>" <?php echo in_array($declaration->id, $product_declaration) ? 'selected' : ''; ?>><?php echo $declaration->post->post_title; ?></option>
            <?php endforeach; ?>
        </select>

    <?php
    }

    function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {

            $product = SIM_Product::getById($post_id);

            if(isset($_POST['product_declaration']) && $_POST['product_declaration'])
            {
                $product->delete_meta_key('product_declaration');
                $product->product_declaration = $_POST['product_declaration'];
                $product->save();
            }

        }


    }


}

return new Product_Declaration();