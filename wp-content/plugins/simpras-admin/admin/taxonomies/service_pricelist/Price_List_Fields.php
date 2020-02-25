<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 2016-10-25
 * Time: 11:01
 */


class Price_List_Fields
{

    private $taxonomies = array('sim_service_pricelist');

    private $arr_fields;

    public function __construct(){


        // REGISTER TERM META
        add_action( 'init', array($this, '___register_term_meta_url') );

        // ADD FIELD TO CATEGORY TERM PAGE
        add_action( 'category_add_form_fields', array($this, '___add_form_field_term_meta_url') );

        foreach($this->taxonomies as $taxonomy)
        {

            $this->arr_fields = array(
                __('Service price', 'sim') => 'service_pricelist_price',
                __('Service price registered', 'sim') => 'service_pricelist_price_registered',
            );


            // add our image field to the taxonomy term forms
            add_action( $taxonomy . '_add_form_fields', array( $this, '___add_form_field_term_meta_url' ) );
            add_action( $taxonomy . '_edit_form_fields', array( $this, '___add_form_field_term_meta_url' ) );

            // hook into term administration actions
            add_action( 'create_' . $taxonomy, array( $this, 'taxonomy_term_form_save' ) );
            add_action( 'edit_' . $taxonomy, array( $this, 'taxonomy_term_form_save' ) );


        }
        

        // ADD FIELD TO CATEGORY EDIT PAGE
        add_action( 'category_edit_form_fields', array($this, '___edit_form_field_arr_fields') );

    }



    public function ___register_term_meta_url(){

        foreach($this->arr_fields as $name => $field)
        {
            register_meta( 'term', $field, array($this, '___sanitize_field'));
        }
    }



    public function ___sanitize_field ( $value ) {
        return sanitize_text_field ($value);
    }



    public function ___edit_form_field_arr_fields( $term ) {

    ?>

        <?php foreach($this->arr_fields as $name => $key): ?>
            <?php $value  = get_term_meta( $term->term_id, $key, true ); ?>
            <?php if ( ! $value ) $value = ""; ?>

            <tr class="form-field category-block-url-wrap">
                <th scope="row"><label for="category-block-url"><?php $name; ?></label></th>
                <td>
                    <?php wp_nonce_field( basename( __FILE__ ), 'term_meta_url_nonce' ); ?>
                    <input type="text" name="<?php echo $key; ?>" id="<?php echo str_replace('_', '-', $key) ?>" value="<?php echo esc_attr( $value ); ?>" class="<?php echo str_replace('_', '-', $key) ?>"  />
                </td>
            </tr>

        <?php endforeach; ?>

    <?php }


    /**
     * Add a new form field for the edit taxonomy term form
     *
     * @param $term | object | the term object
     */
    function ___add_form_field_term_meta_url( $term ){


        // ensure we have our term_image data
        if ( is_a($term, WP_Term::class) ){

        
        ?>

            <?php foreach($this->arr_fields as $name => $key): ?>

                <?php $term_meta = get_term_meta( $term->term_id, $key, true ); ?>

                <tr class="form-field">
                    <th scope="row" valign="top"><label><?php echo $name; ?></label></th>
                    <td>
                        <input type="text" name="<?php echo $key; ?>" id="<?php echo str_replace('_', '-', $key) ?>" value="<?php echo $term_meta; ?>" class="<?php echo str_replace('_', '-', $key) ?>" />
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php }
    }




    /**
     * Handle saving our custom taxonomy term meta
     *
     * @param $term_id
     */
    function taxonomy_term_form_save( $term_id ) {


        foreach ($this->arr_fields as $name => $key) {

            // our requirements for saving:
            if (
//                // nonce was submitted and is verified
//                isset( $_POST['_wpnonce'] ) &&
//                wp_verify_nonce( $_POST['_wpnonce'], 'taxonomy-term-image-form-save' ) &&

                // taxonomy data and taxonomy_term_image data was submitted
                isset( $_POST['taxonomy'] ) &&
                isset( $_POST[$key] ) &&

                // the taxonomy submitted is one of the taxonomies we are dealing with
                in_array( $_POST['taxonomy'], $this->taxonomies )
            )
            {

                // get the term_meta and assign it the old_image
                $old_image = get_term_meta( $term_id, $key, true );

                // sanitize the data and save it as the new_image
                $new_value = $_POST[$key];

                // if an image was removed, delete the meta data
                if ( $old_image && '' === $new_value ) {
                    delete_term_meta( $term_id, $key );
                }
                // if the new image is not the same as the old update the term_meta
                else if ( $old_image !== $new_value ) {

                    if(in_array($key, array('service_pricelist_price', 'service_pricelist_price_registered')))
                    {
                        $new_value = number_format($new_value, 2);
                    }
//                    $new_value = apply_filters('url_format', $new_value);

                    update_term_meta( $term_id, $key, $new_value );
                }

            }

        }

    }
}

new Price_List_Fields();