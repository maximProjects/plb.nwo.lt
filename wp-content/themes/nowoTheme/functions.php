<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */
const nowotheme_DOMAIN = 'nowotheme';

include_once('inc/wp_static_menu_walker.php');
include_once('inc/wp_static_menu_walker_mobile.php');
include_once('inc/wp_bootstrap_navwalker.php');
include_once('inc/wp_dynamic_menu_walker.php');
include_once('inc/wp_bootstrap_pagination.php');
require_once('inc/bootstrap-navwalker.php');
/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/


//add_action("wpcf7_before_send_mail", "wpcf7_do_something_else");
//function wpcf7_do_something_else($cf7) {
//    // get the contact form object
//    $wpcf = WPCF7_ContactForm::get_current();
//
//    var_dump($wpcf);
//    die();
//
//    return $wpcf;
//}
add_action( 'wpcf7_before_send_mail', 'wpcf7_change_recipient' );

function wpcf7_change_recipient($contact_form){


    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();
    $dest_mail = $posted_data["destination-email"];

	if($dest_mail) {
        $mail = $contact_form->prop( 'mail' );
        $mail['recipient'] = $dest_mail;
        $contact_form->set_properties(array('mail'=>$mail));
    }

}

add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );

function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
    $my_attr = 'destination-email';

    if ( isset( $atts[$my_attr] ) ) {
        $out[$my_attr] = $atts[$my_attr];
    }

    return $out;
}
function get_country($id) {
   $c =  wp_get_post_terms($id, 'post_country');

    return $c[0]->name;
}

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 600, 450, false); // Large Thumbnail
    add_image_size('medium', 290, '', true); // Medium Thumbnail
    add_image_size('small', 290, 190, true); // Small Thumbnail
    add_image_size('article_list_medium', 390, 240, true);
    add_image_size('home_banner', 474, 512, true); // Medium Thumbnail
    add_image_size('home_new', 348, 220, true);
    add_image_size('category_thmb', 820, 400, true);
    add_image_size('single_post', 1120, 512, true);
    add_image_size('related_post', 336, 420, true);
    add_image_size('news_main_post', 829, 407, true);
    add_image_size('news_list', 292, 177, true);
    add_image_size('about_book', 314, 391, true);
    add_image_size('about_image', 449, 269, true);
    add_image_size('management_image', 1147, 492, true);
    add_image_size('management_list', 430, 450, true);
    add_image_size('avatar', 460, 460, true);
    add_image_size('project_thmb', 595, 328, true);
    add_image_size('event-thmb', 165, 165, true);
    add_image_size('event-single', 410, 442, true);
    add_image_size('about_mobile', 157, 198);
    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('nowotheme', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function navbar_nav()
{
	wp_nav_menu(
        array(
            'theme_location' => 'navbar-menu',
            'depth' => 3,
            'menu_class' => 'nav navbar-nav',
            'walker' => new wp_bootstrap_navwalker()
        )
	);
}

// HTML5 Blank navigation
function html5blank_nav()
{
    wp_nav_menu(
        array(
            'theme_location' => 'main-top-menu',
            'depth' => 3,
            'menu_class' => 'nav navbar-nav',
            'walker' => new wp_bootstrap_navwalker()
        )
    );
}

// HTML5 Blank navigation
function language_nav()
{
    wp_nav_menu(
        array(
            'theme_location' => 'language-menu',
            'depth' => 1,
            'menu_class' => 'nav navbar-nav pull-right'
        )
    );
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
/*

        wp_register_script('mainscript', get_template_directory_uri() . '/src/resources/js/main.js', array('jquery', 'bootstrapjs'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('mainscript'); // Enqueue it!

        $dataArr = array(
            'google_maps' => ''
        );
        wp_localize_script( 'mainscript', 'translations', $dataArr );

        wp_register_script('jquery-ui', '//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('jquery-ui'); // Enqueue it!

        wp_register_script('lazyload', '//cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('lazyload'); // Enqueue it!

        $dataArr = array(
            'readmore' => __('read more', 'nowotheme'),
            'close' => __('close', 'nowotheme'),
        );
        wp_localize_script( 'mainscript', 'translations', $dataArr );

        wp_register_script('cookies-js', get_template_directory_uri() . '/src/resources/js/cookies.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('cookies-js'); // Enqueue it!

        wp_register_script('pluginsjs', get_template_directory_uri() . '/src/resources/js/plugins.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('pluginsjs'); // Enqueue it!

        wp_register_script('modulesjs', get_template_directory_uri() . '/src/resources/js/modules.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('modulesjs'); // Enqueue it!

        wp_register_script('gogmaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDid9fc7bPhOZ8G75-u6anoQ-Ge1Wqu03g&sensor=false&extension=.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('gogmaps'); // Enqueue it!

        wp_register_script('marker-cluster', get_template_directory_uri() . '/js/google-maps/marker-clustering.js', array('jquery', 'gogmaps'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('marker-cluster'); // Enqueue it!

        wp_register_script('catalog-filter', get_template_directory_uri() . '/src/resources/js/catalog.filter.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('catalog-filter'); // Enqueue it!



        $dataArr = array(
            'current_language_code' => ICL_LANGUAGE_CODE ? strtoupper(ICL_LANGUAGE_CODE) : strtoupper(get_locale()),
        );
        wp_localize_script( 'info-widgets-js', 'languages', $dataArr );

        $translation_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
        wp_localize_script( 'mainscript', 'templateObj', $translation_array );

        */

    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{

    wp_register_script('slick-js', get_template_directory_uri() . '/modules/slick/slick.js', array('jquery'), '1.0.0', true); // Custom scripts
    wp_enqueue_script('slick-js'); // Enqueue it!

    wp_register_script('moment-js', get_template_directory_uri() . '/modules/clndr/js/moment.js', array('jquery'), '1.0.0', true); // Custom scripts
    wp_enqueue_script('moment-js'); // Enqueue it!


    wp_register_script('underscore-js', get_template_directory_uri() . '/modules/clndr/js/underscore.js', array('jquery'), '1.0.0', true); // Custom scripts
    wp_enqueue_script('underscore-js'); // Enqueue it!

    wp_register_script('clndr-js', get_template_directory_uri() . '/modules/clndr/js/clndr.js', array('jquery'), '1.0.0', true); // Custom scripts
    wp_enqueue_script('clndr-js'); // Enqueue it!

    wp_register_script('nicescroll-js', get_template_directory_uri() . '/modules/nicescroll/jquery.nicescroll.min.js', array('jquery'), '1.0.0', true); // Custom scripts
    wp_enqueue_script('nicescroll-js'); // Enqueue it!

    wp_register_script('bootstrapjs', get_template_directory_uri() . '/dist/js/app.js', array('jquery'), '1.0.0', true); // Conditional script(s)
    wp_enqueue_script('bootstrapjs'); // Enqueue it!

    wp_register_script('theme-js', get_template_directory_uri() . '/js/theme.js', 'all', '1.0.0', true); // Custom scripts
    wp_enqueue_script('theme-js'); // Enqueue it!

    wp_localize_script( 'theme-js', 'params',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' )
        )
    );
}

// Load HTML5 Blank styles
function html5blank_styles()
{

    wp_register_style('theme-css', get_template_directory_uri() . '/dist/css/style.css', array(), '1.0', 'all');
    wp_enqueue_style('theme-css');

    wp_register_style('slick-css', get_template_directory_uri() . '/modules/slick/slick.css', array(), '1.0', 'all');
    wp_enqueue_style('slick-css');

    wp_register_style('slick-theme-css', get_template_directory_uri() . '/modules/slick/slick-theme.css', array(), '1.0', 'all');
    wp_enqueue_style('slick-theme-css');

}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));

    register_nav_menu('navbar-menu', __('Navbar menu'));
    register_nav_menu('navbar-menu-dynamic', __('Navbar menu dynamic'));
    register_nav_menu('main-top-menu', __('Main top menu'));
    register_nav_menu('main-top-menu2', __('Main top menu 2'));
    register_nav_menu('language-menu', __('Language menu'));
    register_nav_menu('social-menu', __('Social menu'));
    register_nav_menu('footer-menu', __('Footer menu'));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo bootstrap_paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'type'  => 'list'
    ));
}

