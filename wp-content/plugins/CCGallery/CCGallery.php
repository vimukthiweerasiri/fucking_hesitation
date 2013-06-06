<?php
/*
Plugin Name: CCGallery WP
Plugin URI: http://codecanyon.net/user/cosmocoder
Description: Add CCGallery to your WP theme
Version: 2.1.1
Author: Nilok Bose (CosmoCoder)
Author URI: http://codecanyon.net/user/cosmocoder
*/



//check the WP version (should be version 3.0 or greater)
register_activation_hook( __FILE__, 'ccgallery_install' );
        
function ccgallery_install() {
    if ( version_compare( get_bloginfo( 'version' ), '3.3', ' < ' ) ) {
        deactivate_plugins( basename( __FILE__ ) ); // Deactivate ccgallery plugin
    }
    
    // create the default list of ccgallery options
    $default_params = array(
        'colorScheme' => 'dark',
        'startMode' => 'coverflow',
        'coverflowFade' => 'true',
        'noReflection' => 'false',
        'newWindowLinks' => 'false',
        'detectMobile' => 'false',
        'autoplay' => 'true',
        'loop' => 'false',
		'storeVolume' => 'false',
        'showFileTypeButtons' => 'true',
        'hideMenu' => 'false',
        'startCategory' => 'all',
        'coverflowImgWidth' => 200,
        'coverflowImgHeight' => 125,
        'thumbnailImgWidth' => 200,
        'thumbnailImgHeight' => 150
    );
    
    update_option( 'ccgallery_default', $default_params );
    
    
    // insert missing values for options introduced in the new version for previously created galleries in older versions
    $gallery_ids = get_option( 'ccgallery_ids' );
    $ccgallery_options = get_option('ccgallery_options' );
    
    if( $gallery_ids ) {
        foreach( $gallery_ids as $gallery_id ) {
            foreach( $default_params as $key => $val ) {
                if( !isset( $ccgallery_options[ $gallery_id ][ $key ] ) || $ccgallery_options[ $gallery_id ][ $key ] === '' ) {
                    $ccgallery_options[ $gallery_id ][ $key ] = $val;
                }
            }
        }
        
        update_option( 'ccgallery_options', $ccgallery_options );
    }
}




// URL of plugin folder
define( 'ccgallery_path', plugin_dir_url( __FILE__), true );

// URL of the /js directory of the plugin
define( 'ccgallery_js_path', plugin_dir_url( __FILE__).'js', true );

// URL of the /css directory of the plugin
define( 'ccgallery_css_path', plugin_dir_url( __FILE__).'css', true );

// create the folder where uploaded images for ccgallery will be stored
$wp_upload_directory = wp_upload_dir();
$wp_upload_folder = $wp_upload_directory['basedir'];
$wp_upload_url = $wp_upload_directory['baseurl'];
define( 'ccgallery_upload_folder', $wp_upload_folder.'/ccgallery-upload', true );
define( 'ccgallery_upload_url', $wp_upload_url.'/ccgallery-upload', true );

if( !file_exists( ccgallery_upload_folder ) ) {
    if( !mkdir( ccgallery_upload_folder, 0777, true ) ) {
        wp_die('Cannot create upload folder!');   
    }
}



//create menus for CCGallery in admin page
add_action( 'admin_menu', 'ccgallery_create_menu' );

function ccgallery_create_menu() {
    //create CCGallery top level menu
    add_menu_page( 'CCGallery', 'CCGallery', 'manage_options', 'ccgallery_manager', 'ccgallery_manager_page' );
    
    //create sub-menu items
    $manager_page = add_submenu_page( 'ccgallery_manager', 'CCGallery - Gallery Manager', 'Gallery Manager', 'manage_options', 'ccgallery_manager', 'ccgallery_manager_page' );
    $options_page = add_submenu_page( 'ccgallery_manager', 'CCGallery - Add/Edit Gallery', 'Create New Gallery', 'manage_options', 'ccgallery_options', 'ccgallery_options_page' );
    
    // hook to load scripts in ccgallery options page
    add_action( 'load-'.$options_page, 'ccgallery_admin_scripts' );
}


