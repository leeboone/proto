<?php
////////////////////////////////////////////////
//REGISTER SCRIPTS and STYLES
////////////////////////////////////////////////

if(!function_exists('register_slide_script')){
    function slide_script()
    {
        $temp_url = get_template_directory_uri();
        if(!is_admin())
        {
            wp_register_script('slides-behavior', get_bloginfo( 'template_url' ).'/functions/slides.js', array('jquery'));
            wp_enqueue_script('slides-behavior');
        }
    }
    function register_slide_script(){
    add_action('init','slide_script', 1);
    }
}

//** Slide Post type
if(!function_exists('register_slides')){
    function register_slides(){
        add_action( 'init', 'register_cpt_slide' );        
    }
    register_slides();
}

function register_cpt_slide() {
    $temp_url = get_bloginfo( 'template_url' );
    $labels = array( 
        'name' => _x( 'Slides', 'slide' ),
        'singular_name' => _x( 'Slide', 'slide' ),
        'add_new' => _x( 'Add New', 'slide' ),
        'add_new_item' => _x( 'Add New Slide', 'slide' ),
        'edit_item' => _x( 'Edit Slide', 'slide' ),
        'new_item' => _x( 'New Slide', 'slide' ),
        'view_item' => _x( 'View Slide', 'slide' ),
        'search_items' => _x( 'Search Slides', 'slide' ),
        'not_found' => _x( 'No slides found', 'slide' ),
        'not_found_in_trash' => _x( 'No slides found in Trash', 'slide' ),
        'parent_item_colon' => _x( 'Parent Slide:', 'slide' ),
        'menu_name' => _x( 'Slides', 'slide' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Slides for Orbit Slider',
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 10,
        'menu_icon' => $temp_url.'/images/slides.png',
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'slide', $args );
}
//** Add the Slide Link Box
function add_slide_link_box() {
    add_meta_box(
        'slide_link_box', // $id
        'Slide Link', // $title
        'show_slide_link_box', // $callback
        'slide', // $page
        'normal', // $context
        'low'); // $priority
}
add_action('add_meta_boxes', 'add_slide_link_box');
// Field Array
$prefix = 'slide_';
$slide_meta_fields = array(
    array(
        'label'=> 'Slide Link URL',
        'desc'  => 'Select the page or post this slide should link to.',
        'id'    => $prefix.'url_value',
        'type'  => 'post_list',  
        'post_type' => array('slide')
    )
); 
// The Callback
function show_slide_link_box() {
global $slide_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="slide_link_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($slide_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // text
                    case 'text':
                        echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
                            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                     // post_list  
                    case 'post_list':  
                    $items = get_posts( array (  
                        'post_type' => $field['post_type'],  
                        'posts_per_page' => -1,
                        'orderby' => 'menu_order modified',
                        'order'=> 'ASC'
                    ));  
                        echo '<select name="'.$field['id'].'" id="'.$field['id'].'"> 
                                <option value="">Select One</option>'; // Select One  
                            foreach($items as $item) {  
                                echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';  
                            } // end foreach  
                        echo '</select><br /><span class="description">'.$field['desc'].'</span>';  
                    break;  

               } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}
// Save the Data
function save_slide_link_meta($post_id) {
    global $slide_meta_fields;

    // verify nonce
    if (!wp_verify_nonce($_POST['slide_link_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('slide' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }

    // loop through fields and save the data
    foreach ($slide_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_slide_link_meta');  


// Adds custom taxonomy for Slideshows
if(!function_exists('register_slideshow_taxonomy')){
    function register_slideshow_taxonomy(){
        add_action( 'init', 'slides_register_taxonomy' );       
    }
    register_slideshow_taxonomy();
}



function slides_register_taxonomy() {

    $labels = array(
            
        'name'              => __( 'Slideshows', 'slides' ),
        'singular_name'     => __( 'Slideshow', 'slides' ),
        'search_items'      => __( 'Search Slideshows', 'slides' ),
        'popular_items'     => __( 'Popular Slideshows', 'slides' ),
        'all_items'         => __( 'All Slideshows', 'slides' ),
        'parent_item'       => __( 'Parent Slideshow', 'slides' ),
        'parent_item_colon' => __( 'Parent Slideshow:', 'slides' ),
        'edit_item'         => __( 'Edit Slideshow', 'slides' ),
        'update_item'       => __( 'Update Slideshow', 'slides' ),
        'add_new_item'      => __( 'Add New Slideshow', 'slides' ),
        'new_item_name'     => __( 'New Slideshow Name', 'slides' ),
        'menu_name'         => __( 'Slideshows', 'slides' )
            
    );
    
    $args = array(

        'labels'            => $labels,
        'public'            => true,
        'show_in_nav_menus' => false,
        'show_ui'           => true,
        'show_tagcloud'     => false,
        'hierarchical'      => true,
        'rewrite'           => array( 'slug' => 'slideshow' )
    
    );

    register_taxonomy( 'slideshow', 'slide', $args );
}

// Customize and move featured image box to main column

add_action( 'do_meta_boxes', 'slides_image_box' );

function slides_image_box() {
    
    
    $title = "Slide Image";

    remove_meta_box( 'postimagediv', 'slide', 'side' );

    add_meta_box( 'postimagediv', $title, 'post_thumbnail_meta_box', 'slide', 'side', 'low' );

}

// Adds slide image and link to slides column view

add_filter( 'manage_edit-slide_columns', 'slides_edit_columns' );

function slides_edit_columns( $columns ) {

    $columns = array(
    
        'cb'         => '<input type="checkbox" />',
        'slide'      => __( 'Slide Image', 'slides' ),
        'title'      => __( 'Slide Title', 'slides' ),
        'slideshow'  =>  "Slideshow",
        'slide-link' => __( 'Slide Link', 'slides' ),
        'date'       => __( 'Date', 'slides' )

    );

    return $columns;

}

add_action( 'manage_posts_custom_column', 'slides_custom_columns' );

function slides_custom_columns( $column ) {

    global $post;

    switch ( $column ) {
        case 'slide' :
            echo the_post_thumbnail("slide-thumb");
        
        break;
        
        case 'slideshow' :
            echo get_the_term_list($post->ID,'slideshow','',', ','');
            
        break;
        
        case 'slide-link' :
            if ( get_post_meta($post->ID, "slide_url_value", $single = true) != "" ) {
                echo "<a href='" . get_post_meta($post->ID, "slide_url_value", $single = true) . "'>" . get_post_meta($post->ID, "slide_url_value", $single = true) . "</a>";
            }  
            else {
                'No Link';
            }
        break;
    }
}
// END SLIDES CPT & SLIDESHOW TAXONOMY