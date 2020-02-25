<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Declaration_Parameters{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_declaration_parameters';
        $this->title = __('Declaration parameters', 'sim');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_declaration');

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $declaration = SIM_Declaration::getById($post_id);

        ?>

        <table>
            <tr>
                <td><?php echo __('Strength', 'sim') ?></td>
                <td><input type="text" name="declaration_parameters[declaration_strength]" value="<?php echo $declaration->declaration_strength; ?>"></td>
            </tr>
        </table>


    <?php
    }

    public function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {


            $declaration = SIM_Declaration::getById($post_id);

            if(isset($_POST['declaration_parameters']) && !empty($_POST['declaration_parameters']))
            {
                foreach($_POST['declaration_parameters'] as $id => $value)
                {
                    switch ($id){
                        case 'declaration_strength':

                            $declaration->$id = number_format($value);

                            break;

                        default:
                            $declaration->$id = $value;
                    }
                }

                $declaration->save();

            }else{

            }

        }


    }


}

return new Declaration_Parameters();