<?php
/**
 * Main Widget Template
 *
 *
 * @file           sidebar.php
 * @package        StrapPress 
 * @author         Brad Williams 
 * @copyright      2011 - 2012 Brag Interactive
 * @license        license.txt
 * @version        Release: 2.3.0
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */
?>
        <div class="span3 right">
        <div id="widgets" class="well">
        
        <?php responsive_widgets(); // above widgets hook ?>
            
            <?php if (!dynamic_sidebar('sidebar-home-right')) : ?>
                <p>No Content</p>
            <?php endif; //end of main-sidebar ?>

        <?php responsive_widgets_end(); // after widgets hook ?>
            </div><!-- end of #widgets -->
        </div> <!-- end of .span3 -->
    </div> <!-- end of .span9 -->