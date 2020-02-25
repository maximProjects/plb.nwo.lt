<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Product_Fields{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_product_fields';
        $this->title = __('Product fields', 'sim');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_product');

        $this->product_tabs = SIM_Product::get_tabs();

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $product = SIM_Product::getById($post_id);


        ?>

        <table>
            <?php foreach(SIM_Product::$parameters as $group => $arrfields): ?>
                <tr>
                    <th><?php echo $arrfields['title'] ?></th>
                </tr>
                <?php foreach($arrfields['fields'] as $id_field => $name): ?>
                    <tr>
                        <td><?php echo $name; ?>:</td>
                        <td><input type="text" name="product_parameters[<?php echo $id_field ?>]" value="<?php echo $product->$id_field; ?>"></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>

        <?php echo $this->generateProductFields($post_id); ?>

    <?php
    }



    public function generateProductFields($post_id)
    {
        $product = SIM_Product::getById($post_id);

        foreach($this->product_tabs as $id => $arr_field)
        {
            $meta_box_id = $id;
            $editor_id = $id;
            $meta_key = $id;


            if($arr_field['type'] == 'wyswyg')
            {
                //Add CSS & jQuery goodness to make this work like the original WYSIWYG
                echo "
                <style type='text/css'>
                        #$meta_box_id #edButtonHTML, #$meta_box_id #edButtonPreview {background-color: #F1F1F1; border-color: #DFDFDF #DFDFDF #CCC; color: #999;}
                        #$editor_id{width:100%;}
                        #$meta_box_id #editorcontainer{background:#fff !important;}

                        .percentage-container{
                            display: none;
                        }
                </style>

                <script type='text/javascript'>
                        jQuery(function($){
                                $('#$meta_box_id #editor-toolbar > a').click(function(){
                                        $('#$meta_box_id #editor-toolbar > a').removeClass('active');
                                        $(this).addClass('active');
                                });

                                if($('#$meta_box_id #edButtonPreview').hasClass('active')){
                                        $('#$meta_box_id #ed_toolbar').hide();
                                }

                                $('#$meta_box_id #edButtonPreview').click(function(){
                                        $('#$meta_box_id #ed_toolbar').hide();
                                });

                                $('#$meta_box_id #edButtonHTML').click(function(){
                                        $('#$meta_box_id #ed_toolbar').show();
                                });
				//Tell the uploader to insert content into the correct WYSIWYG editor
				$('#media-buttons a').bind('click', function(){
					var customEditor = $(this).parents('#$meta_box_id');
					if(customEditor.length > 0){
						edCanvas = document.getElementById('$editor_id');
					}
					else{
						edCanvas = document.getElementById('content');
					}
				});
                        });
                </script>
        ";

                echo "<h1>".__($arr_field['title'], 'sim')."</h1>";

                //Create The Editor
                $content = $product->$id;
                wp_editor($content, 'product_tabs['.$editor_id.']');

                echo "<div style='clear:both; display:block;'></div>";

            }
            else if($arr_field['type'] == 'textarea'){

                echo "<h1>".__($arr_field['title'], 'sim')."</h1>";

                //Create The Editor

                $content = $product->$id;

                echo "<textarea rows='10' name='product_tabs[".$editor_id."]' style='width:100%;'>".$content."</textarea>";

                echo "<div style='clear:both; display:block;'></div>";

            }
            else if($arr_field['type'] == 'input'){

                echo "<h1>".__($arr_field['title'], 'sim')."</h1>";;

                //Create The Editor


                $content = $product->$id;

                echo "<input type='text' name='product_tabs[".$editor_id."]' value='".$content."' style='width:100%;'>";

                echo "<div style='clear:both; display:block;'></div>";

            }

        }
    }



    function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {


            $product = SIM_Product::getById($post_id);


            $has_params = false;
            if(isset($_POST['product_parameters']) && !empty($_POST['product_parameters']))
            {


                foreach($_POST['product_parameters'] as $field => $value)
                {
                    if($value)
                    {
                        if(!$has_params)
                        {
                            $product->product_has_parameters = true;
                            $has_params = true;
                        }
                        $product->$field = $value;
                    }else{

                        $product->delete_meta_key($field);
                    }
                }
                if(!$has_params)
                {
                    $product->delete_meta_key('product_has_parameters');
                }

            }

            if(isset($_POST['product_tabs']) && !empty($_POST['product_tabs']))
            {

                $has_tabs = false;
                foreach($_POST['product_tabs'] as $field => $value)
                {
                    if($value)
                    {
                        if(!$has_tabs)
                        {
                            $product->product_has_tabs = true;
                            $has_tabs = true;
                        }
                        $product->$field = $value;
                    }else{

                        $product->delete_meta_key($field);
                    }
                }
                if(!$has_tabs)
                {
                    $product->delete_meta_key('product_has_tabs');
                }

            }

            $product->save();

            $products = apply_filters('post_type_list', 'sim_product');

            foreach($products as $product)
            {
                $pr = SIM_Product::getById($product->ID);
                $pr->save();
            }

        }


    }


}

return new Product_Fields();