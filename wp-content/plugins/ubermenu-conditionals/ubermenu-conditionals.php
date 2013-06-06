<?php
/*
Plugin Name: UberMenu Conditionals
Plugin URI: http://wpmegamenu.com/conditionals
Description: Control which menu items appear based on conditions
Version: 1.1
Author: Chris Mavricos, SevenSpark
Author URI: http://sevenspark.com
License: http://codecanyon.net/licenses/regular_extended
Copyright 2011-2012  Chris Mavricos, SevenSpark http://sevenspark.com
*/


function uberMenu_conditionals( $display_on , $walker , $element , $max_depth, $depth, $args ){

	//Default state is true, but may have been adjusted
	$id = $element->ID;
	$condition = $walker->getUberOption( $id, 'condition' );
	$param = $walker->getUberOption( $id, 'condition_parameter' );

	//Because these conditions are "ONLY"s, we don't care about the incoming $display_on parameter
	//Note: 'default' will maintain the incoming $display_on parameter
	if( $condition != 'default' && $condition != '' ){

		//echo "[$element->title | $condition | $param]";

		//Allow shortcodes
		$element->url = uberMenu_conditionals_dynamic_url( $element );

		//Handle params here
		if( $param ){
			//if commas, explode
			if( strpos( $param , ',' ) !== false ){
				$param = explode( ',' , $param );
			}
		}

		switch( $condition ){

			//Always display this menu item
			case 'always':
				return true;
				break;

			//Display only if user is currently logged in
			case 'user_logged_in':
				return is_user_logged_in();
				break;

			//Display only if user is currently logged out
			case 'user_logged_out':
				return !is_user_logged_in();
				break;

			case 'user_can':
				return current_user_can( $param );
				break;

			case 'user_cannot':
				return !current_user_can( $param );
				break;

			case 'is_front_page':
				return is_front_page();
				break;

			case 'not_front_page':
				return !is_front_page();
				break;

			case 'is_home':
				return is_home();
				break;

			case 'not_home':
				return !is_home();
				break;

			//Display only on pages with appropriate parameters
			case 'is_page':
				if( $param ) return is_page( $param );
				return is_page();
				break;

			case 'is_not_page':
				if( $param ) return !is_page( $param );
				return !is_page();
				break;


			case 'is_single':
				if( $param ) return is_single( $param );
				return is_single();
				break;

			case 'is_not_single':
				if( $param ) return !is_single( $param );
				return !is_single();
				break;

			case 'is_page_template':
				if( $param ) return is_page_template( $param );
				return is_page_template();
				break;

			case 'is_not_page_template':
				if( $param ) return !is_page_template( $param );
				return !is_page_template();
				break;

			case 'is_category':
				if( $param ) return is_category( $param );
				return is_category();
				break;

			case 'is_tag':
				if( $param ) return is_tag( $param );
				return is_tag();
				break;

			case 'is_tax':
				if( $param ) return is_tax( $param );
				return is_tax();
				break;

			case 'is_author':
				if( $param ) return is_author( $param );
				return is_author();
				break;

			case 'is_archive':
				return is_archive();
				break;

			case 'is_search':
				return is_search();
				break;

			case 'is_404':
				return is_404();
				break;

			case 'is_singular':
				if( $param ) return is_singular( $param );
				return is_singular();
				break;



			/* 1.1 */
			case 'is_post_type':
				return uberMenu_conditionals_is_post_type( $param );
				break;
		
		}

		//http://codex.wordpress.org/Conditional_Tags		
	}

	return $display_on;
}

add_filter( 'uberMenu_display_item', 'uberMenu_conditionals', 10, 6 );


