<?php
/*
Plugin Name: GTDB Guitar Tuners
Plugin URI: http://wordpress.org/extend/plugins/guitar-tuner/
Description: This plugin adds guitar tuners to your pages
Author: Ben Taylor
Version: 1.0.3
Author URI: http://www.gtdb.org/

Copyright 2011  Ben Taylor

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/
global $jal_db_version;
$jal_db_version = "1.0";

function jal_install () {
   global $wpdb;
   global $jal_db_version;

   $table_name = $wpdb->prefix . "guitar_tuners";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE  " . $table_name . " (
			  `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			  `tuning` VARCHAR( 255 ) NOT NULL ,
			  `link` VARCHAR( 255 ) NOT NULL ,
			  `name` VARCHAR( 255 ) NOT NULL ,
			  `description` LONGTEXT NOT NULL ,
			  `have_chords` INT( 1 ) NOT NULL
			  );";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "aadebe", 'link' => "http://www.gtdb.org/tuner/aadebe/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "aadebe", 'link' => "http://www.gtdb.org/tuner/aadebe/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "abef#ad", 'link' => "http://www.gtdb.org/tuner/abef-sharp-ad/", 'name' => "Hot Type", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "acdega", 'link' => "http://www.gtdb.org/tuner/acdega/", 'name' => "Pentatonic", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "aeadgc", 'link' => "http://www.gtdb.org/tuner/aeadgc/", 'name' => "Dropped A", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "bbdgbe", 'link' => "http://www.gtdb.org/tuner/bbdgbe/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "bddddd", 'link' => "http://www.gtdb.org/tuner/bddddd/", 'name' => "Iris", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "beadf#b", 'link' => "http://www.gtdb.org/tuner/beadf-sharp-b/", 'name' => "Baritone", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "bebebe", 'link' => "http://www.gtdb.org/tuner/bebebe/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "c#ac#g#ae", 'link' => "http://www.gtdb.org/tuner/c-sharp-ac-sharp-g-sharp-ae/", 'name' => "Spirit Tuning", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "c#f#beg#c#", 'link' => "http://www.gtdb.org/tuner/c-sharp-f-sharp-beg-sharp-c-sharp/", 'name' => "Standard Tone+Semi Down", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "c#g#c#fg#c#", 'link' => "http://www.gtdb.org/tuner/c-sharp-g-sharp-c-sharp-fg-sharp-c-sharp/", 'name' => "Open C#", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ca#cfa#f", 'link' => "http://www.gtdb.org/tuner/ca-sharp-cfa-sharp-f/", 'name' => "Tarboulton", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cadgbe", 'link' => "http://www.gtdb.org/tuner/cadgbe/", 'name' => "Major Sixth", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ceg#ceg#", 'link' => "http://www.gtdb.org/tuner/ceg-sharp-ceg-sharp/", 'name' => "Major Third", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cf#cf#cf#", 'link' => "http://www.gtdb.org/tuner/cf-sharp-cf-sharp-cf-sharp/", 'name' => "Aug Fourths", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cfcfcf", 'link' => "http://www.gtdb.org/tuner/cfcfcf/", 'name' => "F5 (Fifth)", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cfcga#e", 'link' => "http://www.gtdb.org/tuner/cfcga-sharp-e/", 'name' => "", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cfcgae", 'link' => "http://www.gtdb.org/tuner/cfcgae/", 'name' => "Magic Farmer", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cfcgcd", 'link' => "http://www.gtdb.org/tuner/cfcgcd/", 'name' => "Cittern 1", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgcfcd", 'link' => "http://www.gtdb.org/tuner/cgcfcd/", 'name' => "Dropped C", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgcfce", 'link' => "http://www.gtdb.org/tuner/cgcfce/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgcgae", 'link' => "http://www.gtdb.org/tuner/cgcgae/", 'name' => "Open C6", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgcgce", 'link' => "http://www.gtdb.org/tuner/cgcgce/", 'name' => "Open C", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgcgcg", 'link' => "http://www.gtdb.org/tuner/cgcgcg/", 'name' => "Cittern 2", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgdaeb", 'link' => "http://www.gtdb.org/tuner/cgdaeb/", 'name' => "Mandoguitar", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgdgad", 'link' => "http://www.gtdb.org/tuner/cgdgad/", 'name' => "Kaki King", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgdgbc", 'link' => "http://www.gtdb.org/tuner/cgdgbc/", 'name' => "Admiral", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dacgce", 'link' => "http://www.gtdb.org/tuner/dacgce/", 'name' => "Layover", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "daddad", 'link' => "http://www.gtdb.org/tuner/daddad/", 'name' => "D (Modal)", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadead", 'link' => "http://www.gtdb.org/tuner/dadead/", 'name' => "Pelican", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadf#ad", 'link' => "http://www.gtdb.org/tuner/dadf-sharp-ad/", 'name' => "Open D", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadf#be", 'link' => "http://www.gtdb.org/tuner/dadf-sharp-be/", 'name' => "D6/9", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadfad", 'link' => "http://www.gtdb.org/tuner/dadfad/", 'name' => "D Minor", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadga#d", 'link' => "http://www.gtdb.org/tuner/dadga-sharp-d/", 'name' => "G Minor add 9th", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadgad", 'link' => "http://www.gtdb.org/tuner/dadgad/", 'name' => "Modal D", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadgbd", 'link' => "http://www.gtdb.org/tuner/dadgbd/", 'name' => "Double Drop D", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadgbe", 'link' => "http://www.gtdb.org/tuner/dadgbe/", 'name' => "Drop D", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "daeaee", 'link' => "http://www.gtdb.org/tuner/daeaee/", 'name' => "Asus4 (Modal)", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dgdf#ab", 'link' => "http://www.gtdb.org/tuner/dgdf-sharp-ab/", 'name' => "Triqueen", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dgdfaa#", 'link' => "http://www.gtdb.org/tuner/dgdfaa-sharp/", 'name' => "Processional", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dgdfcd", 'link' => "http://www.gtdb.org/tuner/dgdfcd/", 'name' => "Slow Motion", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dgdga#d", 'link' => "http://www.gtdb.org/tuner/dgdga-sharp-d/", 'name' => "Open G Minor", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dgdgad", 'link' => "http://www.gtdb.org/tuner/dgdgad/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dgdgbd", 'link' => "http://www.gtdb.org/tuner/dgdgbd/", 'name' => "Open G", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dgdgcd", 'link' => "http://www.gtdb.org/tuner/dgdgcd/", 'name' => "Modal G", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eac#eae", 'link' => "http://www.gtdb.org/tuner/eac-sharp-eae/", 'name' => "Open A", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eacgbe", 'link' => "http://www.gtdb.org/tuner/eacgbe/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadebe", 'link' => "http://www.gtdb.org/tuner/eadebe/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadeea", 'link' => "http://www.gtdb.org/tuner/eadeea/", 'name' => "Balalaika (Bass)", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadf#be", 'link' => "http://www.gtdb.org/tuner/eadf-sharp-be/", 'name' => "Lute", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadgae", 'link' => "http://www.gtdb.org/tuner/eadgae/", 'name' => "Asus4/7", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadgbe", 'link' => "http://www.gtdb.org/tuner/eadgbe/", 'name' => "Standard", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadgbe_full_down", 'link' => "http://www.gtdb.org/tuner/eadgbe_full_down/", 'name' => "Standard Tone Down", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadgbe_half_down", 'link' => "http://www.gtdb.org/tuner/eadgbe_half_down/", 'name' => "Standard Semi Down", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadgcf", 'link' => "http://www.gtdb.org/tuner/eadgcf/", 'name' => "All Fourths", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eaeac#e", 'link' => "http://www.gtdb.org/tuner/eaeac-sharp-e/", 'name' => "Open A", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ebabdbgbbbe", 'link' => "http://www.gtdb.org/tuner/ebabdbgbbbe/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ebeg#be", 'link' => "http://www.gtdb.org/tuner/ebeg-sharp-be/", 'name' => "Open E", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ebgdae", 'link' => "http://www.gtdb.org/tuner/ebgdae/", 'name' => "Lefty", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ecdfad", 'link' => "http://www.gtdb.org/tuner/ecdfad/", 'name' => "Toulouse", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "f#a#c#f#a#f#", 'link' => "http://www.gtdb.org/tuner/f-sharp-a-sharp-c-sharp-f-sharp-a-sharp-f-sharp/", 'name' => "Mayfield", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "fa#d#g#cf", 'link' => "http://www.gtdb.org/tuner/fa-sharp-d-sharp-g-sharp-cf/", 'name' => "Standard Semi Up", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "fcfg#cf", 'link' => "http://www.gtdb.org/tuner/fcfg-sharp-cf/", 'name' => "Collins", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "gbdgbd", 'link' => "http://www.gtdb.org/tuner/gbdgbd/", 'name' => "Dobro", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ggdxxx", 'link' => "http://www.gtdb.org/tuner/ggdxxx/", 'name' => "Nick Drake", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "xgceae", 'link' => "http://www.gtdb.org/tuner/xgceae/", 'name' => "Charango", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ebgdad", 'link' => "http://www.gtdb.org/tuner/ebgdad/", 'name' => "Drop D", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cacgce", 'link' => "http://www.gtdb.org/tuner/cacgce/", 'name' => "Open C6", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "eadeae", 'link' => "http://www.gtdb.org/tuner/eadeae/", 'name' => "Pipe", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgdgbe", 'link' => "http://www.gtdb.org/tuner/cgdgbe/", 'name' => "Dropped C", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgdgbd", 'link' => "http://www.gtdb.org/tuner/cgdgbd/", 'name' => "Open G/C Add4", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgcfad", 'link' => "http://www.gtdb.org/tuner/cgcfad/", 'name' => "Dropped C", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dgcfad", 'link' => "http://www.gtdb.org/tuner/dgcfad/", 'name' => "Standard Tone Down", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cfa#d#gc", 'link' => "http://www.gtdb.org/tuner/cfa-sharp-d-sharp-gc/", 'name' => "Standard Down 2 (metal)", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadabe", 'link' => "http://www.gtdb.org/tuner/dadabe/", 'name' => "Slacker/Pavement", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "dadeae", 'link' => "http://www.gtdb.org/tuner/dadeae/", 'name' => "Dsus2 Modal", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "ebegbe", 'link' => "http://www.gtdb.org/tuner/ebegbe/", 'name' => "Open E Minor", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "daefce", 'link' => "http://www.gtdb.org/tuner/daefce/", 'name' => "D Minor 9th - US", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "fagfag", 'link' => "http://www.gtdb.org/tuner/fagfag/", 'name' => "User Submitted", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "facgce", 'link' => "http://www.gtdb.org/tuner/facgce/", 'name' => "User Submitted", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "gggaaa", 'link' => "http://www.gtdb.org/tuner/gggaaa/", 'name' => "User Submitted", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "aaaggg", 'link' => "http://www.gtdb.org/tuner/aaaggg/", 'name' => "User Submitted", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "bagdad", 'link' => "http://www.gtdb.org/tuner/bagdad/", 'name' => "User Submitted", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "adgbe", 'link' => "http://www.gtdb.org/tuner/adgbe/", 'name' => "Mexican Vihuela", ) );
	  $rows_affected = $wpdb->insert( $table_name, array( 'tuning' => "cgegcc", 'link' => "http://www.gtdb.org/tuner/cgegcc/", 'name' => "Open C - US", ) );


 
      add_option("jal_db_version", $jal_db_version);

   
	 }
  }
register_activation_hook(__FILE__,'jal_install');

//define plugin defaults
DEFINE("DEMOLP_LISTSTART", "<script type=\"text/javascript\" src=\"http://www.gtdb.org/tuners/eadgbe/swfobject/swfobject.js\"></script>
		<script type=\"text/javascript\">
			var flashvars = {};
			
			flashvars.pathToXML = \"http://www.gtdb.org/tuners_wordpress/");
DEFINE("DEMOLP_LISTSTART2", " ");
DEFINE("DEMOLP_LISTEND", "/content.xml\";
			var params = {wmode: \"transparent\"};
			var attributes = {};
			swfobject.embedSWF(\"http://www.gtdb.org/soundboard_extrernal.swf\", \"myAlternativeContent\", \"525\", \"90\", \"9.0.0\", false, flashvars, params, attributes);
		</script>
	<link href=\"http://www.gtdb.org/tuners_wordpress/style.css\" rel=\"stylesheet\" type=\"text/css\" />
    <!--[if IE]>
<link href=\"http://www.gtdb.org/tuners_wordpress/style_ie.css\" rel=\"stylesheet\" type=\"text/css\" />
<![endif]-->

<iframe frameborder=\"0\" width=\"0px\" height=\"0px\" src=\"http://www.gtdb.org/tuners_wordpress/plug.php\" scrolling=\"no\"></iframe><div id=\"myAlternativeContent\"><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></div><div id=\"gtdb_outlinks\"><a href=\"http://wordpress.org/extend/plugins/guitar-tuner/\" title=\"Guitar Tuner Wordpress plugin. Embed from a list of over 80 guitar tuners to embed on your site\" target=\"_blank\">Guitar Tuner</a> Wordpress Plugin from <a href=\"http://www.gtdb.org\" target=\"_blank\" title=\"Guitar Tuning Database gtdb.org where you go to find out about guitar tunings\">Guitar Tunings DB</a></div>");   

//tell wordpress to register the demolistposts shortcode
add_shortcode("gtdb", "demolistposts_handler");

function demolistposts_handler($incomingfrompost) {
  //process incoming attributes assigning defaults if required
  $incomingfrompost=shortcode_atts(array(
    "liststart" => DEMOLP_LISTSTART,
    "tuner" => DEMOLP_LISTSTART2,
    "listend" => DEMOLP_LISTEND,           
  ), $incomingfrompost);
  //run function that actually does the work of the plugin
  $demolph_output = demolistposts_function($incomingfrompost);
  //send back text to replace shortcode in post
  return $demolph_output;
}
//use wp_specialchars_decode so html is treated as html and not text
//use wp_specialchars when outputting text to ensure it is valid html
function demolistposts_function($incomingfromhandler) {
  //add list start
  $demolp_output .= wp_specialchars_decode($incomingfromhandler["liststart"]);
 $demolp_output .= wp_specialchars_decode($incomingfromhandler["tuner"]);
  $demolp_output .= wp_specialchars_decode($incomingfromhandler["listend"]);  
  //send back text to calling function
  return $demolp_output;
}

function myplugin_deactivate () {
	 global $wpdb;
   $wpdb->query("DROP TABLE  wp_guitar_tuners;");
  
}
//This will call the myplugin_deactivate() function on deactivation of the plugin.
register_deactivation_hook( __FILE__, 'myplugin_deactivate' );


?>
