<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2015-04-27
 * Time: 08:47
 */


class Node_Attachments{


    public $id;
    public $title;
    public $context;
    public $priority;
    public $post_types;

    public function __construct()
    {
        $this->id = 'sim_node_attachments';
        $this->title = __('Node Attachments', 'sim');
        $this->context = 'normal';
        $this->priority = 'default';
        $this->post_types = array('sim_node');

        add_action('save_post', array($this, 'meta_box_save'), 10, 1);

    }


    public function meta_box_inner($post)
    {

        $post_id = $post->ID;


        $product = SIM_Product::getById($post_id);


        $form = apply_filters('file_upload_form', $post_id, '_sim_node_pdf', __('Node pdf', 'sim'));
        $form .= apply_filters('file_upload_form', $post_id, '_sim_node_dwg', __('Node dwg', 'sim'));

        echo $form;

        ?>




    <?php
    }





    function meta_box_save($post_id)
    {

        //TODO implement native wordpress media upload

        if (in_array(get_post_type($post_id), $this->post_types)) {


            if(!empty($_FILES))
            {

                foreach($_FILES as $id => $form)
                {
                    // If the upload field has a file in it
                    if(isset($form) && ($form['size'] > 0)) {


                        // Get the type of the uploaded file. This is returned as "type/extension"
                        $arr_file_type = wp_check_filetype(basename($form['name']));


                        $uploaded_file_type = $arr_file_type['type'];

                        // Set an array containing a list of acceptable formats
                        $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png', 'application/pdf');

                        // If the uploaded file is the right format
                        if(in_array($uploaded_file_type, $allowed_file_types)) {

                            // Options array for the wp_handle_upload function. 'test_upload' => false
                            $upload_overrides = array( 'test_form' => false );

                            // Handle the upload using WP's wp_handle_upload function. Takes the posted file and an options array
                            $uploaded_file = wp_handle_upload($form, $upload_overrides);


                            // If the wp_handle_upload call returned a local path for the image
                            if(isset($uploaded_file['file'])) {

                                // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
                                $file_name_and_location = $uploaded_file['file'];

                                // Generate a title for the image that'll be used in the media library
                                $file_title_for_media_library = 'your title here';

                                $filename = strtolower(pathinfo($form['name'], PATHINFO_FILENAME));


                                // Set up options array to add this file as an attachment
                                $attachment = array(
                                    'post_mime_type' => $uploaded_file_type,
                                    'post_title' => addslashes($filename),
                                    'post_content' => '',
                                    'post_status' => 'inherit'
                                );

                                // Run the wp_insert_attachment function. This adds the file to the media library and generates the thumbnails. If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
                                $attach_id = wp_insert_attachment( $attachment, $file_name_and_location );
                                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                                $attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
                                wp_update_attachment_metadata($attach_id,  $attach_data);

                                // Before we update the post meta, trash any previously uploaded image for this post.
                                // You might not want this behavior, depending on how you're using the uploaded images.
                                $existing_uploaded_image = (int) get_post_meta($post_id,$id, true);
                                if(is_numeric($existing_uploaded_image)) {
                                    wp_delete_attachment($existing_uploaded_image);
                                }

                                // Now, update the post meta to associate the new image with the post

                                update_post_meta($post_id,$id,$attach_id);

                                // Set the feedback flag to false, since the upload was successful
                                $upload_feedback = false;


                            } else { // wp_handle_upload returned some kind of error. the return does contain error details, so you can use it here if you want.

                                $upload_feedback = 'There was a problem with your upload.';
                                update_post_meta($post_id,$id,$attach_id);

                            }

                        } else { // wrong file type

                            $upload_feedback = 'Please upload only image files (jpg, gif or png).';
                            update_post_meta($post_id,$id,$attach_id);

                        }

                    } else { // No file was passed

                        $upload_feedback = false;

                    }
                }
            }



            if(isset($_POST['delete_files']))
            {
                foreach($_POST['delete_files'] as $id_attach => $arr_meta)
                {
                    foreach($arr_meta as $name => $string)
                    {
                        wp_delete_attachment($id_attach, 1);
                        delete_post_meta($post_id, $name);
                    }
                }
            }

        }

    }


}

return new Node_Attachments();