function bootstrap_pagination($query = false)
{
    global $wp_query;
    $big = 999999999;
    echo bootstrap_paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $query ? $query->max_num_pages : $wp_query->max_num_pages,
        'type'  => 'list'
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
//function remove_admin_bar()
//{
//    return false;
//}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}


// Adding bootstrap 3 classes to comments form
function bootstrap3_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();

    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

    $fields   =  array(
        'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
        'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
        'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
            '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
    );

    return $fields;
}

function bootstrap3_comment_form( $args ) {
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . _x( 'Comment', 'noun' ) . '</label>
            <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
    return $args;
}

function bootstrap3_comment_button() {
    echo '<button class="btn btn-default" type="submit">' . __( 'Submit' ) . '</button>';
}

// End Bootstrap 3 comments

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
//add_action('init', 'create_post_type_html5'); // Add our HTML5 Bla    nk Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
//add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
add_filter('comment_form_default_fields', 'bootstrap3_comment_form_fields' );
add_filter('comment_form_defaults', 'bootstrap3_comment_form' );
add_action('comment_form', 'bootstrap3_comment_button', 10 );
add_filter('upload_mimes', 'custom_myme_types', 1, 1);

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}


/*------------------------------------*\
    Custom template functions
\*------------------------------------*/

function ot_custom_get_option($option)
{
    if (function_exists('ot_get_option')) {
        return ot_get_option($option);
    } else {
        return false;
    }
}