//load the manager page
function ccgallery_manager_page() {
    // Check that the user is allowed to update options
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    
    require_once('CCGallery-Manager.php');
}


//load the options page
function ccgallery_options_page() {    
    // Check that the user is allowed to update options
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    
    require_once('CCGallery-Options.php');
}


// replace Wordpress's version of jQuery with that from Google for the front-end
//add_action( 'wp_print_scripts', 'cc_load_jquery' );
/*
function cc_load_jquery() {
    $protocol = isset( $_SERVER['HTTPS']) ? 'https://' : 'http://';

	if ( !is_admin() ) {
        $url = $protocol.'ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js';
        wp_deregister_script('jquery');
        
        if ( get_transient('google_jquery') == true ) {
            wp_register_script('jquery', $url, array(), '1.9.1');
        } 
        else {
            $resp = wp_remote_head($url);
            
            if ( !is_wp_error($resp) && 200 == $resp['response']['code'] ) {
                set_transient('google_jquery', true, 60 * 10);
                wp_register_script('jquery', $url, array(), '1.9.1');
            } 
            else {
                set_transient('google_jquery', false, 60 * 10);
                $url = ccgallery_js_path.'/jquery-1.9.1.min.js';
                wp_register_script('jquery', $url, array(), '1.9.1');
            }
        }
        
        wp_enqueue_script('jquery');
    }        
}*/


// load scripts in ccgallery options page
function ccgallery_admin_scripts() {
    wp_enqueue_style( 'ccgallery_upload_css', ccgallery_css_path.'/fileuploader.css', array(), '2.1.1' );
    wp_enqueue_style( 'ccgallery_admin_css', ccgallery_css_path.'/admin.css', array('ccgallery_upload_css'), '2.1.1' );
    
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'ccgallery_upload_js', ccgallery_js_path.'/fileuploader.js', array(), '2.1.1' );
    wp_enqueue_script( 'ccgallery_admin_js', ccgallery_js_path.'/admin.js', array('jquery', 'jquery-ui-sortable', 'ccgallery_upload_js'), '2.1.1' );
    
    
    // Get current page protocol
    $protocol = isset( $_SERVER['HTTPS']) ? 'https://' : 'http://';
    
    // get url to admin-ajax.php
    $ajaxurl = admin_url( 'admin-ajax.php', $protocol );
    
    
    $upload_params = array(
        'upload_php' => ccgallery_path.'includes/upload.php',
        'upload_folder' => ccgallery_upload_folder,
        'upload_url' => ccgallery_upload_url,
        'ajaxurl' => $ajaxurl
    );
    
    wp_localize_script( 'ccgallery_admin_js', 'uploadParams', $upload_params );
}


//load ccgallery jquery plugin and css file when Wordpress loads the required theme
//add_action( 'template_redirect', 'ccgallery_insert_scripts_blog' );
/*
function ccgallery_insert_scripts_blog() {    
    wp_enqueue_script( 'jquery' );
    //wp_enqueue_script( 'ccgallery_slider', ccgallery_js_path.'/jquery-ui-1.9.0.slider.min.js', array('jquery'), '1.9.0', true );
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script( 'ccgallery_touch_punch', ccgallery_js_path.'/jquery.ui.touch-punch.min.js', array('jquery', 'jquery-ui-slider'), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_mousewheel', ccgallery_js_path.'/jquery.mousewheel.min.js', array('jquery'), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_quicksand', ccgallery_js_path.'/jquery.quicksand.mod.min.js', array('jquery'), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_innershiv', ccgallery_js_path.'/innershiv.min.js', array(), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_mediaelement_js', ccgallery_path.'/mediaelement/mediaelement-and-player.min.js', array('jquery'), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_modernizr', ccgallery_js_path.'/modernizr.3d.js', array(), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_js', ccgallery_js_path.'/jquery.ccgallery.js', array('jquery', 'jquery-ui-slider', 'ccgallery_touch_punch',  'ccgallery_mousewheel', 'ccgallery_quicksand', 'ccgallery_innershiv', 'ccgallery_mediaelement_js', 'ccgallery_modernizr'), '2.1.1', true );
}*/



// shortcode for CCGallery
add_shortcode('ccgallery', 'ccgallery_shortcode' );

