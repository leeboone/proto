<?php
////////////////////////////////////////////////
//REGISTER SCRIPTS and STYLES
////////////////////////////////////////////////
function register_scripts_and_styles()
{
	$temp_url = get_template_directory_uri();
	if(!is_admin())
	{
		/*wp_register_style( 'jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/base/jquery-ui.css');
		wp_enqueue_style( 'jquery-ui-css' );*/
        // wp_register_style('anythingslider-styles', $temp_url.'/css/anythingslider.css');
        // wp_enqueue_style('anythingslider-styles');
        wp_register_style('bootstrap-css', $temp_url.'/css/bootstrap.css');
        wp_enqueue_style('bootstrap-css');
        wp_register_style('bootstrap-responsive-css', $temp_url.'/css/bootstrap-responsive.css');
        wp_enqueue_style('bootstrap-responsive-css');
        wp_register_style('layout-css', $temp_url.'/css/layout.css');
        wp_enqueue_style('layout-css');

	// Register Current jquery => 1.8.1
		// wp_deregister_script( 'jquery' );
		// wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js');
		wp_enqueue_script( 'jquery' );
        wp_register_script('easing', $temp_url.'/js/jquery.easing.1.2.js',array('jquery'));
        wp_enqueue_script('easing');
        wp_register_script('anythingslider', $temp_url.'/js/jquery.anythingslider.js',array('jquery','easing'));
         wp_enqueue_script('anythingslider');
        // wp_register_script('anythingslider-fx', $temp_url.'/js/jquery.anythingslider.fx.js');
        // wp_enqueue_script('anythingslider-fx');
        wp_register_script('bootstrap-js', $temp_url.'/js/bootstrap.js', array('jquery'));
        wp_enqueue_script('bootstrap-js');
        wp_register_script('columnizer', $temp_url.'/js/columnizer.js', array('jquery'));
        // wp_enqueue_script('columnizer');
        wp_register_script('stretch', $temp_url.'/js/jquery.stretch.js', array('jquery'));
        wp_enqueue_script('stretch');
        wp_register_script('theme-behavior', $temp_url.'/js/theme-behavior.js', array('jquery'));
        wp_enqueue_script('theme-behavior');
	}
}
add_action('init','register_scripts_and_styles', 1);


////////////////////////////////////////////////
//Post Formats
////////////////////////////////////////////////
if ( ! function_exists( 'post_format_support' ) ) :
function post_format_support(){
add_theme_support( 'post-formats', array( 'aside', 'image', 'quote', 'gallery' ) );
}
post_format_support();
endif;

////////////////////////////////////////////////
//MENUS
////////////////////////////////////////////////
//Add support and register positions
if ( ! function_exists( 'menu_support' ) ) :
function menu_support(){
add_theme_support( "menus" );
register_nav_menus(array("main"=>"Main Nav Menu", "footer"=>"Footer Nav","mobile"=>"Mobile Nav", "super"=>"Super Nav"));
}
menu_support();
endif;


/**
 * Class Name: twitter_bootstrap_nav_walker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom Wordpress nav walker to implement the Twitter Bootstrap 2 (https://github.com/twitter/bootstrap/) dropdown navigation using the Wordpress built in menu manager.
 * Version: 1.2.1
 * Author: Edward McIntyre - @twittem
 * Licence: WTFPL 2.0 (http://sam.zoy.org/wtfpl/COPYING)
 */

