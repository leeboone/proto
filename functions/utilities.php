<?php

////////////////////////////////////////////////
//COUNT SIDEBAR WIDGETS
////////////////////////////////////////////////
if ( ! function_exists( 'count_sidebar_widgets' ) ) :
	function count_sidebar_widgets( $sidebar_id, $echo = false ) {
    $the_sidebars = wp_get_sidebars_widgets();
    if( !isset( $the_sidebars[$sidebar_id] ) )
        return __( 'Invalid sidebar ID' );
    if( $echo )
        echo count( $the_sidebars[$sidebar_id] );
    else
        return count( $the_sidebars[$sidebar_id] );
}
endif;



////////////////////////////////////////////////
//Pagination Nav
////////////////////////////////////////////////
if ( ! function_exists( 'pagination_nav' ) ) :
function pagination_nav( $nav_id ) {
	global $wp_query;

	$nav_id = esc_attr( $nav_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text">Post Navigation</h3>
			<?php next_posts_link('<i class="icon-arrow-left"></i> Older posts'); ?>
			<?php previous_posts_link('Newer posts <i class="icon-arrow-right"></i>'); ?>
		</nav><!-- #<?php echo $nav_id; ?> .navigation -->
	<?php endif;
}
endif;



if ( ! function_exists( 'page_part_links' ) ) :
function page_part_links(){
	$page_nav = custom_wp_link_pages( array( 'before' => '<div class="navbar"><div class="navbar-inner"><span class="brand">Pages:</span><ul class="nav">', 'after' => '</ul></div></div>', 'echo' => false  ));
	print $page_nav;
}
endif;
/**
 * The formatted output of a list of pages.
 *
 * Displays page links for paginated posts (i.e. includes the "nextpage".
 * Quicktag one or more times). This tag must be within The Loop.
 *
 * The defaults for overwriting are:
 * 'next_or_number' - Default is 'number' (string). Indicates whether page
 *      numbers should be used. Valid values are number and next.
 * 'nextpagelink' - Default is 'Next Page' (string). Text for link to next page.
 *      of the bookmark.
 * 'previouspagelink' - Default is 'Previous Page' (string). Text for link to
 *      previous page, if available.
 * 'pagelink' - Default is '%' (String).Format string for page numbers. The % in
 *      the parameter string will be replaced with the page number, so Page %
 *      generates "Page 1", "Page 2", etc. Defaults to %, just the page number.
 * 'before' - Default is '<p id="post-pagination"> Pages:' (string). The html 
 *      or text to prepend to each bookmarks.
 * 'after' - Default is '</p>' (string). The html or text to append to each
 *      bookmarks.
 * 'text_before' - Default is '' (string). The text to prepend to each Pages link
 *      inside the <a> tag. Also prepended to the current item, which is not linked.
 * 'text_after' - Default is '' (string). The text to append to each Pages link
 *      inside the <a> tag. Also appended to the current item, which is not linked.
 *
 * @param string|array $args Optional. Overwrite the defaults.
 * @return string Formatted output in HTML.
 */
if ( ! function_exists( 'custom_wp_link_pages' ) ) :
function custom_wp_link_pages( $args = '' ) {
	$defaults = array(
		'before' => '<p id="post-pagination">' . __( 'Pages:' ), 
		'after' => '</p>',
		'text_before' => '',
		'text_after' => '',
		'next_or_number' => 'number', 
		'nextpagelink' => __( 'Next page' ),
		'previouspagelink' => __( 'Previous page' ),
		'pagelink' => '%',
		'echo' => 1
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {
		if ( 'number' == $next_or_number ) {
			$output .= $before;
			for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
				$j = str_replace( '%', $i, $pagelink );
				$output .= ' ';
				if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
					$output .= '<li>'._wp_link_page( $i );
				else
					$output .= '<li class="active">'._wp_link_page( $i );

				$output .= $text_before . $j . $text_after;
				if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
					$output .= '</a></li>';
				else
					$output .= '</a></li>';
			}
			$output .= $after;
		} else {
			if ( $more ) {
				$output .= $before;
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $text_before . $previouspagelink . $text_after . '</a>';
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $text_before . $nextpagelink . $text_after . '</a>';
				}
				$output .= $after;
			}
		}
	}

	if ( $echo )
		echo $output;

	return $output;
}
endif;

//////////////////////////////////////////
//HANDLE TITLE-FREE POSTS
/////////////////////////////////////////
if ( ! function_exists( 'bulletproof_title' ) ) :
function bulletproof_title(){
	$title = get_the_title();
	if(!$title){
		$title="Title";
	}
	print $title;
}
endif;


//////////////////////////////////////////
//Email Shortcode
/////////////////////////////////////////
function email_encode_function( $atts, $content ){
	return '<a href="'.antispambot("mailto:".$content).'">'.antispambot($content).'</a>';
}
add_shortcode( 'email', 'email_encode_function' );