global $ccgallery_insert_js;

function ccgallery_shortcode( $attr ) {    
    global $ccgallery_insert_js;
    $ccgallery_insert_js = true;
    
    $gallery_id = $attr['id'];
    $ccgallery_options = get_option( 'ccgallery_options' );
    $gallery_option = $ccgallery_options[ $gallery_id ];
        
    $protocol = isset( $_SERVER['HTTPS']) ? 'https://' : 'http://';
    $ajaxurl = admin_url( 'admin-ajax.php', $protocol );
    $galleryParams = array(
        'pluginUrl' => ccgallery_path,
        'ajaxUrl' => $ajaxurl,
        'id' => $gallery_id
    );
    
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-slider' );
    wp_enqueue_script( 'ccgallery_touch_punch', ccgallery_js_path.'/jquery.ui.touch-punch.min.js', array('jquery', 'jquery-ui-slider'), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_mousewheel', ccgallery_js_path.'/jquery.mousewheel.min.js', array('jquery'), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_quicksand', ccgallery_js_path.'/jquery.quicksand.mod.min.js', array('jquery'), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_innershiv', ccgallery_js_path.'/innershiv.min.js', array(), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_mediaelement_js', ccgallery_path.'/mediaelement/mediaelement-and-player.min.js', array('jquery'), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_modernizr', ccgallery_js_path.'/modernizr.3d.js', array(), '2.1.1', true );
    wp_enqueue_script( 'ccgallery_js', ccgallery_js_path.'/jquery.ccgallery.min.js', array('jquery', 'jquery-ui-slider', 'ccgallery_touch_punch',  'ccgallery_mousewheel', 'ccgallery_quicksand', 'ccgallery_innershiv', 'ccgallery_mediaelement_js', 'ccgallery_modernizr'), '2.1.1', true );
    wp_localize_script( 'ccgallery_js', 'galleryParams', $galleryParams );
    
    
    if( $gallery_option['colorScheme'] === 'light') {
        $color = 'class="light"';
    }
    else {
        $color = '';
    }
    
    if( $gallery_option['coverflowFade'] === 'true' ) {
        $coverflowbg = ' data-coverflow-fade="true"';
        
        if( isset($gallery_option['coverflowBg']) && $gallery_option['coverflowBg'] !== '' ) {
            $coverflowbg .= ' data-background="'.$gallery_option['coverflowBg'].'"';
        }
    }
    else {
        $coverflowbg = ' data-coverflow-fade="false"';
    }
    
    if( isset($gallery_option['coverflowStartItem']) && $gallery_option['coverflowStartItem'] !== '' ) {
        $startItem = ' data-cover-start-item="'.$gallery_option['coverflowStartItem'].'"';
    }
    else {
        $startItem = '';
    }
    
    
    if( $gallery_option['noReflection'] === 'true' ) {
        $noReflection = ' data-no-reflection="'.$gallery_option['noReflection'].'"';
    }
    else {
        $noReflection = '';
    }
    
    
    if( $gallery_option['newWindowLinks'] === 'true' ) {
        $newWindowLinks= ' data-new-window-links="'.$gallery_option['newWindowLinks'].'"';
    }
    else {
        $newWindowLinks = '';
    }
    
    
    if( $gallery_option['detectMobile'] === 'true' ) {
        $mobile = ' data-mobile="true"';
    }
    else {
        $mobile = '';
    }
    
    
    if( $gallery_option['autoplay'] === 'true' ) {
        $autoplay = ' data-autoplay="true"';
    }
    else {
        $autoplay = '';
    }
    
    
    if( $gallery_option['loop'] === 'true' ) {
        $loop = ' data-loop="true"';
    }
    else {
        $loop = '';
    }


	if( $gallery_option['storeVolume'] === 'true' ) {
        $storeVolume = ' data-store-volume="true"';
    }
    else {
        $storeVolume = '';
    }
    
    $gallery_html = '';
    
    $gallery_html .= '<div id="ccgallery"'. $color . $coverflowbg . $startItem . $noReflection . $newWindowLinks .  $mobile . $autoplay . $loop . $storeVolume .'>';
	$hideMenu = $gallery_option['hideMenu'] === 'true' ? ' style="display: none"' : '';
    $gallery_html .=	'<menu type="toolbar"'.$hideMenu.'>';
    
    if( $gallery_option['hideCoverflow'] === 'true' || $gallery_option['hideThumbnails'] === 'true' ) {
        $gallery_html.= '<div class="buttonset" id="displayButtons" style="display:none">';
    }
    else {
        $gallery_html.= '<div class="buttonset" id="displayButtons">';
    }
    
    if( $gallery_option['startMode'] === 'coverflow' ) {
        $gallery_html .= '<a class="navbuttons active" id="gocoverflow">Coverflow</a>
				<a class="navbuttons" id="gothumbs">Thumbnails</a>';
    }
    else if( $gallery_option['startMode'] === 'thumbnail' ) {
        $gallery_html .= '<a class="navbuttons" id="gocoverflow">Coverflow</a>
				<a class="navbuttons active" id="gothumbs">Thumbnails</a>';
    }
    
	$gallery_html .= '</div>';
			
	$gallery_html .= '<div class="buttonset" id="sortButtons">';
	
    $start = $gallery_option['startCategory'] === 'all' ? ' active' : '';
    $gallery_html .= '<a class="navbuttons'.$start.'" id="all" data-type="all">All</a>';
        
    if( $gallery_option['showFileTypeButtons'] === 'true' ) {        
        $start = $gallery_option['startCategory'] === 'photo' ? ' active' : '';
        $gallery_html .= '<a class="navbuttons'.$start.'" id="photos" data-type="photo">Photos</a>';
        
        $start = $gallery_option['startCategory'] === 'audio' ? ' active' : '';
		$gallery_html .= '<a class="navbuttons'.$start.'" id="audios" data-type="audio">Audios</a>';
        
        $start = $gallery_option['startCategory'] === 'video' ? ' active' : '';
		$gallery_html .= '<a class="navbuttons'.$start.'" id="videos" data-type="video">Videos</a>';
    }
    
    if( isset($gallery_option['categories']) && $gallery_option['categories'] !== '' ) {
        $category_arr = array();
        $category_arr = explode(',', $gallery_option['categories']);
        foreach( $category_arr as $cat ) {
            $cat_name = strtolower( trim($cat) );
            $start = $gallery_option['startCategory'] === $cat_name ? ' active' : '';
            $gallery_html .= '<a class="navbuttons'.$start.'" data-category="'.$cat_name.'">'.$cat.'</a>';
        }
    }
    
    $hideCoverflow = $gallery_option['hideCoverflow'] === 'true' ? ' style="display: none"' : '';
    $hideThumbnails = $gallery_option['hideThumbnails'] === 'true' ? ' style="display: none"' : '';
    $hideCoverflowList = $gallery_option['hideCoverflowList'] === 'true' ? ' style="display: none"' : '';
	
    $gallery_html .= '</div>
		</menu>		
		
		<section class="displayStyle" id="coverflowGallery"'. $hideCoverflow .'>
			<div id="coverContainer"></div>
			
			<div id="scroll-wrap">
				<a id="next"></a>
				<div id="scrollbar-track">
					<a href="#" class="ui-slider-handle"></a>
				</div>
				<a id="prev"></a>
			</div>
			
			<div id="listWrapper"'. $hideCoverflowList .'>
				<ol id="itemList"></ol>
			</div>
		</section>  <!-- end #coverflowGallery -->
		
		<section class="displayStyle" id="thumbGallery"'. $hideThumbnails .'>
			<ul></ul>
		</section>  <!-- end #thumbGallery -->
	</div>  <!-- end #ccgallery -->';
    
    
    return $gallery_html;
}


// function to return xml data for gallery
add_action( 'wp_ajax_ccgallery_xml', 'ccgallery_xml' );
add_action( 'wp_ajax_nopriv_ccgallery_xml', 'ccgallery_xml' );

function ccgallery_xml() {
    header('Content-Type: text/xml');
    
    require_once('includes/cc_vt_resize.php');
    
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<CCGallery>';
    
    $id = $_REQUEST['id'];
    $mobile = $_REQUEST['mobile'];
    $ccgallery_options = get_option( 'ccgallery_options' );
    $gallery_options = $ccgallery_options[$id];
    $itemnum = count( $gallery_options['items'] );
    
    for( $i = 0; $i < $itemnum; $i++ ) {
        $filetype = $gallery_options['fileTypeVal'][$i];
        echo '<file type="'.$filetype.'">';
        
        if( isset($gallery_options['itemCategories'][$i]) && $gallery_options['itemCategories'][$i] !== '' ) {
            $category_arr = array();
            $category_arr = explode(',', $gallery_options['itemCategories'][$i]);
            foreach( $category_arr as $cat ) {
                $cat_name = strtolower( trim($cat) );
                echo '<category>'.$cat_name.'</category>';
            }   
        }
        
        $cover = cc_vt_resize(null, $gallery_options['imagefile'][$i], $gallery_options['coverflowImgWidth'], $gallery_options['coverflowImgHeight'], true);
        $thumb = cc_vt_resize(null, $gallery_options['imagefile'][$i], $gallery_options['thumbnailImgWidth'], $gallery_options['thumbnailImgHeight'], true);
        
        if( !is_wp_error($cover) ) {
            echo '<cover>'.ccgallery_upload_url.'/'.basename($cover['url']).'</cover>';
        }
        
        if( !is_wp_error($thumb) ) {
            echo '<thumb>'.ccgallery_upload_url.'/'.basename($thumb['url']).'</thumb>';
        }
        
        if( $filetype === 'photo' ) {
            echo '<source>'.$gallery_options['imagefile'][$i].'</source>';
        }
        else if( $filetype === 'audio' ) {
            if( isset($gallery_options['mp3file'][$i]) && $gallery_options['mp3file'][$i] !== '' ) {
                echo '<source>'.$gallery_options['mp3file'][$i].'</source>';   
            }
            
            if( isset($gallery_options['oggfile'][$i]) && $gallery_options['oggfile'][$i] !== '' ) {
                echo '<source>'.$gallery_options['oggfile'][$i].'</source>';   
            }
        }
        else if( $filetype === 'video' ) {
            if( $mobile === 'true' ) {
                echo '<source>'.$gallery_options['mp4mobile'][$i].'</source>';
            }
            else {
                if( isset($gallery_options['mp4file'][$i]) && $gallery_options['mp4file'][$i] !== '' ) {
                    echo '<source>'.$gallery_options['mp4file'][$i].'</source>';   
                }
                
                if( isset($gallery_options['webmfile'][$i]) && $gallery_options['webmfile'][$i] !== '' ) {
                    echo '<source>'.$gallery_options['webmfile'][$i].'</source>';   
                }
                
                if( isset($gallery_options['ogvfile'][$i]) && $gallery_options['ogvfile'][$i] !== '' ) {
                    echo '<source>'.$gallery_options['ogvfile'][$i].'</source>';   
                }
            }
            
            if( isset($gallery_options['youtube'][$i]) && $gallery_options['youtube'][$i] !== '' ) {
                echo '<source>'.$gallery_options['youtube'][$i].'</source>';   
            }
            
            if( isset($gallery_options['vimeo'][$i]) && $gallery_options['vimeo'][$i] !== '' ) {
                echo '<source>'.$gallery_options['vimeo'][$i].'</source>';   
            }
        }
        
        echo '<title><![CDATA['.stripcslashes($gallery_options['itemTitle'][$i]).']]></title>';
        echo '<description><![CDATA['.stripcslashes($gallery_options['itemCaption'][$i]).']]></description>';
        echo '<link><![CDATA['.stripcslashes($gallery_options['link'][$i]).']]></link>';
        
        echo '</file>';
    }
    
    echo '</CCGallery>';
    die();
}


// enqueue stylesheets only if shortcode is present
add_action( 'the_posts', 'ccgallery_enqueue_css' );

function ccgallery_enqueue_css( $posts ) {
    $found = false;
	$pattern = '/\[(\[?)ccgallery(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/s';
	$matches = array();
    
    foreach ($posts as $post) {
        preg_match_all($pattern, $post->post_content, $matches);
		if ( !empty($matches[0]) ) {
            $found = true;
            break;
        }
    }
    
    if( $found ) {
        $id = array_pop( explode( '=', $matches[2][0] ) );
		$id = intval( preg_replace("/[^0-9]/", "", $id ) );
		$ccgallery_options = get_option( 'ccgallery_options' );
		$gallery_options = $ccgallery_options[ $id ];
		wp_enqueue_style( 'ccgallery_css', ccgallery_css_path.'/ccgallery.css', array(), '2.1.1' );
        wp_enqueue_style( 'ccgallery_mediaelement_css', ccgallery_path.'/mediaelement/mediaelementplayer.min.css', array(), '2.1.1' );
    }
    
    return $posts;
}

add_action( 'template_include', 'ccgallery_check_template' );

function ccgallery_check_template( $template ) {
	$found = false;
	$pattern = '/\[(\[?)ccgallery(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/s';
	$matches = array();
	$files = array( $template, get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'header.php', get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'footer.php' );
    
    foreach ($files as $file) {
        if( file_exists($file) ) {
			$contents = file_get_contents($file);
			preg_match_all($pattern, $contents, $matches);
			if ( !empty($matches[0]) ) {
				$found = true;
				break;
			}	
		}
    }
    
    if( $found ) {
        $id = array_pop( explode( '=', $matches[2][0] ) );
		$id = intval( preg_replace("/[^0-9]/", "", $id ) );
		$ccgallery_options = get_option( 'ccgallery_options' );
		$gallery_options = $ccgallery_options[ $id ];
		wp_enqueue_style( 'ccgallery_css', ccgallery_css_path.'/ccgallery.css', array(), '2.1.1' );
        wp_enqueue_style( 'ccgallery_mediaelement_css', ccgallery_path.'/mediaelement/mediaelementplayer.min.css', array(), '2.1.1' );
    }
    
    return $template;
}


// enqueue stylesheets only if shortcode is present
//add_action( 'the_posts', 'ccgallery_enqueue_css' );
/*
function ccgallery_enqueue_css( $posts ) {
    if( empty($posts) ) {
        return $posts;
    }
    
    $found = false;
    
    foreach ($posts as $post) {
        if ( stripos( $post->post_content, '[ccgallery' ) !== false ) {
            $found = true;
            break;
        }
    }
    
    if( $found ) {
        wp_enqueue_style( 'ccgallery_css', ccgallery_css_path.'/ccgallery.css', array(), '2.1' );
        wp_enqueue_style( 'ccgallery_mediaelement_css', ccgallery_path.'/mediaelement/mediaelementplayer.min.css', array(), '2.1' );
    }
    
    return $posts;
}*/


// remove scripts if the shortcode is not present
//add_action( 'wp_print_footer_scripts', 'ccgallery_remove_scripts', 1 );
/*
function ccgallery_remove_scripts() {
    global $ccgallery_insert_js;
    if( !$ccgallery_insert_js ) {
        wp_dequeue_script( 'ccgallery_slider' );
        wp_deregister_script( 'jquery-touch-punch' );
        wp_deregister_script( 'ccgallery_mousewheel' );
        wp_deregister_script( 'ccgallery_quicksand' );
        wp_deregister_script( 'ccgallery_innershiv' );
        wp_deregister_script( 'ccgallery_mediaelement_js' );
        wp_deregister_script( 'ccgallery_modernizr' );
        wp_deregister_script( 'ccgallery_js' );
    }
}*/



// function to delete files on ajax call
add_action( 'wp_ajax_delete_files', 'ccgallery_delete_uploaded_files' );

function ccgallery_delete_uploaded_files() {
    // if the file is an image then locate all images generated from the original and delete them
    $file_name = pathinfo($_REQUEST['name']);
    $allfiles = glob( ccgallery_upload_folder.'/'.$file_name['filename'].'-*');
    foreach( $allfiles as $file ) {
        if( pathinfo( $file, PATHINFO_EXTENSION) == $file_name['extension']) {
            unlink($file);    
        }        
    }
    
    // then delete the original file
    $file_name = basename( $_REQUEST['name'] );
    if( $file_name !== '' && file_exists( ccgallery_upload_folder.'/'.$file_name ) ) {
        unlink( ccgallery_upload_folder.'/'.$file_name );
    }
}


?>