/**
* Extended Walker class for use with the
* Twitter Bootstrap toolkit Dropdown menus in Wordpress.
* Edited to support n-levels submenu.
* @author johnmegahan https://gist.github.com/1597994, Emanuele 'Tex' Tessore https://gist.github.com/3765640
*/
class BootstrapNavMenuWalker extends Walker_Nav_Menu {
 
 
function start_lvl( &$output, $depth ) {
 
$indent = str_repeat( "\t", $depth );
$submenu = ($depth > 0) ? ' sub-menu' : '';
$output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
 
}
 
function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
 
 
$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
$li_attributes = '';
$class_names = $value = '';
 
$classes = empty( $item->classes ) ? array() : (array) $item->classes;
// managing divider: add divider class to an element to get a divider before it.
$divider_class_position = array_search('divider', $classes);
if($divider_class_position !== false){
$output .= "<li class=\"divider\"></li>\n";
unset($classes[$divider_class_position]);
}
$classes[] = ($args->has_children) ? 'dropdown' : '';
$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
$classes[] = 'menu-item-' . $item->ID;
if($depth && $args->has_children){
$classes[] = 'dropdown-submenu';
}
 
 
$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
 
$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
 
$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
$attributes .= ($args->has_children) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
 
$item_output = $args->before;
$item_output .= '<a'. $attributes .'>';
$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
$item_output .= ($depth == 0 && $args->has_children) ? ' <b class="caret"></b></a>' : '</a>';
$item_output .= $args->after;
 
 
$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
}
 
function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
//v($element);
if ( !$element )
return;
 
$id_field = $this->db_fields['id'];
 
//display this element
if ( is_array( $args[0] ) )
$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
else if ( is_object( $args[0] ) )
$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
$cb_args = array_merge( array(&$output, $element, $depth), $args);
call_user_func_array(array(&$this, 'start_el'), $cb_args);
 
$id = $element->$id_field;
 
// descend only when the depth is right and there are childrens for this element
if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
 
foreach( $children_elements[ $id ] as $child ){
 
if ( !isset($newlevel) ) {
$newlevel = true;
//start the child delimiter
$cb_args = array_merge( array(&$output, $depth), $args);
call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
}
$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
}
unset( $children_elements[ $id ] );
}
 
if ( isset($newlevel) && $newlevel ){
//end the child delimiter
$cb_args = array_merge( array(&$output, $depth), $args);
call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
}
 
//end this element
$cb_args = array_merge( array(&$output, $element, $depth), $args);
call_user_func_array(array(&$this, 'end_el'), $cb_args);
 
}
 
}


