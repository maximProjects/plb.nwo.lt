<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Node_Parameters{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_node_parameters';
        $this->title = __('Node parameters', 'sim');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_node');

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $node = SIM_Node::getById($post_id);

        ?>

        <table>
            <tr>
                <td><?php echo __('Strength', 'sim') ?></td>
                <td><input type="text" name="node_parameters[node_strength]" value="<?php echo $node->node_strength; ?>"></td>
            </tr>
        </table>


    <?php
    }

    public function meta_box_save($post_id)
    {

        if (in_array(get_post_type($post_id), $this->post_types)) {


            $node = SIM_Node::getById($post_id);

            if(isset($_POST['node_parameters']) && !empty($_POST['node_parameters']))
            {
                foreach($_POST['node_parameters'] as $id => $value)
                {
                    switch ($id){
                        case 'node_strength':

                            $node->$id = number_format($value);

                            break;

                        default:
                            $node->$id = $value;
                    }
                }

                $node->save();

            }else{

            }

        }


    }


}

return new Node_Parameters();