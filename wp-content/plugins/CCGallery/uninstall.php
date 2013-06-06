<?php
// Uninstall script for CCGallery

// If uninstall not called from WordPress exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit ();
}
        
// Delete option from options table
delete_option( 'ccgallery_options' );
delete_option( 'ccgallery_ids' );
delete_option( 'ccgallery_default' );

// delete gallery upload folder alongwith all uploaded files inside it
$wp_upload_directory = wp_upload_dir();
$wp_upload_folder = $wp_upload_directory['basedir'];
remove_dir( $wp_upload_folder.'/ccgallery-upload' );

function remove_dir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..') {
                if (filetype($dir.'/'.$object) == 'dir') {
                    remove_dir($dir.'/'.$object);
                }
                else {
                    unlink($dir.'/'.$object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
  
?> 