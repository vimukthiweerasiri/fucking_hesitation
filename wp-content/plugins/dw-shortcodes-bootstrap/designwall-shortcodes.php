<?php
/*
Plugin Name: DW Shortcode Bootstrap
Plugin URI: http://www.designwall.com
Description: A simple shortcode generator. Add buttons, columns, tabs, toggles and alerts to your theme.
Version: 2.0
Author: DesignWall 
Author URI: http://www.designwall.com
*/

require_once('inc/dws_grid.php');
require_once('inc/dws_alert.php');
require_once('inc/dws_buttons.php');
require_once('inc/dws_tabs.php');
require_once('inc/dws_collapse.php');
require_once('inc/dws_icons.php');

class DesignwallShortcodes{
	
	function __construct()
	{
		//require_once('shortcodes.php');
		add_action('init',array(&$this, 'init'));
		add_action('admin_menu', array(&$this, 'dw_add_options_page'));
		register_activation_hook(__FILE__, array(&$this, 'dwsc_add_defaults'));
		add_action('admin_init', array(&$this, 'dwsc_init'));
	}
	
	function init(){
		$options = get_option('dwsc_options');
		if(!is_admin()){
			if($options['chk_default_options_css']){
			 	wp_enqueue_style("dws_bootstrap", plugins_url('assets/css/bootstrap.css', __FILE__ ));
				wp_enqueue_style("dws_shortcodes", plugins_url('assets/css/shortcodes.css', __FILE__ ));
			}
			if($options['chk_default_options_js'])
				wp_enqueue_script('dws_bootstrap', plugins_url('assets/js/bootstrap.js', __FILE__ ),array('jquery'));
		} else {
			wp_enqueue_style("dws_admin_style", plugins_url('assets/css/admin.css', __FILE__ ));
		}

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	    	return;
		}
	 
		if ( get_user_option('rich_editing') == 'true' ) {
		//	wp_enqueue_style("dws_bootstrap", plugins_url('assets/css/bootstrap.css', __FILE__ ));
			add_filter( 'mce_external_plugins', array(&$this, 'regplugins') );
			add_filter( 'mce_buttons_3', array(&$this, 'regbtns') );
		}
	}

	function regbtns($buttons)
	{
		array_push($buttons, 'dws_grid');
		array_push($buttons, 'dws_alerts');
		array_push($buttons, 'dws_buttons');
		array_push($buttons, 'dws_icons');
		array_push($buttons, 'dws_tabs');
		array_push($buttons, 'dws_collapse');
		return $buttons;
	}

	function regplugins($plgs)
	{
		
		$plgs['dws_grid'] = plugins_url('assets/js/plugins/grid.js', __FILE__ );
		$plgs['dws_alerts'] = plugins_url('assets/js/plugins/alert.js', __FILE__ );
		$plgs['dws_buttons'] = plugins_url('assets/js/plugins/buttons.js', __FILE__ );
		$plgs['dws_tabs'] = plugins_url('assets/js/plugins/tabs.js', __FILE__ );
		$plgs['dws_icons'] = plugins_url('assets/js/plugins/icons.js', __FILE__ );
		$plgs['dws_collapse'] = plugins_url('assets/js/plugins/collapse.js', __FILE__ );
		return $plgs;
	}

	/* Add menu page. */
	function dw_add_options_page() {
		add_options_page(__('DW Shortcodes options','dwshortcodes'), __('DW Shortcode options','dwshortcodes'), 'manage_options', __FILE__, array(&$this, 'dw_render_form'));
	}

	/* Define default option settings. */
	function dwsc_add_defaults() {
			$arr = array(	
				"chk_default_options_css"			=> "1",
				"chk_default_options_js"			=> "1"
			);
			update_option( 'dwsc_options', $arr );
	}

	/* Init plugin options to white list our options. */
	function dwsc_init(){
	
		register_setting( 'dwsc_plugin_options', 'dwsc_options' );

	}


	function dw_render_form(){
		?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>DW Shortcodes Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields('dwsc_plugin_options');  ?>
			<?php $options = get_option('dwsc_options');  ?>
			<table class="form-table">
			
				<tr><td colspan="2"><div style="margin-top:10px;"></div></td></tr>

				<tr valign="top" style="border-top:#dddddd 1px solid;">
					<th scope="row">Twitter Bootstrap CSS</th>
					<td>
						<label><input name="dwsc_options[chk_default_options_css]" type="checkbox" value="1" <?php if (isset($options['chk_default_options_css'])) { checked('1', $options['chk_default_options_css']); } ?> /> Load Twitter Bootstrap css file</label><br /><span style="color:#666666;margin-left:2px;">Uncheck this if you already include Bootstrap css on your template</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Twitter Bootstrap JS</th>
					<td>
						<label><input name="dwsc_options[chk_default_options_js]" type="checkbox" value="1" <?php if (isset($options['chk_default_options_js'])) { checked('1', $options['chk_default_options_js']); } ?> /> Load Twitter Bootstrap javascript file</label><br /><span style="color:#666666;margin-left:2px;">Uncheck this if you already include Bootstrap javascript on your template</span>
					</td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>

		<div style="clear:both;">
			<p>
				<a href="http://www.facebook.com/wp.designwall" title="Our Facebook page" target="_blank"><img src="<?php echo plugins_url('assets/images/facebook.png', __FILE__ ); ?>" /></a><a href="http://www.twitter.com/wp_designwall" title="Follow on Twitter" target="_blank"><img src="<?php echo plugins_url('assets/images/twitter.png', __FILE__ ); ?>" /></a>&nbsp;<input class="button" style="vertical-align:12px;" type="button" value="Visit Our Site" onClick="window.open('http://www.designwall.com')">&nbsp;<input class="button" style="vertical-align:12px;" type="button" value="Free Responsive Theme!" onClick="window.open('http://www.designwall.com/wordpress-theme/wallpress/')">
			</p>
		</div>

	</div>
	<?php	
	}


}
$dwcodes = new DesignwallShortcodes();