<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class News_Fields{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'SIM_News_fields';
        $this->title = __('Video fields', 'sim');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_news', 'sim_video');

        $this->shop_fields = SIM_News::get_video_fields();

        add_action('wp_ajax_generate_article_inputs_action', array($this, 'generate_article_inputs_action'), 0);

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }

    public function generate_article_inputs_action()
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


        $city = SIM_News::getById($post_id);


        $article_videos = json_decode($city->get_article_videos());

        $num_shops = $article_videos ? count($article_videos) : 0;


//        debugvar(delete_post_meta($post_id, '_SIM_News_main_info'));
//        debugvar(delete_post_meta($post_id, '_sim_article_videos'));

        ?>

        <script>
            (function ($) {
                $(document).ready(function(){

                    $('textarea').each(function(){

                        var html = $(this).html();
                        $(this).html(html.replace(/(?:rn|\r|\n)/g, '\n'));
                    });

                    $('.generate_arcicle_fields').click(function(e){

                        var counters = $('.inputs');
                        var last_block = 0;

                        counters.each(function () {
                            last_block = $(this).data('counter');
                        });

                        e.preventDefault();
                        _ajax = $.ajax({
                            type: 'POST',
                            url: '/wp-admin/admin-ajax.php',
                            data: {'action': 'generate_article_inputs_action', post_id: <?php echo $post_id; ?>, num_shops: 1, start_from: ++last_block},
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

                });
            })(jQuery);
        </script>


        <div class="inputs_block">
            <br>
            <hr>
            <?php echo $this->generateShopFields($post_id, $num_shops, 1, $article_videos ? $article_videos : false); ?>
        </div>

        <table>
            <tr>
                <th scope="row">
                    <label for="generate_arcicle_fields">

                        <?php echo __('Add video', 'sim'); ?>

                    </label>
                </th>

                <td>
                    <a href="#" class="generate_arcicle_fields"><span class="dashicons dashicons-plus"></span></a>
                </td>
            </tr>
        </table>

    <?php
    }



    public function generateShopFields($post_id, $num_shops, $start_from = 1, $article_videos = false)
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
                    $content = $article_videos->$i->$id;
                    wp_editor($content, 'article_videos['.$i.']['.$editor_id.']');

                    echo "<div style='clear:both; display:block;'></div>";

                }
                else if($arr_field['type'] == 'textarea'){

                    echo "<h1>{$arr_field['title']}</h1>";

                    //Create The Editor
                    $content = $article_videos->$i->$id;

                    echo "<textarea rows='10' name='article_videos[".$i."][".$editor_id."]' style='width:100%;'>".$content."</textarea>";

                    echo "<div style='clear:both; display:block;'></div>";

                }
                else if($arr_field['type'] == 'input'){

                    echo "<h1>{$arr_field['title']}</h1>";

                    //Create The Editor


                    $content = $article_videos->$i->$id;

                    echo "<input type='text' name='article_videos[".$i."][".$editor_id."]' value='".$content."' style='width:100%;'>";

                    echo "<div style='clear:both; display:block;'></div>";

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

                echo "<textarea cols='30' name='city_main_info[".$editor_id."]' style='width:100%;'>".$content."</textarea>";

                echo "<div style='clear:both; display:block;'></div>";

            }
            else if($arr_field['type'] == 'input'){

                echo "<h1>{$arr_field['title']}</h1>";

                //Create The Editor
                $content = $city->$id;

                echo "<input type='text' name='city_main_info[".$editor_id."]' value='".$content."' style='width:100%;'>";

                echo "<div style='clear:both; display:block;'></div>";

            }

        }
    }



    function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {


            $city = SIM_News::getById($post_id);


            if(isset($_POST['article_videos']) && $_POST['article_videos'])
            {

                $city->article_videos = json_encode($_POST['article_videos']);
                $city->save();


            }

        }


    }


}

return new News_Fields();