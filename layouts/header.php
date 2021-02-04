<div id="header-site" class="uk-position-absolute">

    <div class="tm-toolbar">
        <!-- Conditional for top menu -->
        <?php if ( has_nav_menu( 'uikit_top_menu' ) ) : ?>
        <div class="uk-container uk-container-expand">
            <div class="uk-flex uk-flex-right">
                <?php do_action('uikit_top_menu'); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="tm-nav">
        <div class="uk-container uk-container-expand">
            
            <nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
				
				<div class="uk-navbar-left">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="uk-navbar-item uk-logo">
                        <?php $logo = get_field('logo', 'option'); ?>
                        <?php if ($logo) { ?>
                        <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" />
                        <?php } else { ?>
                        <?php //bloginfo('name'); ?>
                        <img src="/dev/wp-content/uploads/2021/01/HCAlogo4.png" alt="chudler-logo-white"  style="height:80px;"/>
                        <?php } ?>
                    </a>
                </div>
				
               <!--  <div class="uk-navbar-center">
                    
                </div> -->
                
                <div class="uk-navbar-right">
                <?php do_action('uikit_primary_menu'); ?>
                    <div class="container-mobile uk-hidden@m">
                        <!-- This is an anchor toggling the off-canvas -->
                    <a uk-navbar-toggle-icon="" href="#offcanvas-menu" uk-toggle=""
                        class="uk-navbar-toggle uk-icon uk-navbar-toggle-icon"></a>
                        <!-- This is the off-canvas -->
                        <?php do_action('uikit_offcanvas_menu'); ?>
                    </div>
                </div>
                
            </nav>
        </div>
    </div>
</div>