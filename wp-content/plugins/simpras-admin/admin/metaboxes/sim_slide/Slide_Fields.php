<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Slide_Fields{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_slide_fields';
        $this->title = __('Slide fields', 'sca');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_slide');

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        ?>

        <div class="row">
            <div>
                <label for="_ch_project_url">
                    <?php echo __('Slide url', 'sca'); ?>
                </label>
                <input type="text" name="_sim_slide_url" value="<?php echo get_post_meta($post_id, '_sim_slide_url', true); ?>" style="width: 250px;">
            </div>
        </div>


        <?php
    }

    function meta_box_save($post_id)
    {
        if (in_array(get_post_type($post_id), $this->post_types)) {


            $slide = SIM_Slide::getById($post_id);
            if(isset($_POST['_sim_slide_url']) && !empty($_POST['_sim_slide_url']))
            {
                $slide->slide_url = apply_filters('url_format', $_POST['_sim_slide_url']);
                $slide->save();
            }else{
                $slide->slide_url = '';
                $slide->save();
            }

        }

    }


}

return new Slide_Fields();