function debugvar($params, $debug = false)
{
    if($_SERVER['REMOTE_ADDR'] == '78.60.131.34')
    {
        if($params)
        {
            if(!$debug)
            {
                print_r('<pre>');
                print_r($params);
                print_r('</pre>');
            }else{
                print_r('<pre>');
                var_dump($params);
                print_r('</pre>');
            }
        }
    }
}


function xxxx_add_edit_form_multipart_encoding() {

    echo ' enctype="multipart/form-data"';

}
add_action('post_edit_form_tag', 'xxxx_add_edit_form_multipart_encoding');



// ============================ BREADCRUMS =============================

function dimox_breadcrumbs()
{
    global $post;
    /* === ОПЦИИ === */
    $text['home'] = __('Homepage', 'volonta'); // текст ссылки "Главная"
    $text['category'] = __('%s', 'volonta'); // текст для страницы рубрики
    $text['search'] = __('Search results for "%s"', 'volonta'); // текст для страницы с результатами поиска
    $text['tag'] = __('Posts with tag "%s"', 'volonta'); // текст для страницы тега
    $text['author'] = __('Author "%s" posts', 'volonta'); // текст для страницы автора
    $text['404'] = __('404 error', 'volonta'); // текст для страницы 404

    $show_current = 1; // 1 - показывать название текущей статьи/страницы/рубрики, 0 - не показывать
    $show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
    $show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
    $show_title = 1; // 1 - показывать подсказку (title) для ссылок, 0 - не показывать
//  $delimiter = ' &raquo; '; // разделить между "крошками"
    $delimiter = '<span class="delimiter"> / </span>';
    $before = '<li class="current">'; // тег перед текущей "крошкой"
    $after = '</li>'; // тег после текущей "крошки"
    /* === КОНЕЦ ОПЦИЙ === */

    global $post;
    $home_link = home_url('/');
    $link_before = '<li>';
    $link_after = '</li>';
    $link_attr = ' rel="v:url" property="v:title"';
    $link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $parent_id = $parent_id_2 = $post->post_parent;
    $frontpage_id = get_option('page_on_front');

    if (is_home() || is_front_page()) {

        if ($show_on_home == 1) echo '<ol class="breadcrumb"><li><a href="' . $home_link . '">' . $text['home'] . '</a></li>/div>';

    } else {

        echo '<ol class="breadcrumb col-tn-12">';


        if ($show_home_link == 1) {
            echo '<li class=""><a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a></li>';
            if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
        }

        if (is_category()) {
            $this_cat = get_category(get_query_var('cat'), false);

            if ($this_cat->parent != 0) {
                $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

        } elseif (is_search()) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;

        } elseif (is_day()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif (is_month()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;

        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                if(get_post_type() == 'sim_product')
                {
                    $product = SIM_Product::getInstance($post->ID);
                    $terms = wp_get_post_terms( $post->ID, 'sim_product_category' );

                    $values = array_values($terms);
                    $term = array_shift($values);

                    $product_page = get_post(get_page_by_template('inner-page-products'));

//                    echo '<a class="" href="' . get_permalink($product_page->ID) . '" >' . $product_page->post_title . '</a>' . $delimiter;
                    echo '<a class="" href="' . get_term_link( $term->slug, 'sim_product_category' ) . '" >' . $term->name . '</a>' . $delimiter . '<li class="current">' .  $product->post->post_title  . '</li>';
                }else{
                    $post_type = get_post_type_object(get_post_type());

                    $slug = $post_type->rewrite;
                    if($post_type->name == 'product'){
                        printf($link, '#', $post_type->labels->name);
                    }else{
//                        printf($link, $home_link . $slug['slug'], $post_type->labels->singular_name);
                        echo '<a class="" href="' . get_post_type_archive_link($post_type->name) .'" >' . __($post_type->labels->name, 'sca') . '</a>';
//                        echo '<a href="' . get_post_type_archive_link( get_post_type()) . '" >' . $post_type->labels->singular_name . '</a>';
                        if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
                    }
                }

            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
                if ($show_current == 1) echo $before . get_the_title() . $after;
            }

        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {

            global $wp_query;

            $cat = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );

            $cat = $cat->name;

            $post_type = get_post_type_object(get_post_type());


            if(is_tax('sim_product_category'))
            {
                echo $before . str_replace('-', ' ', $cat) . $after;
            }else{
                echo $link_before . '<a class="" href="' . get_post_type_archive_link($post_type->name) .'" >' . __($post_type->labels->name, 'sca') . '</a>' . $after . $delimiter;
                echo $before . $cat . $after;
            }

//            echo $link_before . '<a class="" href="' . get_post_type_archive_link($post_type->name) .'" >' . __($post_type->labels->name, 'sca') . '</a>' . $after;
//
//            echo $delimiter . $before . $cat . $after;


        } elseif (is_attachment()) {
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            if ($cat) {
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            printf($link, get_permalink($parent), $parent->post_title);
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif (is_page() && !$parent_id) {
            if ($show_current == 1) echo $before . get_the_title() . $after;

        } elseif (is_page() && $parent_id) {
            if ($parent_id != $frontpage_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
//                    echo $breadcrumbs[$i];
//                    if ($i != count($breadcrumbs) - 1) echo $delimiter;
                }
            }
            if ($show_current == 1) {
//                if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
                echo $before . get_the_title() . $after;
            }

        } elseif (is_tag()) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif (is_404()) {
            echo $before . $text['404'] . $after;

        } elseif (has_post_format() && !is_singular()) {
            echo get_post_format_string(get_post_format());
        }

//        if (get_query_var('paged')) {
//            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
//            echo ' > ' . __('Page', 'volonta') . ' ' . get_query_var('paged');
//            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
//        }

        echo '</ol><!-- .breadcrumbs -->';

    }
}


function get_template_part_leave_variables($template)
{
    if(!$template)
        return false;

    try{
        include(locate_template($template . '.php'));
    }
    catch(Exception $e)
    {
        echo 'File does not exist';
    }
}



add_filter('language_switcher_display', 'nwagency_language_switcher_display', 0, 0);

function nwagency_language_switcher_display()
{
    $languages = apply_filters('wpml_active_languages', '');


//    if(count($languages) < 2)
//        return array();

    array_walk($languages, function(&$language){

        if(isset($language['missing']) && $language['missing'])
        {
            $language['url'] = get_site_url() . '?lang=' . $language['language_code'];
        }
    });

    return $languages;
}


function is_project_page()
{
    if(is_single())
    {
        return true;
    }else if(is_tax())
    {
        return false;
    }
}

function get_page_type()
{
    if(isset($_GET['type']))
    {
        return $_GET['type'] . '-page';
    }
}


/**
 * Admin options for nwagency
 */
function global_custom_options()
{
    echo get_template_part('theme-settings');
}



function is_inline_weather()
{
    if(is_front_page() || is_singular(SIM_Product::$post_type))
    {
        return false;
    }else
    {
        return true;
    }
}


// Check if page template is my-funds-page

function get_page_by_template($template, $page_id = false)
{

    if(!$template)
        return false;

    $args = array(
        'post_type' => 'page',
        'meta_query' => array(
            array(
                'key' => "_wp_page_template",
                'value' => "page-templates/$template.php",
                'compare' => "LIKE"
            ),
        )
    );

    $pages = get_posts(
        $args
    );


    if(!$page_id)
    {

        if(!isset($pages[0]))
            return null;

        $pageID = icl_object_id($pages[0]->ID, 'page', false, ICL_LANGUAGE_CODE);
    }else{


        $cur_page = get_post($page_id);

        if($cur_page->post_parent !== 0)
        {
            $page_id = get_post_parent($cur_page->ID);


            if($pages && $page_id)
            {
                foreach($pages as $page)
                {
                    if($page->ID == $page_id)
                    {
                        $pageID = icl_object_id($page->ID, 'page', false, ICL_LANGUAGE_CODE);
                    }
                }
            }else{


                if(is_array($pages) && count($pages) > 0)
                {
                    if(!isset($pages[1]))
                        return null;

                    $pageID = icl_object_id($pages[1]->ID, 'page', false, ICL_LANGUAGE_CODE);
                }else{

                    if(!isset($pages[0]))
                        return null;

                    $pageID = icl_object_id($pages[0]->ID, 'page', false, ICL_LANGUAGE_CODE);
                }
            }

        }
    }



    return $pageID;

}



function get_pages_by_parent_id($parent_id)
{
    if(!$parent_id)
        return array();

    $pages = get_pages(
        array(
            'parent' => $parent_id
        )
    );

    return $pages;
}

add_filter('intermediate_image_sizes', 'my_intermediate_image_sizes', 0, 1);

function my_intermediate_image_sizes($image_sizes){

    global $post;

    if(get_post_type($post->post_type != 'sim_slide') && isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
    {
        $image_sizes = array('thumbnail', 'front_slide');
    }

    return $image_sizes;
}



//add_filter('posts_where','nowotheme_search_where');
//add_filter('posts_join', 'nowotheme_search_join');
//add_filter('posts_groupby', 'nowotheme_search_groupby');


function nowotheme_search_where($where){
    global $wpdb;
    if (is_search())
    {
        $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
        debugvar($where);
        var_dump(is_search());
        exit('1');
    }
    return $where;
}

function nowotheme_search_join($join){
    global $wpdb;
    if (is_search())
    {
        $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
        debugvar($join);
        exit('2');
    }
    return $join;
}

function nowotheme_search_groupby($groupby){
    global $wpdb;

    // we need to group on post ID
    $groupby_id = "{$wpdb->posts}.ID";
    if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

    // groupby was empty, use ours
    if(!strlen(trim($groupby))) return $groupby_id;

    // wasn't empty, append ours
    return $groupby.", ".$groupby_id;
}


add_filter('wpiss_post_tempalte', 'nowotheme_wpiss_post_tempalte', 0, 1);

function nowotheme_wpiss_post_tempalte($template){
    $template  = '
	<script type="x-tmpl-mustache" id="wpiss-post-template">
		<li class="iss-result">
			{{{title}}}
			<span class="source">
			    {{{posttype}}}
			</span>
		</li>
	</script>';

    return $template;
}

add_filter('wpiss_taxonomy_template', 'nowotheme_wpiss_taxonomy_template', 0, 1);

function nowotheme_wpiss_taxonomy_template($template){

    $template  = '
	<script type="x-tmpl-mustache" id="wpiss-taxonomy-template">
		<li class="iss-result">
			{{{title}}}
			<span class="source">
			    {{{posttype}}}
			</span>
		</li>
	</script>';

    return $template;
}


add_action( 'wp_ajax_iss_suggest', 'sim_iss_suggest' );
add_action( 'wp_ajax_nopriv_iss_suggest', 'sim_iss_suggest' );

/**
 * Catch ajax action for search suggestions.
 *
 * @return string JSON content
 */
function sim_iss_suggest() {

    // grab _wpnonce value
    $nonce = $_REQUEST['_wpnonce'];

    if ( wp_verify_nonce( $nonce, 'iss_suggest' ) ) {

        // clean up the query
        $s = sanitize_text_field( stripslashes( $_GET['q'] ) );

        // check for the results in cache
        $results = wp_cache_get( 'wpiss_' . sanitize_title_with_dashes( $s ) );


        // no cache so lets create some suggestions
        if ( $results == false ) {


            $results = array();

            // grab our settings
            $options = get_option( 'wpiss_options' );

            // post types
            $post_query = array();

            $args = array(
                'public' => true,
                'show_ui' => true
            );
            $output = 'objects';
            $operator = 'and';
            $post_types = get_post_types( $args, $output, $operator );

            if ( !empty( $post_types ) ) {

                foreach ( $post_types as $post_type ) {

                    if ( isset( $options['wpiss_chk_post_' . $post_type->name] ) ) {
                        $post_query[] = $post_type->name;
                    }
                }

            } else {

                if ( $options['wpiss_chk_post_post'] ) { $post_query[] = 'post'; }
                if ( $options['wpiss_chk_post_page'] ) { $post_query[] = 'page'; }

            }

            if ( !empty( $post_query ) ) {

                $query_args = array(
                    's' => $s,
                    'post_status' => 'publish',
                    'post_type' => $post_query
                );
                $query = new WP_Query( $query_args );



                if ( ! empty( $query->posts ) ) {

                    foreach ( $query->posts as $post ) {

                        if ( function_exists( 'has_post_thumbnail' ) ) {
                            if ( has_post_thumbnail( $post->ID ) ) {
                                $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID, 'thumbnail' ) );
                            } else {
                                unset( $post_image );
                            }
                        }

                        // get the categories
                        $categories = '';
                        foreach ( get_the_category( $post->ID ) as $category ) {
                            $categories .= $category->cat_name . ', ';
                        }
                        $categories = rtrim( $categories, ', ' );


                        $res_title = false;


                        $start_pos = strpos(strtolower($post->post_title), strtolower($s));

                        if($start_pos > -1)
                        {
                            $res_title = true;
                        }else{

                            $start_pos = strpos(strtolower($post->post_content), strtolower($s));
                        }


                        if($start_pos > -1){

                            $results[] = array(
                                'id' => $post->ID,
                                'title' => strip_tags( substr($res_title ? $post->post_title : $post->post_content, $start_pos, 40) ),
                                'permalink' => get_permalink( $post->ID ),
                                'postdate' => get_the_time( get_option( 'date_format' ), $post->ID),
                                'posttype' => $post_types[$post->post_type]->labels->singular_name,
                                'categories' => $categories,
                                'type' => 'post',
                                'image' => ( isset( $post_image ) ? $post_image[0] : 0 )
                            );
                        }

                    }
                }
            }


            // taxononomies
            $tax_query = array();
            $tax_args = array();
            $tax_output = 'objects';
            $tax_operator = 'and';
            $taxonomies = get_taxonomies( $tax_args, $tax_output, $tax_operator );

            if ( !empty( $taxonomies ) ) {

                foreach ( $taxonomies as $tax ) {

                    if ( isset( $options['wpiss_chk_tax_' . $tax->name] ) ) {
                        $tax_query[] = $tax->name;
                    }
                }
            } else {

                if ( $options['wpiss_chk_tax_category'] ) { $tax_query[] = 'category'; }
                if ( $options['wpiss_chk_tax_post_tag'] ) { $tax_query[] = 'post_tag'; }

            }

            if ( !empty( $tax_query ) ) {

                $terms = get_terms( $tax_query, 'search='.$s );

                if ( ! empty( $terms ) ) {

                    foreach ( $terms as $term ) {

                        $results[] = array(
                            'title' => $term->name,
                            'permalink' => get_term_link( $term->name, $term->taxonomy ),
                            'taxonomy' => $taxonomies[$term->taxonomy]->labels->singular_name,
                            'count' => $term->count,
                            'type' => 'taxonomy'
                        );
                    }
                }
            }
        }

        // sort and output results
        if ( ! empty( $results ) ) {

            // cache output for 10 minutes for everyone
            wp_cache_set( 'wpiss_' . sanitize_title_with_dashes( $s ), $results, '', 1 );

            if ( isset( $options['wpiss_suggestion_count'] ) && $options['wpiss_suggestion_count'] != 'all' ) {
                if ( count( $results ) > absint( $options['wpiss_suggestion_count'] ) ) {
                    $more = true;
                    $count = count( $results );
                    $results = array_slice( $results, 0, absint( $options['wpiss_suggestion_count'] ) ); //only return the max set
                }
            }

            sort( $results );

            // add a view all if we have more results
            if ( isset( $more ) ) {
                $results[] = array(
                    'title' => __( 'View all results', 'wpiss' ),
                    'permalink' => add_query_arg( array( 's' => $s ), site_url() ),
                    'count'	=> $count,
                    'type' => 'more'
                );
            }


            echo json_encode( $results );
        }
    }


    die();
}




