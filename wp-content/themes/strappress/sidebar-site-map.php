<div id="widgets" class="home-widgets">
        <div class="row">
            <?php responsive_widgets(); // above widgets hook ?>
            
            <?php if (!dynamic_sidebar('home-site-map')) : ?>
            
               text

            <?php endif; //end of main-sidebar ?>

            <?php responsive_widgets_end(); // after widgets hook ?>
        </div>
    </div><!-- end of #widgets -->