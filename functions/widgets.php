<?php
////////////////////////////////////////////////
//SECTION NAVIGATION
////////////////////////////////////////////////
if(!function_exists('get_post_top_ancestor_id')){
/**
 * Gets the id of the topmost ancestor of the current page. Returns the current
 * page's id if there is no parent.
 * 
 * @uses object $post
 * @return int 
 */
function get_post_top_ancestor_id(){
    global $post;
    
    if($post->post_parent){
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    }
    
    return $post->ID;
}}

function the_section_nav($id=null){
	global $post;
	if($id == null){
		$id = $post->ID;
	}
	$children = get_pages("child_of=$id");
	$output = "";
	if($post->post_parent || count($children) != 0){
		$top_id = get_post_top_ancestor_id();
		$output = "<aside id=\"sectionNav\" class=\"widget\">\n";
		$output .= "<h3 class=\"widgettitle\">".get_the_title($top_id)."</h3>\n";
		$output .= "<ul class=\"clearfix\">";
		$output .= wp_list_pages( array('title_li'=>'','depth'=>1, 'echo'=>0, 'child_of'=>$top_id) );;
		$output .= "</ul>";
		$output .= "</aside>";

		print($output);
	}
}


class SectionNavWidget extends WP_Widget
{
	function SectionNavWidget()
	{
	$widget_ops = array('classname' => 'SectionNavWidget', 'description' => 'Displays section navigation where necessary.' );
	$this->WP_Widget('SectionNavWidget', 'Section Navigation', $widget_ops);
	}
 
	function form(){
		echo "<p>Just place this widget where you'd like the navigaiton to go.</p><p>Section navigation will render only on pages where it is necessary.";
	}

	function widget($args){
	    extract($args, EXTR_SKIP);


		function get_top_ancestor_id(){
		    global $post;
		    
		    if($post->post_parent){
		        $ancestors = array_reverse(get_post_ancestors($post->ID));
		        return $ancestors[0];
		    }
		    
		    return $post->ID;
		}

		global $post;
		if($page_id == null){
			$page_id = $post->ID;
		}
		$children = get_pages("child_of=$page_id");
		$output = "";
		if(is_page()):
		if($post->post_parent || count($children) != 0){
			$top_id = get_top_ancestor_id();
			$top_link = get_permalink( $top_id );
			$output = $before_widget;
			$output .= $before_title."<a href='$top_link'>".get_the_title($top_id)."</a>".$after_title;
			$output .= "<ul class=\"clearfix\">";
			$output .= wp_list_pages( array('title_li'=>'','depth'=>2, 'echo'=>0, 'child_of'=>$top_id) );;
			$output .= "</ul>";
			$output .= $after_widget;

			print($output);
		}
		endif;
	}
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("SectionNavWidget");') );