function uberMenu_conditionals_option( $item_id , $menu ){

	$menu->showCustomMenuOption(
		'condition', 
		$item_id, 
		array(
			'level' => '0-plus', 
			'title' => __( 'Display this menu item ONLY if the following conditions are met' ), 
			'label' => __( 'Conditional Display: Show item ' ), 			
			'type' => 'select', 
			'ops'	=> array(
				'default' 				=> ' ',
				'always'				=> __( 'Always' ),
				'user_logged_in' 		=> __( 'If user is logged in' ),
				'user_logged_out' 		=> __( 'If user is not logged in' ),
				'user_can'				=> __( 'If user can [capability]' ),
				'user_cannot'			=> __( 'If user cannot [capability]' ),
				'is_front_page'			=> __( 'On front page' ),
				'not_front_page'		=> __( 'Not on front page' ),
				'is_home'				=> __( 'On home page (main blog)' ),
				'not_home'				=> __( 'Not on home page (main blog)' ),
				'is_page'				=> __( 'On a page' ),
				'is_not_page'			=> __( 'Not on a page' ),
				'is_single'				=> __( 'On a single Post' ),
				'is_not_single'			=> __( 'Not on a single Post' ),
				'is_page_template'		=> __( 'On a page template' ),
				'is_not_page_template' 	=> __( 'Not on a page template' ),
				'is_category'			=> __( 'On a Category Archive' ),
				'is_tag'				=> __( 'On a Tag Archive' ),
				'is_tax'				=> __( 'On a Taxonomy Archive' ),
				'is_author'				=> __( 'On an Author Archive page' ),
				'is_archive'			=> __( 'On any archive page' ),
				'is_search'				=> __( 'On Search Results page' ),
				'is_404'				=> __( 'On 404 page' ),
				'is_singular'			=> __( 'On a single Page, Post, or Attachment' ),

				/* 1.1 */
				'is_post_type'			=> __( 'On a Post Type [type]' ),
			),
		)
	);

	$menu->showCustomMenuOption(
		'condition_parameter', 
		$item_id, 
		array(
			'level' => '0-plus', 
			'title' => __('Optional parameters to pass to the selected conditional function.  Comma-separated lists will be converted to arrays.'), 
			'label' => __('Conditional Parameters'), 			
			'type' => 'text',
		)
	);

}
add_action( 'ubermenu_extended_menu_item_options' , 'uberMenu_conditionals_option' , 10 , 2 );

function uberMenu_conditionals_option_value_defaults( $defaults ){
	$defaults[ 'menu-item-condition' ] = 'default';
	$defaults[ 'menu-item-condition_parameter' ] = '';
	return $defaults;
}
add_filter( 'uberMenu_menu_item_options_value_defaults' , 'uberMenu_conditionals_option_value_defaults' );

function uberMenu_conditionals_define_walker(){
	require_once( 'UberMenuConditionalWalker.class.php' );
}
add_action( 'uberMenu_load_dependents' , 'uberMenu_conditionals_define_walker' );

function uberMenu_conditionals_set_walker( $args ){
	if( $args['container_id'] == 'megaMenu' ){
		$args['walker'] = new UberMenuConditionalWalker();
	}
	return $args;
}
add_filter( 'wp_nav_menu_args' , 'uberMenu_conditionals_set_walker', 2100 );





/* Custom Conditionals */

/* Since 1.1 */
function uberMenu_conditionals_is_post_type( $param ){
	
	$post_type = get_post_type();

	if( is_array( $param ) ){
		if( in_array( $post_type , $param ) ){
			return true;
		}
	}
	else{
		if( $post_type == $param ){
			return true;
		}
	}

	return false;
}





/* Dynamic URLs - since 1.1 */

function uberMenu_conditionals_dynamic_url( $element ){
	$url = $element->url;

	if( strpos( $url , '#umcdu-' ) === 0 ){
		$url = do_shortcode( '['. substr( $element->url , 1 ) . ']' ) ;
	}

	return $url;
}

//Logout shortcode
function uberMenu_conditionals_logout_shortcode( $atts , $content ){
	extract( shortcode_atts( array(
		'redirect' => home_url()
	), $atts) );

	return wp_logout_url( $redirect );
}
add_shortcode( 'umcdu-logout', 'uberMenu_conditionals_logout_shortcode' );




/*
// Sample Custom Filter
function my_custom_conditional_filter( $display_on , $walker , $element , $max_depth, $depth, $args ){

	//The ID of the menu item currently being filtered
	$id = $element->ID;

	//Check for that specific menu item
	if( $id == 268 ){

		//If we're currently logged in AND on the front page
		if( is_user_logged_in() && is_front_page() ){

			//Disable the menu item
			$display_on = false;

		}

	}

	return $display_on;
}
add_filter( 'uberMenu_display_item', 'my_custom_conditional_filter', 20, 6 );
*/
