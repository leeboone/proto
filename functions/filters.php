<?php
////////////////////////////////////////////////
//CUSTOM EXCERPTS
////////////////////////////////////////////////
if ( ! function_exists( 'custom_excerpts' ) ) :
function custom_excerpts(){
function custom_excerpt_length( $length ) {
    return 65;
}
add_filter( 'excerpt_length', 'custom_excerpt_length' );

function custom_continue_reading_link() {
    return '<p class="continueLink"><a class="btn btn-inverse" href="'. get_permalink() . '">Read more about <em>'.get_the_title(  ).'</em></a></p>';
}

function custom_auto_excerpt_more( $more ) {
    return '&hellip;' . custom_continue_reading_link();
}
add_filter( 'excerpt_more', 'custom_auto_excerpt_more' );

function custom_custom_excerpt_more( $output ) {
    if ( has_excerpt() && ! is_attachment() ) {
        $output .= custom_continue_reading_link();
    }
    return $output;
}
add_filter( 'get_the_excerpt', 'custom_custom_excerpt_more' );
}
custom_excerpts();
endif;


////////////////////////////////////////////////
//SHORTCODES IN WIDGETS
////////////////////////////////////////////////
add_filter("widget_text", "do_shortcode");




////////////////////////////////////////////////
//ADD 'first' and 'last' CLASSES TO WIDGETS
////////////////////////////////////////////////
/** Also adds numeric index class for each widget (widget-1, widget-2, etc.) via http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets **/
function widget_first_last_classes($params) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]["id"]; // Get the id for the current sidebar we"re processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

	if(!$my_widget_num) {// If the counter array doesn"t exist, create it
		$my_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}

	$class = "class='widget-" . $my_widget_num[$this_id] . " "; // Add a widget number class for additional styling options

	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= "widget-first ";
	} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= "widget-last ";
	}

	//$params[0]["before_widget"] = str_replace("class='", $class, $params[0]["before_widget"]); // Insert our new classes into 'before widget'
	$params[0]["before_widget"] = preg_replace("/class=\'/", '$class', $params[0]["before_widget"], 1);
	return $params;

}
add_filter("dynamic_sidebar_params","widget_first_last_classes");



///////////////////////////////////////////////
//FILTER the GALLERY SHORTCODE
///////////////////////////////////////////////
if ( ! function_exists( 'gallery_shortcode_filter' ) ) :
function gallery_shortcode_filter(){
add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 5,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $output = apply_filters('gallery_style', "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;           }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div id='$selector' class='gallery galleryid-{$id}'>");

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";
        // if ( $captiontag && trim($attachment->post_excerpt) ) {
        //     $output .= "
        //         <{$captiontag} class='gallery-caption'>
        //         " . wptexturize($attachment->post_excerpt) . "
        //         </{$captiontag}>";
        // }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
            <br style='clear: both;' />
        </div>\n";

    return $output;
}



///////////////////////////////////////////////
//FILTER wp_get_attachment_link
///////////////////////////////////////////////
function modify_attachment_link( $markup, $id, $size, $permalink, $icon, $text )
{
    // We need just thumbnails.
    if ( 'thumbnail' !== $size )
    {   // Return the original string untouched.
        return $markup;
    }

    // We have stored the new URL in a post meta field.
    // See http://wordpress.stackexchange.com/q/3097 for an example.
    $new_url = wp_get_attachment_url( $id );

    // if ( empty ( $new_url ) )
    // {   // There is no URL.
    //     return $markup;
    // }

    // Recreate the missing information.
    $_post      = & get_post( $id );
    $post_title = esc_attr( $_post->post_title );
    $post_excerpt = htmlentities($_post->post_excerpt, ENT_QUOTES);

    if ( $text ) 
    {
        $link_text = esc_attr( $text );
    } 
    elseif ( 
           ( is_int( $size )    && $size != 0 ) 
        or ( is_string( $size ) && $size != 'none' ) 
        or $size != FALSE 
    ) 
    {
        $link_text = wp_get_attachment_image( $id, $size, $icon );
    } 
    else 
    {
        $link_text = '';
    }

    if ( trim( $link_text ) == '' )
    {
        $link_text = $_post->post_title;
    }

    return "<a href='$new_url' title='$post_excerpt'>$link_text</a>";
}

add_filter( 'wp_get_attachment_link', 'modify_attachment_link', 9, 6 );

}
gallery_shortcode_filter();
endif;


if ( ! function_exists( 'bootstrap_filters' ) ) :
function bootstrap_filters(){
///////////////////////////////////////////////
//NEXT POST & PREVIOUS POST » BOOTSTRAP BUTTONS
///////////////////////////////////////////////
function next_posts_link_css($content) {
    return 'class="btn"';
}
add_filter('next_posts_link_attributes', 'next_posts_link_css' ); 

function previous_posts_link_css($content) {
    return 'class="btn"';
}
add_filter('previous_posts_link_attributes', 'previous_posts_link_css' ); 




///////////////////////////////////////////////
//WP-PAGENAVI » BOOTSTRAP BUTTONS
///////////////////////////////////////////////
function bs_pagenavi($html) {
    $output = '';
 
    $output = str_replace("class='previouspostslink'","class='btn previouspostslink'",$html);    
    $output = str_replace("class='pages","class='btn disabled pages",$output);
    $output = str_replace("class='first","class='btn first",$output);
    $output = str_replace("class='last","class='btn last",$output);
    $output = str_replace("class='page","class='btn page",$output);
    $output = str_replace("<span class='extend'>...","<span class='btn disabled extend'>&hellip;",$output);
    $output = str_replace("class='current","class='btn disabled current",$output);   
    $output = str_replace("class='larger","class='btn larger",$output);
    $output = str_replace("class='nextpostslink'","class='btn nextpostslink'",$output);
 
    return $output;
}
//attach our function to the wp_pagenavi filter
add_filter( 'wp_pagenavi', 'bs_pagenavi', 10, 2 );
}

bootstrap_filters();
endif;

