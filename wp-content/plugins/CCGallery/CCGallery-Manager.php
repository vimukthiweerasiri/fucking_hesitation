<?php

/*
 * This file handles the management of ccgallery slideshows
 */


    $gallery_ids = get_option( 'ccgallery_ids' );
    $ccgallery_options = get_option('ccgallery_options' );
    
    if( isset( $_GET['action'] ) && $_GET['action'] === 'delete' ) {
        check_admin_referer( 'ccgallery_delete_id'.$_GET['gallery_id'] );
        
        unset( $gallery_ids[ $_GET['gallery_id'] ] );
        update_option( 'ccgallery_ids', $gallery_ids );
        
        $gallery_options = $ccgallery_options[ $_GET['gallery_id'] ];
        $itemnum = count($gallery_options['items']);
        
        // delete the associated files
        if( $itemnum ) {
            for( $i = 0; $i < $itemnum; $i++ ) {
                $img_name = pathinfo( $gallery_options['imagefile'][$i] );
                $allimgs = glob( ccgallery_upload_folder.'/'.$img_name['filename'].'-*'); // locate all generated images
                foreach( $allimgs as $img ) {
                    if( pathinfo( $img, PATHINFO_EXTENSION) == $img_name['extension']) {
                        unlink($img);    
                    }        
                }
                // finally delete the original image
                $img_name = basename( $gallery_options['imagefile'][$i] );
                if( $img_name !== '' && file_exists( ccgallery_upload_folder.'/'.$img_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$img_name );
                }
                
                $mp3_name = basename( $gallery_options['mp3file'][$i] );
                if( $mp3_name !== '' && file_exists( ccgallery_upload_folder.'/'.$mp3_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$mp3_name );
                }
                
                $ogg_name = basename( $gallery_options['oggfile'][$i] );
                if( $ogg_name !== '' && file_exists( ccgallery_upload_folder.'/'.$ogg_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$ogg_name );
                }
                
                $mp4_name = basename( $gallery_options['mp4file'][$i] );
                if( $mp4_name !== '' && file_exists( ccgallery_upload_folder.'/'.$mp4_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$mp4_name );
                }
                
                $webm_name = basename( $gallery_options['webmfile'][$i] );
                if( $webm_name !== '' && file_exists( ccgallery_upload_folder.'/'.$webm_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$webm_name );
                }
                
                $ogv_name = basename( $gallery_options['ogvfile'][$i] );
                if( $ogv_name !== '' && file_exists( ccgallery_upload_folder.'/'.$ogv_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$ogv_name );
                }
            }    
        }        
        
        unset( $ccgallery_options[ $_GET['gallery_id'] ] );
        update_option( 'ccgallery_options', $ccgallery_options );
        
        $deleted = true;
        $delete_msg = 'The gallery ( id = "'.$_GET['gallery_id'].'" ) was deleted';
    }
?>

<div class="wrap">
    <?php screen_icon( 'plugins' ); ?>
    <h2>CCGallery - Gallery Manager</h2>
    
    <?php
        if( $deleted ) {
            echo '<div class="updated" id="message"><p>'.$delete_msg.'</p></div>';
        }
    ?>
    
    <style type="text/css">
        a.showhelp {
            float: right;
            margin-bottom: 20px;
        }
        
        #cc-help {
            position: absolute;
            top: 100px;
            left: 50%;
            width: 860px;
            height: 1000px;
            margin-left: -400px;
            z-index: 1000;
            display: none;
            background: #fff;
            -moz-box-shadow: 10px 10px 50px rgba(0, 0, 0, 0.7);
            -webkit-box-shadow: 10px 10px 50px rgba(0, 0, 0, 0.7);
            box-shadow: 10px 10px 50px rgba(0, 0, 0, 0.7);
        }
        
        #cc-closehelp {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 36px;
            height: 36px;
            cursor: pointer;
            background: url(<?php echo plugin_dir_url( __FILE__);?>/images/close.png);
        }
        
        .manager-thumbs {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .manager-thumbs li {
            display: inline-block;
            width: 32px;
            height: 32px;
            margin: 0 10px 0 0;
            padding: 2px;
            border: 1px solid #aaa;
        }
        
        .manager-thumbs li img {
            width: 100%;
            height: 100%;
        }
    </style>
    
    <script type="text/javascript">
        jQuery(function($){
            var $helpContainer = $('<div id="cc-help"/>').appendTo('body'),
                $helpIframe = $('<iframe width="100%" height="100%" frameborder="1" />').appendTo($helpContainer),
                $closehelp = $('<a id="cc-closehelp"/>').appendTo($helpContainer),
                helpurl = "<?php echo plugin_dir_url( __FILE__).'documentation/index.html' ;?>" ;
            
            $helpIframe[0].src = helpurl;
            
            $('a.showhelp').click(function(){
               $helpContainer.slideDown(600); 
            });
            
            $closehelp.click(function(){
                $helpContainer.slideUp(600);
            });
        });
    </script>
    
    <a class="showhelp button-secondary">View Documentation</a>
    
    <table class="widefat">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Images</th>
                <th>Shortcode</th>
                <th>Action</th>
                <th>Date (Last Modified)</th>
            </tr>
        </thead>
        
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Images</th>
                <th>Shortcode</th>
                <th>Action</th>
                <th>Date (Last Modified)</th>
            </tr>
        </tfoot>
        
        <tbody>
            
            <?php
            if( $gallery_ids ) {
                foreach( $gallery_ids as $gallery_id ) {
                    $edit_query = add_query_arg( array( 'page' => 'ccgallery_options', 'action' => 'edit', 'gallery_id' => $gallery_id ), admin_url( 'admin.php' ) );
                    $edit_url = wp_nonce_url( $edit_query, 'ccgallery_edit_id'.$gallery_id );
                    
                    $delete_query = add_query_arg( array( 'action' => 'delete', 'gallery_id' => $gallery_id ) );
                    $delete_url = wp_nonce_url( $delete_query, 'ccgallery_delete_id'.$gallery_id );
                    
                    $itemnum = count( $ccgallery_options[ $gallery_id ]['items'] );
                    if( $itemnum > 5 ) $itemnum = 5;
                    $galleryThumbs = '<ul class="manager-thumbs">';
                    for( $i = 0; $i < $itemnum; $i++ ) {
                        $galleryThumbs .= '<li><img src="'. $ccgallery_options[ $gallery_id ]['imagefile'][$i] .'" alt="" /></li>';
                    }
                    $galleryThumbs .= '</ul>';
                    ?>
                    <tr>
                        <th><?php echo $gallery_id; ?></th>
                        <th><?php echo $ccgallery_options[ $gallery_id ]['name']; ?></th>
                        <th><?php echo $ccgallery_options[ $gallery_id ]['description']; ?></th>
                        <th><?php echo $galleryThumbs; ?></th>
                        <th><?php echo $ccgallery_options[ $gallery_id ]['shortcode']; ?></th>
                        <th> <a href="<?php echo $edit_url; ?>">Edit</a>
                            /
                            <a href="<?php echo $delete_url; ?>" onclick="return confirm('Are you sure that you want to delete this galleryr?');">Delete</a></th>
                        <th><?php echo $ccgallery_options[ $gallery_id ]['date']; ?></th>
                    </tr>
                <?php
                }
            }
            else { ?>
                <tr>
                    <td align="center" colspan="5"> No entries found </td>
                </tr>
            <?php
            }
            ?>
            
        </tbody>
    </table>
    
</div>