function simpras_hash_filename( $filename ) {

    $filename = transliterate($filename);
    $info = pathinfo( $filename );
    $ext  = empty( $info['extension'] ) ? '' : '.' . $info['extension'];
    $name = basename( $filename, $ext );

    return $name . $ext;
}

add_filter( 'sanitize_file_name', 'simpras_hash_filename', 10 );



/**
 * Returns transliterated string. LT and RU only
 * @param string $str
 * @return string
 */
function transliterate($str)
{
    $matchRu  = array(
        "а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л",
        "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш",
        "щ", "ъ", "ы", "ь", "э", "ю", "я",
        "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж", "З", "И", "Й", "К", "Л",
        "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш",
        "Щ", "Ъ", "Ы", "Ь", "Э", "Ю", "Я",
    );

    $replaceRu = array(
        "a", "b", "v", "g", "d", "e", "yo", "zh", "z", "i", "j", "k", "l",
        "m", "n", "o", "p", "r", "s", "t", "u", "f", "x", "cz", "ch", "sh",
        "shh", "``", "y`", "`", "e`", "yu", "ya",
        "A", "B", "V", "G", "D", "E", "YO", "ZH", "Z", "I", "J", "K", "L",
        "M", "N", "O", "P", "R", "S", "T", "U", "F", "X", "CZ", "CH", "SH",
        "SHH", "``", "Y`", "`", "E`", "YU", "YA",
    );

    // transliterate
    $matchLt = array(
        'ą', 'č', 'ę', 'ė', 'į', 'š', 'ų', 'ū', 'ž', 'Ą', 'Č', 'Ę', 'Ė', 'Į', 'Š', 'Ų', 'Ū', 'Ž');
    $replaceLt = array(
        'a', 'c', 'e', 'e', 'i', 's', 'u', 'u', 'z', 'A', 'C', 'E', 'E', 'I', 'S', 'U', 'U', 'Z');

    $str = str_ireplace($matchRu, $replaceRu, $str);
    $str = str_replace($matchLt, $replaceLt, $str);

    return $str;
}



