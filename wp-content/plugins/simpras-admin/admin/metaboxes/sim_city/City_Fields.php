<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class City_Fields{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_city_fields';
        $this->title = __('City fields', 'sim');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_city');

        $this->upload_id = "pim_images";

        $this->main_fields = SIM_City::getMainFields();
        $this->shop_fields = SIM_City::getShopFileds();

        add_action('wp_ajax_generate_inputs_action', array($this, 'generate_inputs_action'), 0);

        add_action( 'admin_enqueue_scripts', array( $this, 'styles_and_scripts' ) );

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }



    /**
     * Add admin styles
     */
    public function styles_and_scripts()
    {

        global $post, $woocommerce, $wp_scripts;


        if(isset($post) && $post && !in_array($post->post_type, $this->post_types))// adjust this if-condition according to your theme/plugin
            return;

        wp_enqueue_script('plupload-all');

        wp_register_script('sim_popupformjs', SIM_RESOURCES_URL.'js/popup-form.js', array('jquery'));
        wp_enqueue_script('sim_popupformjs');


        wp_register_style('sim-myplupload-css', SIM_RESOURCES_URL.'css/myplupload.css');
        wp_enqueue_style('sim-myplupload-css');

    }


    public function generate_inputs_action()
    {
        if(isset($_POST['post_id']) && isset($_POST['num_shops']) && isset($_POST['start_from']))
        {
            echo $this->generateShopFields($_POST['post_id'], $_POST['num_shops'], $_POST['start_from']);
        }
        die();
    }



    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $city = SIM_City::getById($post_id);

        $city_main_info = $city->get_city_main_info();

        $city_shops = $city->get_shops();

        $num_shops = $city_shops ? count((array)$city_shops) : 0;


        ?>

        <script>
            (function ($) {
                $(document).ready(function(){

                    $('textarea').each(function(){

                        var html = $(this).html();
                        $(this).html(html.replace(/(?:rn|\r|\n)/g, '\n'));
                    });

                    $('.generate_fields').click(function(e){

                        var counters = $('.inputs');
                        var last_block = 0;

                        counters.each(function () {
                            last_block = $(this).data('counter');
                        });

                        e.preventDefault();
                        _ajax = $.ajax({
                            type: 'POST',
                            url: '/wp-admin/admin-ajax.php',
                            data: {'action': 'generate_inputs_action', post_id: <?php echo $post_id; ?>, num_shops: 1, start_from: ++last_block},
                            success: function(response){

                                $('.inputs_block').append(response);

                            }
                        });
                    });


                    $('body').on('click', '.remove_field', function(e){

                        var fields_counter = $(this).data('target');

                        console.log(fields_counter);
                        console.log($('.inputs').find("[data-counter='" + fields_counter + "']"));
                        $('div').find("[data-counter='" + fields_counter + "']").remove();

                        return false;
                    });


                    $('body').on('click', '.get_geocode', function(){

                        var current = this;
                        var lat_lng;
                        var single = $(this).data('single');

                        var ajax = $.ajax({
                            type: 'POST',
                            url: '/wp-admin/admin-ajax.php',
                            data: {'action': 'get_geocode_result', 'address_string': $(this).prev().val()},
                            success: function(res){

                                if(res)
                                {
                                    var response = JSON.parse(res);

                                    sudgestions = $.map(response, function(el){
                                        return el.formatted_address;
                                    });

                                    lat_lng = response.results[0].geometry.location;

                                }

                                if(single)
                                {
                                    $(current).parent().find('#_city_lat').val(lat_lng.lat);
                                    $(current).parent().find('#_city_lon').val(lat_lng.lng);
                                }else{
                                    $(current).parent().find('#_city_shop_lat').val(lat_lng.lat);
                                    $(current).parent().find('#_city_shop_lon').val(lat_lng.lng);
                                }

                            }
                        })

                        return false;

                    });

                    var current_input;
                    var sudgestions;

                    $('body').on('focus', '.geocode_address', function(){

                        current_input = $(this);
                        console.log(current_input);

                        $(this).autocomplete({


                            source: function (request, response) {

                                var ajax = $.ajax({
                                    type: 'POST',
                                    url: '/wp-admin/admin-ajax.php',
                                    data: {'action': 'get_geocode_result', 'address_string': current_input.val()},
                                    success: function(res){

                                        sudgestions = false;

                                        if(res)
                                        {
                                            var response = JSON.parse(res);
                                            sudgestions = $.map(response.results, function(el){
                                                return el.formatted_address;
                                            });


                                        }
                                    }
                                })

                                response(sudgestions);
                            }
                        });
                    });


                });
            })(jQuery);
        </script>


        <div class="inputs_block">
            <?php echo $this->generateMainFields($post_id, $num_shops, 1, $city_main_info ? $city_main_info : false); ?>
            <br>
            <hr>
            <?php echo $this->generateShopFields($post_id, $num_shops, 1, $city_shops ? $city_shops : false); ?>
        </div>

        <table>
            <tr>
                <th scope="row">
                    <label for="generate_fields">

                        <?php echo __('Add shop', 'sim'); ?>

                    </label>
                </th>

                <td>
                    <a href="#" class="generate_fields"><span class="dashicons dashicons-plus"></span></a>
                </td>
            </tr>
        </table>

    <?php
    }



    public function generateShopFields($post_id, $num_shops, $start_from = 1, $city_shops = false)
    {

        for($i = $start_from; $i < ($start_from + $num_shops); $i++)
        {

            echo "<div class='inputs' data-counter='".$i."'>";

            echo "<a href='#' class='remove_field' data-target='". $i ."'><span class='dashicons dashicons-trash'></span></a>";

            foreach($this->shop_fields as $id => $arr_field)
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

                    echo "<h1>{$arr_field['title']}</h1>";

                    //Create The Editor
                    $content = $city_shops->$i->$id;
                    wp_editor($content, 'city_shops['.$i.']['.$editor_id.']');

                    echo "<div style='clear:both; display:block;'></div>";

                }
                else if($arr_field['type'] == 'textarea'){

                    echo "<h1>{$arr_field['title']}</h1>";

                    //Create The Editor
                    $content = $city_shops->$i->$id;

                    echo "<textarea rows='10' name='city_shops[".$i."][".$editor_id."]' style='width:100%;'>".stripslashes($content)."</textarea>";

                    echo "<div style='clear:both; display:block;'></div>";

                }
                else if($arr_field['type'] == 'input'){

                    echo "<h1>{$arr_field['title']}</h1>";

                    //Create The Editor

                    
                    $content = $city_shops->$i->$id;

                    echo "<input type='text' id='".$editor_id."' name='city_shops[".$i."][".$editor_id."]' value='".stripslashes($content)."' style='width:100%;'>";

                    echo "<div style='clear:both; display:block;'></div>";

                }
                else if($arr_field['type'] == 'geocode'){

                    echo "<h1>{$arr_field['title']}</h1>";


                    ?>

                    <?php
                    $content = $city_shops->$i->$id;

                    echo "<input class='geocode_address' type='text' id='".$editor_id."' name='city_shops[".$i."][".$editor_id."]' value='".stripslashes($content)."' style='width:100%;'>";
                    echo "<a href='#' class='get_geocode'>Get coords</a>";

                    echo "<div style='clear:both; display:block;'></div>";

                }else if($arr_field['type'] == 'checkbox'){

                    echo "<h1>{$arr_field['title']}</h1>";


                    ?>

                    <?php
                    $content = $city_shops->$i->$id;

                    if($content)
                    {
                        echo "<input type='checkbox' id='".$editor_id."' name='city_shops[".$i."][".$editor_id."]' value='1' ". 'checked' ." >";
                    }else{

                        echo "<input type='checkbox' id='".$editor_id."' name='city_shops[".$i."][".$editor_id."]' value='1'>";
                    }

                    echo "<div style='clear:both; display:block;'></div>";
                }else if($arr_field['type'] == 'file'){

                    $attachments = SIM_City::getImages($city_shops->$i->pim_images, true) ? SIM_City::getImages($city_shops->$i->pim_images, true) : array();

                    debugvar($city_shops->$i);

                    $svalue = ""; // this will be initial value of the above form field. Image urls.

                    $multiple = true; // allow multiple files upload

                    $width = null; // If you want to automatically resize all uploaded images then provide width here (in pixels)

                    $height = null; // If you want to automatically resize all uploaded images then provide height here (in pixels)

                    ?>

                    <div class="row">
                        <label>Upload Images</label>
                        <?php wp_nonce_field('pim-form-save', 'pim-save-form-nonce'); ?>
                        <input type="hidden"  id="<?php echo 'pim_upload_id'; ?>" value="<?php echo $this->upload_id; ?>" class="img-id" />
                        <input type="hidden"  id="<?php echo 'pim_upload_multiple'; ?>" value="0" class="img-id" />
                        <input type="hidden" name="<?php echo "city_shops[".$i."][".$editor_id."]"; ?>" id="<?php echo $this->upload_id; ?>" value="<?php echo $svalue; ?>" class="img-id" data-target="<?php echo "city_shops[".$i."][".$this->upload_id."]"; ?>"/>
                        <input type="hidden" name="<?php echo $this->upload_id; ?>_base" id="<?php echo $this->upload_id; ?>_base" value="<?php echo $svalue; ?>" class="img-id" />
                        <div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $this->upload_id; ?>plupload-upload-ui">
                            <input id="<?php echo $this->upload_id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button modal-upload-btn" data-target="<?php echo "city_shops[".$i."][".$this->upload_id."]"; ?>" />
                            <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($this->upload_id . 'pluploadan'); ?>"></span>
                            <?php if ($width && $height): ?>
                                <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
                                <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
                            <?php endif; ?>
                            <div class="filelist"></div>
                        </div>
                        <div class="images plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $this->upload_id; ?>plupload-thumbs">
                        </div>
                        <div class="clear"></div>
                        <div class="images plupload-attach" id="sortable" data-target="<?php echo "city_shops[".$i."][".$this->upload_id."]"; ?>">
                            <?php foreach($attachments as $upload_id => $attachment): ?>

                                <?php $url = apply_filters('pim_image_url', $upload_id, 'thumbnail'); ?>
                                <div class="thumb" id="attachment_<?php echo $upload_id; ?>">
                                    <img src="<?php echo $url; ?>" alt="">
                                    <input type="hidden" name="<?php echo "city_shops[".$i."][";?>uploaded_img][]" class="images_order" value="<?php echo $upload_id; ?>">
                                    <a href="#" data-attachment-edit="<?php echo $upload_id; ?>" class="delete_attachment modal-edit-btn">
                                        <span class="dashicons dashicons-edit"></span>
                                    </a>
                                    <a href="#" data-attachment-remove="<?php echo $upload_id; ?>" class="delete_attachment modal-remove-btn" style="float: right;">
                                        <span class="dashicons dashicons-trash"></span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php

                }

            }

            echo "</div>";
        }
    }



    public function generateMainFields($post_id, $num_shops, $start_from = 0, $city = false)
    {

        foreach($this->main_fields as $id => $arr_field)
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

                echo "<h1>{$arr_field['title']}</h1>";

                //Create The Editor
                $content = $city->$id;
                wp_editor($content, 'city_main_info');

                echo "<div style='clear:both; display:block;'></div>";

            }
            else if($arr_field['type'] == 'textarea'){

                echo "<h1>{$arr_field['title']}</h1>";

                //Create The Editor
                $content = $city->$id;

                echo "<textarea cols='30' name='city_main_info[".$editor_id."]' style='width:100%;'>".stripslashes($content)."</textarea>";

                echo "<div style='clear:both; display:block;'></div>";

            }
            else if($arr_field['type'] == 'input'){

                echo "<h1>{$arr_field['title']}</h1>";

                //Create The Editor
                $content = $city->$id;

                echo "<input type='text' id='".$editor_id."' name='city_main_info[".$editor_id."]' value='".stripslashes($content)."' style='width:100%;'>";

                echo "<div style='clear:both; display:block;'></div>";

            }
            else if($arr_field['type'] == 'geocode'){

                echo "<h1>{$arr_field['title']}</h1>";


                ?>

                <?php
                $content = $city->$id;

                echo "<input class='geocode_address' type='text' name='city_main_info[".$editor_id."]' value='".stripslashes($content)."' style='width:100%;'>";
                echo "<a href='#' class='get_geocode' data-single='1'>Get coords</a>";

                echo "<div style='clear:both; display:block;'></div>";

            }

        }
    }



    function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {


            $city = SIM_City::getById($post_id);

            if(isset($_POST['city_main_info']) && $_POST['city_main_info'])
            {
                $city->city_main_info = SIM_Helper::mysql_escape(serialize($_POST['city_main_info']));
                $city->save();

            }

            if(isset($_POST['city_shops']) && $_POST['city_shops'])
            {

                array_walk($_POST['city_shops'], function(&$value, $key){
                    $value = SIM_Helper::mysql_escape($value);
                });


                $city->delete_meta_key('city_shops');

                $city->city_shops = SIM_Helper::mysql_escape(serialize($_POST['city_shops']));

                $city->save();


            }

        }


    }


}

return new City_Fields();