class Main_Nav_Walker extends Walker_Nav_Menu {
    
    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth ) {
        $indent = str_repeat( "\t", $depth );
        $output    .= "\n$indent<ul class=\"dropdown-menu\">\n";        
    }


    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        if (strcasecmp($item->title, 'divider')) {
            $class_names = $value = '';
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = ($item->current) ? 'active' : '';
            $classes[] = 'menu-item-' . $item->ID;
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

            if ($args->has_children && $depth > 0) {
                $class_names .= ' dropdown-submenu';
            } else if($args->has_children && $depth === 0) {
                $class_names .= ' dropdown';
            }

            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names .'>';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ($args->has_children)        ? ' class="dropdown-toggle"' : '';

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= ($args->has_children && $depth == 0) ? ' <span class="caret"></span></a>' : '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        } else {
            $output .= $indent . '<li class="divider"></li>';
        }
    }


    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        
        if ( !$element ) {
            return;
        }
        
        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_array( $args[0] ) ) 
            $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
        else if ( is_object( $args[0] ) ) 
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

            foreach( $children_elements[ $id ] as $child ){

                if ( !isset($newlevel) ) {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
                unset( $children_elements[ $id ] );
        }

        if ( isset($newlevel) && $newlevel ){
            //end the child delimiter
            $cb_args = array_merge( array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
    }
}


class Unnested_Nav_Walker extends Walker_Nav_Menu {
    
    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth ) {
        $indent = str_repeat( "\t", $depth );
        $output    .= "\n$indent<ul class=\"dropdown-menu\">\n";        
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        if (strcasecmp($item->title, 'divider')) {
            $class_names = $value = '';
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = ($item->current) ? 'active' : '';
            $classes[] = 'menu-item-' . $item->ID;
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

            if ($args->has_children && $depth > 0) {
                $class_names .= ' dropdown-submenu';
            } else if($args->has_children && $depth === 0) {
                $class_names .= ' dropdown';
            }

            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names .'>';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        } else {
            $output .= $indent . '<li class="divider"></li>';
        }
    }


    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth. 
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @see Walker::start_el()
     * @since 2.5.0
     *
     * @param object $element Data object
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args
     * @param string $output Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        
        if ( !$element ) {
            return;
        }
        
        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_array( $args[0] ) ) 
            $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
        else if ( is_object( $args[0] ) ) 
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

            foreach( $children_elements[ $id ] as $child ){

                if ( !isset($newlevel) ) {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
                unset( $children_elements[ $id ] );
        }

        if ( isset($newlevel) && $newlevel ){
            //end the child delimiter
            $cb_args = array_merge( array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
    }
}




////////////////////////////////////////////////
//SIDEBARS
////////////////////////////////////////////////
if ( ! function_exists( 'theme_sidebars' ) ) :
function theme_sidebars(){
/**RIGHT PAGE SIDEBAR**/
register_sidebar(array(
  "name" => "Right Page Sidebar",
  "id" => "right-page-sidebar",
  "description" => "Widgets in this area will be shown on the right-hand side of most pages. ",
        "before_widget" => '<aside id="%1$s" class="widget %2$s">',
        "after_widget" => "</aside>",
        "before_title" => '<h3 class="widgettitle">',
        "after_title" => "</h3>"
));

/**RIGHT POST SIDEBAR**/
register_sidebar(array(
  "name" => "Right Post Sidebar",
  "id" => "right-post-sidebar",
  "description" => "Widgets in this area will be shown on the right-hand side of news articles, and auto-generated pages such as news article archives. ",
        "before_widget" => '<aside id="%1$s" class="widget %2$s">',
        "after_widget" => "</aside>",
        "before_title" => '<h3 class="widgettitle">',
        "after_title" => "</h3>"
));

/**FOOTER SIDEBAR**/
register_sidebar(array(
  "name" => "Footer Widgets",
  "id" => "footer-widgets",
  "description" => "Widgets in this area will be shown above the footer. ",
        "before_widget" => '<aside id="%1$s" class="widget %2$s">',
        "after_widget" => "</aside>",
        "before_title" => '<h3 class="widgettitle">',
        "after_title" => "</h3>"
));
}
theme_sidebars();
endif;




////////////////////////////////////////////////
//THUMBNAILS
////////////////////////////////////////////////
if ( ! function_exists( 'thumbnail_support' ) ) :
function thumbnail_support(){
add_theme_support( "post-thumbnails" );
add_image_size( "post-thumbnail", 200, 200, true ); 
add_image_size( "page-feature", 770, 335, true ); 
add_image_size( "home-slide", 1170, 560, true ); 
add_image_size( "slide-thumb", 160, 90, true ); 
}
thumbnail_support();
endif;



////////////////////////////////////////////////
//AUTOMATICALLY ADD RSS FEED LINKS
////////////////////////////////////////////////
automatic_feed_links();



////////////////////////////////////////////////
//MOVE YOAST META TO BOTTOM
////////////////////////////////////////////////
function yoasttobottom() {
    return 'low';
}

add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

////////////////////////////////////////////////
//SET DEFAULT SCREEN OPTIONS
////////////////////////////////////////////////
function set_user_metaboxes($user_id) {

    // order
    $meta_key = 'meta-box-order_post';
    $meta_value = array(
        'side' => 'submitdiv,formatdiv,categorydiv,postimagediv',
        'normal' => 'postexcerpt,trackbacksdiv,tagsdiv-post_tag,postcustom,commentstatusdiv,commentsdiv,slugdiv,authordiv,revisionsdiv',
        'advanced' => '',
    );
    update_user_meta( $user_id, $meta_key, $meta_value );

    // hiddens
    $meta_key = 'metaboxhidden_post';
    $meta_value = array('postexcerpt','trackbacksdiv','commentstatusdiv','commentsdiv','slugdiv','authordiv','revisionsdiv','edit-box-ppr');
    update_user_meta( $user_id, $meta_key, $meta_value );

}
add_action('user_register', 'set_user_metaboxes');