function show_overflow_bg()
{
    if(is_front_page() || is_page()  && get_field('overflow_bg_image', get_the_ID()))
    {
        return true;
    }
    return false;
}


function custom_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
    return $mime_types;
}



//add_filter('get_archives_link', 'get_archives_link_mod', 10, 1);

function get_archives_link_mod ( $link_html ) {
    global $wp_query;

//    if(get_option('permalink_structure'))
//    {
//
//    }

    preg_match ("/value='(.+?)'/", $link_html, $url);



    $requested = "http://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}";

    if(isset($wp_query->query['paged']) && $wp_query->query['paged'])
    {
        $requested = str_replace('/page/'.$wp_query->query['paged'], '', $requested);
    }

    if ($requested == $url[1]) {
        $link_html = str_replace("<li", "<li selected='selected'", $link_html);
    }
    return $link_html;
}


//Sanitize title filter for hash
add_filter('slash_to_underscore', 'sanitize_slash_to_underscore', 10, 1);

function sanitize_slash_to_underscore($title){

    return str_replace('/', '_', $title);
}

function binary_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop )
{
    if ( !$crop ) return null;
    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);
    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );
    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter( 'image_resize_dimensions', 'binary_thumbnail_upscale', 10, 6 );

function getExtension($f) {
    $path_info = pathinfo($f);
    return $path_info['extension'];
}


