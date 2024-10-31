<?php
/*
Plugin Name: Print Posts
Plugin URI: http://jaredharbour.com
Description: Adds posts to a page or post via a shortcode based on your options.
Author: Jared Harbour
Version: 1.0.1
Author URI: http://jaredharbour.com
*/


class JMH_Print_Posts{
	
	private $_tkversion = "0.5.2";
			
	public function __construct() { 
		define('PRINT_POSTS_PLUGPATH',WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)));
   		define('PRINT_POSTS_PLUGDIR',WP_PLUGIN_DIR.'/'.plugin_basename(dirname(__FILE__)));
		
		if( class_exists('ThemeKitForWP') ){
			$this->load_themekit_options();
		}
		$this->load_shortcodes();
	}
	
	function load_themekit_options(){
		$tk = new ThemeKitForWP();
		if( $tk->get_version() >= $this->_tkversion ){
			$tk->set_option_name('print-posts-settings');
			$tk->set_menu_title('Print Posts Shortcode Settings');
			$tk->set_menu_type('settings');
			
			$radius = array();
			for ($i = 0; $i < 15; $i++){ 
				$radius[] = array('id'=>'radius_'.$i,'name'=>$i.'px'); 
			}
			
			$opts = array ();
			
			$opts[] = array("desc" => "The settings below allow you to set some global properties for the shortcode.",
							"type" => "description");
									
			$opts[] = array("name" => "General Settings",
							"type" => "section");
			
			$opts[] = array("name" => "Number of expanded posts",
        					"desc" => "Sets the number of expanded posts.",
        					"id" => "expanded_posts",
        					"type" => "text",
        					"std" => "0");
        	
        	$opts[] = array("name" => "Plugin Stylesheet",
					        "desc" => "Check this to not include the stylesheet that came with this plugin.",
					        "id" => "kill_css",
					        "type" => "checkbox",
					        "std" => "",
					        "cbtext"=> "Turn Off Stylesheet");
					        
			$opts[] = array("name" => "Hide Post Header",
					        "desc" => "Check this to hide the header shown above the links.",
					        "id" => "kill_header",
					        "type" => "checkbox",
					        "std" => "",
					        "cbtext"=> "Turn Off Header");
			
			$opts[] = array("name" => "Header Style",
							"desc" => "",
							"id" => "pp_header",
							"std" => array('size' => '20','face' => 'Arial','style' => 'normal','color' => '#000000','underline'=>'none'),
							"type" => "typography",
							"selector" => "#print_posts h4.pp-header",
							"style" => "font");
							
			$opts[] = array("name" => "Link Style",
							"desc" => "",
							"id" => "pp_link",
							"std" => array('style' => 'normal','color' => '#000000','underline'=>'none'),
							"type" => "typography",
							"selector" => "#print_posts ul.print-posts-list li a,#print_posts ul.print-posts-list li a:link",
							"style" => "font");
								
			$opts[] = array("name" => "Link Visited",
			    			"desc" => "",
			    			"id" => "pp_link_visited",
			    			"std" => array('style' => 'normal','color' => '#000000','underline'=>'none'),
			    			"type" => "typography",
			    			"selector" => "#print_posts ul.print-posts-list li a:visited",
			    			"style" => "font");
			    				
			$opts[] = array("name" => "Link Active",
			    			"desc" => "",
			    			"id" => "pp_link_active",
			    			"std" => array('style' => 'normal','color' => '#000000','underline'=>'none'),
			    			"type" => "typography",
			    			"selector" => "#print_posts ul.print-posts-list li a:active",
			    			"style" => "font");
			    								
			$opts[] = array("name" => "Link Hover",
			    			"desc" => "",
			    			"id" => "pp_link_hover",
			    			"std" => array('style' => 'normal','color' => '#000000','underline'=>'underline'),
			    			"type" => "typography",
			    			"selector" => "#print_posts ul.print-posts-list li a:hover",
			    			"style" => "font");
			
			$opts[] = array("type" => "close");
			
			$opts[] = array("name" => "Expanded Post Settings",
							"type" => "section");
			
			$opts[] = array("name" => "Headline Style",
							"desc" => "",
							"id" => "pp_headline",
							"std" => array('size' => '14','face' => 'Arial','style' => 'normal','color' => '#000000','underline'=>'none'),
							"type" => "typography",
							"selector" => "#print_posts ul.print-posts-list li a.headline",
							"style" => "font");
			
			$opts[] = array("name" => "Headline Hover Style",
							"desc" => "",
							"id" => "pp_headline_hover",
							"std" => array('size' => '14','face' => 'Arial','style' => 'normal','color' => '#000000','underline'=>'none'),
							"type" => "typography",
							"selector" => "#print_posts ul.print-posts-list li a.headline:hover",
							"style" => "font");
			
			$opts[] = array("name" => "Read More Style",
							"desc" => "",
							"id" => "pp_readmore",
							"std" => array('size' => '14','face' => 'Arial','style' => 'normal','color' => '#000000','underline'=>'none'),
							"type" => "typography",
							"selector" => "#print_posts ul.print-posts-list li div.readmore a",
							"style" => "font");
			
			$opts[] = array("name" => "Read More Hover Style",
							"desc" => "",
							"id" => "pp_readmore_hover",
							"std" => array('size' => '14','face' => 'Arial','style' => 'normal','color' => '#000000','underline'=>'none'),
							"type" => "typography",
							"selector" => "#print_posts ul.print-posts-list li div.readmore a:hover",
							"style" => "font");
							
			$opts[] = array("name" => "Text Style Style",
							"desc" => "",
							"id" => "pp_excerpt",
							"std" => array('size' => '14','face' => 'Arial','style' => 'normal','color' => '#000000'),
							"type" => "typography",
							"selector" => "#print_posts ul.print-posts-list li div.excerpt",
							"style" => "font");
			
			$opts[] = array("name" => "Bottom Border",
							"desc" => "",
							"id" => "ex_post_border",
							"std" => array('width' => '1','style' => 'dashed','color' => '#c3c3c3'),
							"type" => "border",
							"selector" => "#print_posts ul.print-posts-list li.expanded-post-style",
							"style" => "border-bottom");
			
			$opts[] = array("name" => "Post Spacing",
							"desc" => "Enter an integer value i.e. 5 for the padding around each expanded post.",
							"id" => "ex_posts_padding",
							"type" => array( 
								array(  
									'id' => 'top',
									'type' => 'text',
									'std' => 0,
									'meta' => 'px',
									'label'=>'Top: '
									),
								array(
									'id' => 'bottom',
									'type' => 'text',
									'std' => 10,
									'meta' => 'px',
									'label'=>'Bottom: '
									),
								array(  
									'id' => 'left',
									'type' => 'text',
									'std' => 0,
									'meta' => 'px',
									'label'=>'Left: '
									),
								array(
									'id' => 'right',
									'type' => 'text',
									'std' => 0,
									'meta' => 'px',
									'label'=>'Right: '
									)
							),
							"selector" => "#print_posts ul.print-posts-list li.expanded-post-style",
							"style" => "ex-posts-padding");
			
			$opts[] = array("name" => "Image Location",
							"subtext"=>"",
							"desc" => "Changes the location of the post thumbnail",
							"id" => "ex_post_location",
							"type" => "select",
							"options" => array(
								array('id'=>'left','name'=>'Left'),
								array('id'=>'right','name'=>'Right')
							),
							"std" => 'left',
							"selector" => "#print_posts ul.print-posts-list li.expanded-post-style img",
							"style" => "ex-post-image-location");
									
			$opts[] = array("name" => "Image Border",
							"desc" => "",
							"id" => "ex_post_image_border",
							"std" => array('width' => '1','style' => 'solid','color' => '#c3c3c3'),
							"type" => "border",
							"selector" => "#print_posts ul.print-posts-list li.expanded-post-style img",
							"style" => "ex-post-image-border");
							
			$opts[] = array("name" => "Image Border Radius",
							"subtext"=>"",
							"desc" => "",
							"id" => "ex_post_border_radius",
							"type" => "select",
							"options" => $radius,
							"std" => 'radius_0',
							"selector" => "#print_posts ul.print-posts-list li.expanded-post-style img",
							"style" => "ex-post-image-border-radius");
				
			$opts[] = array("name" => "Image Spacing",
							"desc" => "Enter an integer value i.e. 5 for the padding around the image.",
							"id" => "ex_post_image_space",
							"type" => array( 
								array(  
									'id' => 'padding',
									'type' => 'text',
									'std' => 2,
									'meta' => 'px',
									'label'=>'Padding: ')
							),
							"selector" => "#print_posts ul.print-posts-list li.expanded-post-style img",
							"style" => "ex-post-image-padding");
			
			$opts[] = array("name" => "Image Background Color",
							"desc" => "",
							"id" => "ex_post_image_bg",
							"type" => "colorpicker",
							"std" => "#f1f1f1",
							"selector" => "#print_posts ul.print-posts-list li.expanded-post-style img",
							"style"=> "background-color");
			
			$opts[] = array("type" => "close");
			
			$tk->register_options($opts);
			
			add_filter('themekitforwp_css_engine_print-posts-settings',array(&$this,'print_posts_css_engine'), 10, 2);
		}
	}
	
	function print_posts_css_engine($reg_option, $saved){
		$styles = '';
		switch( $reg_option['style'] ){
			case 'ex-posts-padding':
		    	$styles .= 'padding:'.$saved[ $reg_option[ "id" ] ]['top'].'px '.$saved[ $reg_option[ "id" ] ]['right'].'px '.$saved[ $reg_option[ "id" ] ]['bottom'].'px '.$saved[ $reg_option[ "id" ] ]['left'].'px;';
		    break;
		    case 'ex-post-image-border':
		    	$styles .= 'border: '.$saved[ $reg_option[ "id" ] ]['color'].' '.$saved[ $reg_option[ "id" ] ]['style'].' '.$saved[ $reg_option[ "id" ] ]['width'].'px;';
		    break;
		    case 'ex-post-image-border-radius':
		    	$b = explode("_",$saved[ $reg_option[ "id" ] ]);
				$styles .= '-moz-border-radius: '.$b[1].'px;';
				$styles .= 'border-radius: '.$b[1].'px;';
		    break;
		    case 'ex-post-image-padding':
		    	$styles .= 'padding:'.$saved[ $reg_option[ "id" ] ]['padding'].'px;';
		    break;
		    case 'ex-post-image-location':
		    	
		    	$styles .= 'float:'.$saved[ $reg_option[ "id" ] ].';';
		    break;
		}
		return $styles;
	}
	
	function load_shortcodes(){
		if(!is_admin()){
			$options = get_option('print-posts-settings');
			add_shortcode("print_posts", array(&$this,'print_posts'));
			
			if(!$options['kill_css']){
				wp_register_style('print-posts-css', PRINT_POSTS_PLUGPATH.'/css/style.css');
        		wp_enqueue_style( 'print-posts-css');
			}
		}
	}
	
	function print_posts($params){
		extract(shortcode_atts(array(
    	    'tag' => null,
    	    'cat' => null,
    	    'category_name' => null,
    	    'display_count'=> '-1',
    	    'expanded_count'=> 0,
    	    'show_related_posts'=>false,
    	    'show_posts_by_author'=>false
    	), $params));
    	
    	$options = get_option('print-posts-settings');
    	
    	if($expanded_count == 0 && $options['expanded_posts'] > $expanded_count){
    		$expanded_count = $options['expanded_posts'];
    	}
    	
    	$qarray = array('post_status' => 'publish','posts_per_page'=>$display_count);
   
    	if($category_name != null){
    	    $qarray['category_name'] = $category_name;
    	}
    	if($cat != null){
    	    $qarray['cat'] = $cat;
    	}
    	if($tag != null){
    	    $qarray['tag'] = $tag;
    	}
    	
    	if($show_related_posts){
    		$tags = "";
    		$posttags = get_the_tags();
			if ($posttags) {
				foreach($posttags as $t) {
			    	$tags[] = $t->name;
				}
				$qarray['tag_slug__in'] = $tags;
			}
    	}
    	
    	if($show_posts_by_author){
    		$qarray['author_name'] = get_the_author_meta('user_nicename');
    		$qarray['post__not_in'] = array(get_the_ID());
    		$author_display_name = get_the_author_meta('display_name');
    	}
   		
    	$my_query = new WP_Query($qarray);
   		
   		$count = 0;
   		
    	if ($my_query->have_posts()){
    		$return = '<div id="print_posts">';
    		if(!$options['kill_header']){
    			$return .= '<h4 class="pp-header">';
    			if($show_related_posts){
    				if($show_posts_by_author){
    					$return .= "Related Posts by ".$author_display_name;
    				}else{
    					$return .= "Related Posts";
    				}
    				
    			}elseif($show_posts_by_author){
    				$return .= "Posts by ".$author_display_name;
    			}else{
    				$return .= "Related Posts";
    			}
    			$return .= "</h4>";
    		}
    		
    		$return .= "<ul class='print-posts-list'>";
    		while ($my_query->have_posts()){
    			$my_query->the_post();
    	   		
    	   		if($count < $expanded_count){
    	   			$return .= "<li class='expanded-post-style post-".get_the_ID()."'>";
           			
           			if(current_theme_supports('post-thumbnails') && has_post_thumbnail()){
           				$return .= get_the_post_thumbnail(get_the_ID(), 'thumbnail');
           			}
            							
            		$return .= "<div><a class='headline' href='".get_permalink()." ' title='". get_the_title()."'>". get_the_title()."</a></div>";
            		$return .= "<div class='excerpt'>".get_the_excerpt()."</div>";
           			
            		$return .= "<div class='readmore'><a href='".get_permalink()." ' title='". get_the_title()."'>read more</a></div>";
            		$return .= "</li>";
    	   		}else{
    	   			$return .= "<li><a class='headline' href='".get_permalink()." ' title='". get_the_title()."'>". get_the_title()."</a></li>";
    	   		}
    	   		
    	   		$count++;
    		}
    	} 
    	$return .= "</ul></div>";
   		wp_reset_postdata();
    	return $return;    	
	}
	
	function &init() {
		static $instance = false;
	
		if ( !$instance ) {
			$instance = new JMH_Print_Posts;
		}
		return $instance;
	}
}

add_action( 'init', array( 'JMH_Print_Posts', 'init' ) );
?>