<?php
/*
* This file handles the CCGallery options in the admin page and the uploading of files
*/

// First determine whether the page is opened to create a new gallery or edit an existing one.
// Depending on that choice all the form fields are filled up accordingly
$action = '';
if( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
    check_admin_referer( 'ccgallery_edit_id'.$_GET['gallery_id'] );
    
    $action = 'edit';
    $ccgallery_options = get_option( 'ccgallery_options' );
    $formFields = $ccgallery_options[ $_GET['gallery_id'] ];
}
else {
    $action = 'add';
    $formFields = get_option( 'ccgallery_default' );
}



// Save the submitted form data
if( isset( $_POST['save'] ) ) {
    
    if( isset( $_POST['itemCaption'] ) ) {
        $_POST['itemCaption'] = array_map( 'force_balance_tags', $_POST['itemCaption'] );
    }
    
    $formFields = $_POST;
    
    
    if( $_POST['name'] === '' ) {
        $error = 1;
    }
    else {    
        $new_id = 0;
        
        // prevent the creation of a new entry if the user again saves the displayed data of $_POST
        if( isset( $_POST['gallery_id'] ) && $_POST['gallery_id'] !== '' ) {
            $new_id = $_POST['gallery_id'];
        }
        else {
            if( $action == 'add' ) {
                $gallery_ids = array();
                $gallery_ids = get_option( 'ccgallery_ids' );
                
                if( $gallery_ids ) {
                   foreach( $gallery_ids as $gallery_id ) {
                        if( $new_id < $gallery_id ) {
                            $new_id = $gallery_id;
                        }
                    } 
                }            
                
                $new_id = $new_id + 1;
                
                $gallery_ids[ $new_id ] = $new_id;
                update_option( 'ccgallery_ids', $gallery_ids );
            }
            else {
                $new_id = $_GET['gallery_id'];
            }
        }        
        
        $formFields['gallery_id'] = $new_id;
        
        $formData = $_POST;
        $formData['gallery_id'] = $new_id;
        $formData['date'] = date('d/M/Y');
        $formData['shortcode'] = '[ccgallery id="'.$new_id.'"]';
        
        
        
        $ccgallery_options = get_option( 'ccgallery_options' );
        if( !$ccgallery_options ) {
            $ccgallery_options = array();
        }
        
        // check if any uploaded files need to be deleted
        $itemnum = count($formData['items']);
        for( $i = 0; $i < $itemnum; $i++ ) {
            if( $formData['imagefile'][$i] === '' ) {
                $img_url = $ccgallery_options[ $new_id ]['imagefile'][$i];
                $img_name = pathinfo($img_url);
                $allimgs = glob( ccgallery_upload_folder.'/'.$img_name['filename'].'-*');  // locate all generated images
                foreach( $allimgs as $img ) {
                    if( pathinfo( $img, PATHINFO_EXTENSION) == $img_name['extension']) {
                        unlink($img);    
                    }        
                }
                
                // then delete the original
                $img_name = basename($img_url);
                if( $img_name !== '' && file_exists( ccgallery_upload_folder.'/'.$img_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$img_name );
                }
                
                $formData['imagefile'][$i] = null;
            }
            
            if( $formData['mp3file'][$i] === '' ) {
                $mp3_url = $ccgallery_options[ $new_id ]['mp3file'][$i];
                $mp3_name = basename($mp3_url);
                if( $mp3_name !== '' && file_exists( ccgallery_upload_folder.'/'.$mp3_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$mp3_name );
                }
                
                $formData['mp3file'][$i] = null;
            }
            
            if( $formData['oggfile'][$i] === '' ) {
                $ogg_url = $ccgallery_options[ $new_id ]['oggfile'][$i];
                $ogg_name = basename($ogg_url);
                if( $ogg_name !== '' && file_exists( ccgallery_upload_folder.'/'.$ogg_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$ogg_name );
                }
                
                $formData['oggfile'][$i] = null;
            }
            
            if( $formData['mp4file'][$i] === '' ) {
                $mp4_url = $ccgallery_options[ $new_id ]['mp4file'][$i];
                $mp4_name = basename($mp4_url);
                if( $mp4_name !== '' && file_exists( ccgallery_upload_folder.'/'.$mp4_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$mp4_name );
                }
                
                $formData['mp4file'][$i] = null;
            }
            
            if( $formData['webmfile'][$i] === '' ) {
                $webm_url = $ccgallery_options[ $new_id ]['webmfile'][$i];
                $webm_name = basename($webm_url);
                if( $webm_name !== '' && file_exists( ccgallery_upload_folder.'/'.$webm_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$webm_name );
                }
                
                $formData['webmfile'][$i] = null;
            }
            
            if( $formData['ogvfile'][$i] === '' ) {
                $ogv_url = $ccgallery_options[ $new_id ]['ogvfile'][$i];
                $ogv_name = basename($ogv_url);
                if( $ogv_name !== '' && file_exists( ccgallery_upload_folder.'/'.$ogv_name ) ) {
                    unlink( ccgallery_upload_folder.'/'.$ogv_name );
                }
                
                $formData['ogvfile'][$i] = null;
            }
        }
        
        
        $ccgallery_options[ $new_id ] = $formData;
        update_option( 'ccgallery_options', $ccgallery_options );
    }
}
?>