add_action( 'wp_ajax_get_events', 'get_events' ); // For logged in users
add_action( 'wp_ajax_nopriv_events', 'get_events' ); // For anonymous users

add_action( 'wp_ajax_get_event', 'get_event' ); // For logged in users
add_action( 'wp_ajax_nopriv_get_event', 'get_event' ); // For anonymous users

add_action( 'wp_ajax_get_events_list', 'get_events_list' ); // For logged in users
add_action( 'wp_ajax_nopriv_get_events_list', 'get_events_list' ); // For anonymous users

function get_events(){
    $data = $_REQUEST;
    $posts = get_posts(array(
        'posts_per_page'	=> -1,
        'post_type'			=> 'post',
        'meta_query'	=> array(
            array(
                'key'	 	=> 'event',
                'value'	  	=> '"1"',
                'compare' 	=> 'LIKE',
            )
        ),
    ));
    $events = [];
    foreach ($posts as $event) {
        $start_date = get_field('start_date', $event->ID);
        $end_date = get_field('end_date', $event->ID);
        $events[] = [
                'id' => $event->ID,
                'title' => $event->post_title,
                'endDate' => $end_date,
                'startDate' => $start_date

        ];
    }
//    ob_start();
//    set_query_var( 'events', $posts );
//    get_template_part('ajax-events');
//    $html = ob_get_contents();
//    ob_end_clean();
//
//    if($data["date"] != "false") {
//        echo (json_encode( array('html' => $html,'events'=> $events) ));
//    } else {
//        echo (json_encode( array('events'=> $events) ));
//    }
    echo (json_encode( array('events'=> $events) ));
    wp_die();
}