<div class="wrap">
    <?php screen_icon( 'options-general' ); ?>
    <h2>CCGallery - Add/Edit Gallery</h2>
    
    <?php
        if( isset( $_POST['save'] ) ) {
            
            if( !$error ) {
                echo '<div class="updated" id="message"><p>Settings saved successfully</p></div>';
            }
            else {
               echo '<div class="error" id="message"><p>You must enter a name for the gallery</p></div>'; 
            }
            
        }
    ?>
    
    <style type="text/css">
        a.showhelp {
            float: right;
            margin-bottom: 20px;
        }
        
        #ccgallery-settings {
            clear: both;
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

    <form id="ccgallery-settings" method="post" action="">
        <h3>Gallery Name</h3>
        
        <input type="hidden" name="gallery_id" value="<?php echo $formFields['gallery_id']; ?>" />
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row"> <label for="name">Unique gallery name (required)</label> </th>
                <td> <input type="text" name="name" id="name" class="regular-text" value="<?php echo $formFields['name'] ; ?>" /> </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="description">Gallery description (optional)</label> </th>
                <td> <input type="text" name="description" id="description" class="regular-text" value="<?php echo $formFields['description'] ; ?>" /> </td>
            </tr>
        </table>
        
        
        
        <!-- Gallery Options -->
        <h3>Gallery Options</h3>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row"> <label for="colorScheme">Color Scheme</label> </th>
                <td>
                    <select name="colorScheme" id="colorScheme">
                        <option value="dark" <?php selected('dark', $formFields['colorScheme']); ?>>Dark</option>
                        <option value="light" <?php selected('light', $formFields['colorScheme']); ?>>Light</option>
                    </select>
                    <span class="description">Choose the color scheme for the gallery</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="startMode">Starting mode for the gallery</label> </th>
                <td>
                    <select name="startMode" id="startMode">
                        <option value="coverflow" <?php selected('coverflow', $formFields['startMode']); ?>>Coverflow</option>
                        <option value="thumbnail" <?php selected('thumbnail', $formFields['startMode']); ?>>Thumbnails</option>
                    </select>
                    <span class="description">Choose the mode which will be shown when the gallery loads</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="coverflowFade">Fade edges of Coverflow</label> </th>
                <td>
                    <input type="checkbox" name="coverflowFade" id="coverflowFade" value="true" <?php checked('true', $formFields['coverflowFade']);?> />
                    <span class="description">If this is enabled then the edges of the Coverflow images section will be faded out</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="coverflowBg">Background for Coverflow</label> </th>
                <td>
                    <input class="medium-text" type="text" name="coverflowBg" id="coverflowBg" value="<?php echo $formFields['coverflowBg'];?>" />
                    <span class="description">This background color will be used to generate the fade-out effect at the Coverflow edges. Enter hex or rgb color values.</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="coverflowStartItem">Start Item for Coverflow</label> </th>
                <td>
                    <input class="medium-text" type="text" name="coverflowStartItem" id="coverflowStartItem" value="<?php echo $formFields['coverflowStartItem'];?>" />
                    <span class="description">Enter the item number of the starting item in the Coverflow. If this is kept blank then the middle-most item will be highlighted</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="noReflection">Disable reflection in Coverflow</label> </th>
                <td>
                    <input type="checkbox" name="noReflection" id="noReflection" value="true" <?php checked('true', $formFields['noReflection']);?>" />
                    <span class="description">You can choose to disable the reflection of the coverflow images</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="newWindowLinks">Open links in new windows</label> </th>
                <td>
                    <input type="checkbox" name="newWindowLinks" id="newWindowLinks" value="true" <?php checked('true', $formFields['newWindowLinks']);?>" />
                    <span class="description">If this is enabled then thumbnail links will open in new windows</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="detectMobile">Detect Mobile Devices</label> </th>
                <td>
                    <input type="checkbox" name="detectMobile" id="detectMobile" value="true" <?php checked('true', $formFields['detectMobile']);?> />
                    <span class="description">If this is enabled then separate low resolution videos will be served to mobile devices. You can upload those videos in the section below.</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="autoplay">Autoplay video and audio files</label> </th>
                <td>
                    <input type="checkbox" name="autoplay" id="autoplay" value="true" <?php checked('true', $formFields['autoplay']);?> />
                    <span class="description">If this is enabled then video, audio files and also Youtube/Vimeo videos will automatically start playing when the ligtbox opens</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="loop">Play video and audio files in a loop</label> </th>
                <td>
                    <input type="checkbox" name="loop" id="loop" value="true" <?php checked('true', $formFields['loop']);?> />
                    <span class="description">If this is enabled then video and audio files will go on playing in a loop. This setting does not affect Youtube/Vimeo videos</span>
                </td>
            </tr>

			<tr valign="top">
                <th scope="row"> <label for="storeVolume">Store Volume Level</label> </th>
                <td>
                    <input type="checkbox" name="storeVolume" id="storeVolume" value="true" <?php checked('true', $formFields['storeVolume']);?> />
                    <span class="description">If this is enabled then the volume level of the player will be retained when it is closed and will be set when it is opened again. This setting does not affect Youtube/Vimeo videos</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="categories">Custom Categories</label> </th>
                <td>
                    <input type="text" name="categories" id="categories" class="regular-text" value="<?php echo $formFields['categories'] ; ?>" />
                    <span class="description">If you want custom categories then enter a comma separated list of custom category names</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="showFileTypeButtons">Show File-Type Buttons</label> </th>
                <td>
                    <input type="checkbox" name="showFileTypeButtons" id="showFileTypeButtons" value="true" <?php checked('true', $formFields['showFileTypeButtons']);?> />
                    <span class="description">If you have custom categories then you may disable the showing of file-type buttons from the filter menu</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="hideMenu">Hide Gallery Menu</label> </th>
                <td>
                    <input type="checkbox" name="hideMenu" id="hideMenu" value="true" <?php checked('true', $formFields['hideMenu']);?> />
                    <span class="description">You can choose to hide the gallery menu completely</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="startCategory">Starting category for the gallery</label> </th>
                <td>
                    <select name="startCategory" id="startCategory">
                        <option value="all" <?php selected('all', $formFields['startCategory']); ?>>All</option>
                        
                        <?php /*if( $formFields['showFileTypeButtons'] !== 'true' ) {
                            $showoption = 'style="display:none"';
                        }
                        else {
                            $showoption = '';
                        }*/
                        ?>
                        <option class="filetype" value="photo" <?php selected('photo', $formFields['startCategory']); ?>>Photos</option>
                        <option class="filetype" value="audio" <?php selected('audio', $formFields['startCategory']); ?>>Audios</option>
                        <option class="filetype" value="video" <?php selected('video', $formFields['startCategory']); ?>>Videos</option>
                        
                        <?php
                        $category_arr = array();
                        if( isset($formFields['categories']) && $formFields['categories'] !== '' ) {
                            $category_arr = explode(',', $formFields['categories']);
                            foreach( $category_arr as $cat ) {
                                $cat_name = strtolower( trim($cat) );?>
                                <option value="<?php echo $cat_name;?>" <?php selected($cat_name, $formFields['startCategory']); ?>><?php echo $cat;?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <span class="description">Choose the category which will be shown when the gallery loads. By default all items from all categories are shown</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label>Coverflow mode image size</label> </th>
                <td> <input class="small-text" type="text" name="coverflowImgWidth" id="coverflowImgWidth" value="<?php echo $formFields['coverflowImgWidth'] ; ?>" /> &times;
                     <input class="small-text" type="text" name="coverflowImgHeight" id="coverflowImgHeight" value="<?php echo $formFields['coverflowImgHeight'] ; ?>" />
                     <span class="description">in px (the width and height of the coverflow images)</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label>Thumbnails mode image size</label> </th>
                <td> <input class="small-text" type="text" name="thumbnailImgWidth" id="thumbnailImgWidth" value="<?php echo $formFields['thumbnailImgWidth'] ; ?>" /> &times;
                     <input class="small-text" type="text" name="thumbnailImgHeight" id="thumbnailImgHeight" value="<?php echo $formFields['thumbnailImgHeight'] ; ?>" />
                     <span class="description">in px (the width and height of the images used in thumbnails mode)</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="hideCoverflow">Hide Coverflow Mode</label> </th>
                <td>
                    <input type="checkbox" name="hideCoverflow" id="hideCoverflow" value="true" <?php checked('true', $formFields['hideCoverflow']);?> />
                    <span class="description">If this is enabled then the Coverflow section will be hidden alongwith the view mode buttons. Set Starting mode to Thumbnails.</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="hideThumbnails">Hide Thumbnails Mode</label> </th>
                <td>
                    <input type="checkbox" name="hideThumbnails" id="hideThumbnails" value="true" <?php checked('true', $formFields['hideThumbnails']);?> />
                    <span class="description">If this is enabled then the Thumbnails section will be hidden alongwith the view mode buttons. Set starting mode to Coverflow.</span>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"> <label for="hideCoverflowList">Hide Coverflow Item List</label> </th>
                <td>
                    <input type="checkbox" name="hideCoverflowList" id="hideCoverflowList" value="true" <?php checked('true', $formFields['hideCoverflowList']);?> />
                    <span class="description">If this is enabled then the list appearing in the Coverflow section will be hidden</span>
                </td>
            </tr>
        </table>
        
        
        
        <h3>Gallery Items</h3>
        
        <ul id="itemsList">
            <?php                
                $itemnum = count( $formFields['items'] );
                if( !isset( $itemnum) || $itemnum === 0 ) {
                    $itemnum = 1;
                }
                for( $i = 0; $i < $itemnum; $i++ ) { ?>
                    <li>
                        <a class="delete no-hide" title="Delete this item"></a>
                        <a class="collapse no-hide" title="Collapse item details"></a>
                        <a class="expand no-hide" title="Expand item details"></a>
                        
                        <input type="hidden" name="items[]" value="item" />
                        
                        <label class="main no-hide">File type:</label>
                        
                        <?php if( !isset($formFields['fileTypeVal'][$i]) ) {
                            $formFields['fileTypeVal'][$i] = 'photo';
                        }
                        ?>
                        <label class="no-hide">Photo</label>
                        <input class="no-hide" type="radio" value="photo" name="filetype<?php echo $i;?>" <?php checked( 'photo', $formFields['fileTypeVal'][$i] ); ?> />
                        
                        <label class="no-hide">Audio</label>
                        <input class="no-hide" type="radio" value="audio" name="filetype<?php echo $i;?>" <?php checked( 'audio', $formFields['fileTypeVal'][$i] ); ?> />
                        
                        <label class="no-hide">Video</label>
                        <input class="no-hide" type="radio" value="video" name="filetype<?php echo $i;?>" <?php checked( 'video', $formFields['fileTypeVal'][$i] ); ?> />
                        <br/>
                        <span class="description no-hide">Choose what file type this item will be in the gallery</span>
                        <input type="hidden" name="fileTypeVal[]" value="<?php echo $formFields['fileTypeVal'][$i];?>" />
                        
                        <br class="no-hide"/>
                        <label class="main">Category:</label>
                        <input class="regular-text" type="text" name="itemCategories[]" value="<?php echo sanitize_text_field( $formFields['itemCategories'][$i] ); ?>" />
                        <br />
                        <span class="description">Enter a comma separated list of category names. The category names must be contained in the list of custom categories entered above.</span>
                        
                        <br/>
                        <div class="imageUpload uploadFields">
                            <label class="main">Image File:</label>
                            <input class="upload-val regular-text" type="text" name="imagefile[]" value="<?php echo esc_url( $formFields['imagefile'][$i] ); ?>" />
                            <div class="uploader"></div>
                            <br clear="all"/>
                            <span class="description">This image will be cropped to form the item thumbnails. If "photo" file type is chosen this image will also be shown in the lightbox</span>
                        </div>
                        
                        <br/>
                        <div class="audioUpload uploadFields">
                            <label class="main">Audio Files:</label>
                            <input class="upload-val regular-text" type="text" name="mp3file[]" value="<?php echo esc_url( $formFields['mp3file'][$i] ); ?>" />
                            <div class="uploader"></div>
                            <br/>
                            <span class="description">Upload the mp3 format of the audio file</span>
                            
                            <br/>
                            <input class="upload-val regular-text" type="text" name="oggfile[]" value="<?php echo esc_url( $formFields['oggfile'][$i] ); ?>" />
                            <div class="uploader"></div>
                            <br/>
                            <span class="description">Upload the ogg format of the audio file</span>
                        </div>
                        
                        <br/>
                        <div class="videoUpload uploadFields">
                            <label class="main">Video Files:</label>
                            <input class="upload-val regular-text" type="text" name="mp4file[]" value="<?php echo esc_url( $formFields['mp4file'][$i] ); ?>" />
                            <div class="uploader"></div>
                            <br/>
                            <span class="description">Upload the mp4 format of the video file</span>
                            
                            <br/>
                            <input class="upload-val regular-text" type="text" name="webmfile[]" value="<?php echo esc_url( $formFields['webmfile'][$i] ); ?>" />
                            <div class="uploader"></div>
                            <br/>
                            <span class="description">Upload the webm format of the video file</span>
                            
                            <br/>
                            <input class="upload-val regular-text" type="text" name="ogvfile[]" value="<?php echo esc_url( $formFields['ogvfile'][$i] ); ?>" />
                            <div class="uploader"></div>
                            <br/>
                            <span class="description">Upload the ogv format of the video file</span>
                            
                            <div class="mobileVideo">
                                <input class="upload-val regular-text" type="text" name="mp4mobile[]" value="<?php echo esc_url( $formFields['mp4mobile'][$i] ); ?>" />
                                <div class="uploader"></div>
                                <br/>
                                <span class="description">Upload low resolution mp4 video file for mobile devices</span>
                            </div>
                            
                            <label class="main">Youtube Video</label>
                            <input class="regular-text" type="text" name="youtube[]" value="<?php echo esc_url( $formFields['youtube'][$i] );?>" />
                            <br/>
                            <span class="description">Enter url to Youtube video, for eg. http://www.youtube.com/watch?v=xxxxxxxxxxx</span>
                            
                            <br/>
                            <label class="main">Vimeo Video</label>
                            <input class="regular-text" type="text" name="vimeo[]" value="<?php echo esc_url( $formFields['vimeo'][$i] );?>" />
                            <br clear="all"/>
                            <span class="description">Enter url to Vimeo video, for eg. http://vimeo.com/12345678.</span>
                        </div>
                        
                        <br/>    
                        <label class="main no-hide">Title:</label>
                        <input class="regular-text no-hide" type="text" name="itemTitle[]" value="<?php echo stripcslashes( esc_html( $formFields['itemTitle'][$i] ) ); ?>" />
                        <br class="no-hide"/>
                        <span class="description no-hide">Enter the title for the gallery item</span>
                        
                        <br/>
                        <label class="main">Caption:</label>
                        <textarea name="itemCaption[]"><?php echo stripcslashes( esc_textarea( $formFields['itemCaption'][$i] ) ); ?></textarea>
                        <br/>
                        <span class="description">The caption can contain HTML</span>
                        
                        <br/>
                        <label class="main">Link:</label>
                        <input class="regular-text" type="text" name="link[]" value="<?php echo esc_url( $formFields['link'][$i] ); ?>" />
                        <br/>
                        <span class="description last">Link which will open when item thumbnail is clicked. In this case the Lightbox won't show.</span>
                    </li>
                <?php }
            ?>
        </ul>
        
       
        <!--Button to add items-->
        <a id="add-item" class="button-secondary">Add Gallery Item</a>
        
        
        
        <p id="formButtons">
            <input type="submit" name="save" value="Save Options" class="button-primary" />
        </p>
        
    </form> 
</div>  <!-- end #wrap -->