function get_event(){
    $data = $_REQUEST;
    $event = get_post($data['post_id']);
    ob_start();
    set_query_var( 'article_id', $event->ID );
    get_template_part('ajax-event');
    $html = ob_get_contents();
    ob_end_clean();
    echo (json_encode( array('html' => $html) ));
    wp_die();
}


function get_events_list()
{
    $data = $_REQUEST;

    $posts = get_posts(array(
        'post__in' => $data['events']

    ));

        ob_start();
    set_query_var( 'events', $posts );
    get_template_part('ajax-events');
    $html = ob_get_contents();
    ob_end_clean();
    echo (json_encode( array('html' => $html) ));
    wp_die();
}


function removeMenu() {
    if(!current_user_can('administrator' )) {
        remove_menu_page('edit.php?post_type=sim_timeline');
        remove_menu_page('edit.php?post_type=sim_product');
        remove_menu_page('edit.php?post_type=sim_document');
        remove_menu_page('edit.php?post_type=sim_partner');
        remove_menu_page('edit.php?post_type=sim_employee');
        remove_menu_page('edit.php?post_type=sim_service');
        remove_menu_page('edit.php?post_type=sim_special_offer');
        remove_menu_page('edit.php?post_type=sim_city');
        remove_menu_page('edit.php?post_type=sim_slide');
        remove_menu_page('edit.php?post_type=sim_news');
        remove_menu_page('edit.php?post_type=sim_video');
        remove_menu_page('edit.php?post_type=sim_review');
        remove_menu_page('admin.php?page=wpcf7');
        remove_menu_page('wpcf7');
    }
}

add_action('admin_menu', 'removeMenu');
