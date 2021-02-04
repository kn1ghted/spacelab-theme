<?php

/**
 * Class Name: your_themename_top_menu
 * Description: A custom WordPress nav walker class to implement UIkit menu markup
 */
class uikit_top_w_menu extends Walker_Nav_Menu
{

    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"uk-navbar-dropdown\">\n<ul role=\"menu\" class=\"uk-nav uk-navbar-dropdown-nav\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker_Nav_Menu::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of page. Used for padding.
     * @param array  $args   Not used.
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent</ul></div>";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';


        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        if ($args->has_children)
            //$class_names .= ' uk-parent';
            $class_names .= ' ';

        $dropdown = ''; /*
				if ( $args->has_children && $depth == 0)
			$dropdown .= ' data-uk-dropdown="{mode:\'click\'}"';*/

        if (in_array('current-menu-item', $classes) || in_array('current-menu-parent', $classes))
            $class_names .= ' uk-active';

        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . $dropdown . '>';

        $atts = array();
        $atts['title']  = !empty($item->title)    ? $item->title    : '';
        $atts['target'] = !empty($item->target)    ? $item->target    : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn    : '';

        // If item has_children add atts to a.
        //if ( $args->has_children && $depth === 0 ) {
        //$atts['href']          = '#';
        // $atts['data-toggle']   = 'dropdown';
        // $atts['class']         = 'dropdown-toggle';
        // $atts['aria-haspopup'] = 'true';
        //} else {
        $atts['href'] = !empty($item->url) ? $item->url : '';
        //}

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;

        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= ($args->has_children && 0 === $depth) ? '</a>' : '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth.
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @see Walker::start_el()
     * @since 2.5.0
     *
     * @param object $element Data object
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args
     * @param string $output Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element)
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if (is_object($args[0]))
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    /**
     * Menu Fallback
     * =============
     * If this function is assigned to the wp_nav_menu's fallback_cb variable
     * and a manu has not been assigned to the theme location in the WordPress
     * menu manager the function with display nothing to a non-logged in user,
     * and will add a link to the WordPress menu manager if logged in as an admin.
     *
     * @param array $args passed from the wp_nav_menu function.
     *
     */
    public static function fallback($args)
    {
        if (current_user_can('manage_options')) {

            extract($args);

            $fb_output = null;

            if ($container) {
                $fb_output = '<' . $container;

                if ($container_id)
                    $fb_output .= ' id="' . $container_id . '"';

                if ($container_class)
                    $fb_output .= ' class="' . $container_class . '"';

                $fb_output .= '>';
            }

            $fb_output .= '<ul';

            if ($menu_id)
                $fb_output .= ' id="' . $menu_id . '"';

            if ($menu_class)
                $fb_output .= ' class="' . $menu_class . '"';

            $fb_output .= '>';
            $fb_output .= '<li><a href="' . admin_url('nav-menus.php') . '">' . __('Add a menu', 'your themename') . '</a></li>';
            $fb_output .= '</ul>';

            if ($container)
                $fb_output .= '</' . $container . '>';

            echo $fb_output;
        }
    }
}

/**
 * Class Name: uikit_primary_menu
 * Description: A custom WordPress nav walker class to implement UIkit menu markup
 */
class uikit_primary_menu extends Walker_Nav_Menu
{

    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"uk-navbar-dropdown\">\n<ul role=\"menu\" class=\"uk-nav uk-navbar-dropdown-nav\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker_Nav_Menu::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of page. Used for padding.
     * @param array  $args   Not used.
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent</ul></div>";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';


        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        if ($args->has_children)
            //$class_names .= ' uk-parent';

        $dropdown = ''; /*
				if ( $args->has_children && $depth == 0)
			$dropdown .= ' data-uk-dropdown="{mode:\'click\'}"';*/

        if (in_array('current-menu-item', $classes) || in_array('current-menu-parent', $classes))
            $class_names .= ' uk-active';

        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . $dropdown . '>';

        $atts = array();
        $atts['title']  = !empty($item->title)    ? $item->title    : '';
        $atts['target'] = !empty($item->target)    ? $item->target    : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn    : '';

        // If item has_children add atts to a.
        // if ( $args->has_children && $depth === 0 ) {
        // $atts['href']          = '#';
        // // $atts['data-toggle']   = 'dropdown';
        // // $atts['class']         = 'dropdown-toggle';
        // // $atts['aria-haspopup'] = 'true';
        // } else {
        $atts['href'] = !empty($item->url) ? $item->url : '';
        //}

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;

        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= ($args->has_children && 0 === $depth) ? '</a>' : '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth.
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @see Walker::start_el()
     * @since 2.5.0
     *
     * @param object $element Data object
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args
     * @param string $output Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element)
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if (is_object($args[0]))
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    /**
     * Menu Fallback
     * =============
     * If this function is assigned to the wp_nav_menu's fallback_cb variable
     * and a manu has not been assigned to the theme location in the WordPress
     * menu manager the function with display nothing to a non-logged in user,
     * and will add a link to the WordPress menu manager if logged in as an admin.
     *
     * @param array $args passed from the wp_nav_menu function.
     *
     */
    public static function fallback($args)
    {
        if (current_user_can('manage_options')) {

            extract($args);

            $fb_output = null;

            if ($container) {
                $fb_output = '<' . $container;

                if ($container_id)
                    $fb_output .= ' id="' . $container_id . '"';

                if ($container_class)
                    $fb_output .= ' class="' . $container_class . '"';

                $fb_output .= '>';
            }

            $fb_output .= '<ul';

            if ($menu_id)
                $fb_output .= ' id="' . $menu_id . '"';

            if ($menu_class)
                $fb_output .= ' class="' . $menu_class . '"';

            $fb_output .= '>';
            $fb_output .= '<li><a href="' . admin_url('nav-menus.php') . '">' . __('Add a menu', 'your themename') . '</a></li>';
            $fb_output .= '</ul>';

            if ($container)
                $fb_output .= '</' . $container . '>';

            echo $fb_output;
        }
    }
}

/**
 * Class Name: uikit_offcanvas_output
 * Description: A custom WordPress nav walker class to implement UIkit menu markup
 */
class uikit_offcanvas_w_menu extends Walker_Nav_Menu
{

    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul role=\"menu\" class=\"uk-nav-parent-icon uk-nav-sub\" style=\"display:block !important\">\n";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        if ($args->has_children)
            //$class_names .= ' uk-parent';


        if (in_array('current-menu-item', $classes)  || in_array('current-menu-parent', $classes))
            $class_names .= ' uk-active';

        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li ' . $id . $value . $class_names . '>';

        $atts = array();
        $atts['title']  = !empty($item->title)    ? $item->title    : '';
        $atts['target'] = !empty($item->target)    ? $item->target    : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn    : '';

        // If item has_children add atts to a.
        //if ($args->has_children && $depth === 0) {
        //    $atts['href']          = '#';
            // $atts['data-toggle']   = 'dropdown';
            // $atts['class']         = 'dropdown-toggle';
            // $atts['aria-haspopup'] = 'true';
       // } else //{
            $atts['href'] = !empty($item->url) ? $item->url : '';
        //}

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;

        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth.
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @see Walker::start_el()
     * @since 2.5.0
     *
     * @param object $element Data object
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args
     * @param string $output Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element)
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if (is_object($args[0]))
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    /**
     * Menu Fallback
     * =============
     * If this function is assigned to the wp_nav_menu's fallback_cb variable
     * and a manu has not been assigned to the theme location in the WordPress
     * menu manager the function with display nothing to a non-logged in user,
     * and will add a link to the WordPress menu manager if logged in as an admin.
     *
     * @param array $args passed from the wp_nav_menu function.
     *
     */
    public static function fallback($args)
    {
        if (current_user_can('manage_options')) {

            extract($args);

            $fb_output = null;

            if ($container) {
                $fb_output = '<' . $container;

                if ($container_id)
                    $fb_output .= ' id="' . $container_id . '"';

                if ($container_class)
                    $fb_output .= ' class="' . $container_class . '"';

                $fb_output .= '>';
            }

            $fb_output .= '<ul';

            if ($menu_id)
                $fb_output .= ' id="' . $menu_id . '"';

            if ($menu_class)
                $fb_output .= ' class="' . $menu_class . '"';

            $fb_output .= '>';
            $fb_output .= '<li><a href="' . admin_url('nav-menus.php') . '">' . __('Add a menu', 'Lajuma 2019') . '</a></li>';
            $fb_output .= '</ul>';

            if ($container)
                $fb_output .= '</' . $container . '>';

            echo $fb_output;
        }
    }
}






/**
 * Offcanvas menu
 */
function uikit_offcanvas_menu()
{ ?>

    <div id="offcanvas-menu" uk-offcanvas="overlay: true; flip: true">
        <div class="uk-offcanvas-bar uk-flex uk-flex-column">

            <button class="uk-offcanvas-close" type="button" uk-close></button>
            
                <?php
                wp_nav_menu(array(
                    'menu'              => 'mobile-menu',
                    'theme_location'    => 'mobile-menu',
                    'depth'             => 2,
                    'container'         => 'ul',
                    'items_wrap'        => '<ul id="%1$s" class="%2$s" uk-nav>%3$s</ul>',
                    'menu_class'        => 'uk-nav uk-nav-primary uk-nav-center uk-margin-auto-vertical',
                    'fallback_cb'       => 'uikit_offcanvas_w_menu::fallback',
                    'walker'            => new uikit_offcanvas_w_menu()
                )); ?>

        </div>
    </div>

<?php }
add_action('uikit_offcanvas_menu', 'uikit_offcanvas_menu');


/**
 * Offcanvas menu
 */
function uikit_modal_menu()
{ ?>
    <div id="modal-full" class="uk-modal-full" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <div class="uk-grid-collapse" uk-grid>
                <div uk-height-viewport></div>
                <div class="uk-container uk-width-7-10 uk-text-center">
                    <div class="uk-section-large">
                        <?php if (has_nav_menu('modal-menu')) : ?>
                            <h3><?php _e('Menu', 'modal-menu'); ?></h3>
                            <?php
                            wp_nav_menu(array(
                                'menu'              => 'modal-menu',
                                'theme_location'    => 'modal-menu',
                                'depth'             => 2,
                                'container'         => 'ul',
                                'items_wrap'        => '<ul id="%1$s" class="%2$s" uk-nav>%3$s</ul>',
                                'menu_class'        => 'uk-text-large uk-text-bold uk-nav uk-navbar-dropdown-nav',
                                'fallback_cb'       => 'uikit_offcanvas_w_menu::fallback',
                                'walker'            => new uikit_offcanvas_w_menu()
                            )); ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php }
add_action('uikit_modal_menu', 'uikit_modal_menu');


/**
 * Top menu
 */
function uikit_top_menu()
{ ?>
    <?php wp_nav_menu(array(
        'menu'              => 'top-menu',
        'theme_location'    => 'top-menu',
        'depth'             => 2,
        'container'         => '',
        'menu_class'        => 'uk-navbar-nav uk-visible@m',
        'fallback_cb'       => 'uikit_top_w_menu::fallback',
        'walker'            => new uikit_top_w_menu()
    )); ?>
<?php }
add_action('uikit_top_menu', 'uikit_top_menu');

function uikit_primary_menu()
{ ?>
    <?php wp_nav_menu(array(
        'menu'              => 'nav-menu',
        'theme_location'    => 'nav-menu',
        'depth'             => 3,
        'container'         => '',
        'menu_class'        => 'uk-navbar-nav uk-visible@m',
        'fallback_cb'       => 'uikit_primary_menu::fallback',
        'walker'            => new uikit_primary_menu()
    )); ?>
<?php }
add_action('uikit_primary_menu', 'uikit_primary_menu');


function wpb_custom_new_menu()
{
    register_nav_menus(
        array(
            'top-menu' => __('Top menu'),
            'modal-menu' => __('mobile Modal menu'),
            'mobile-menu' => __('mobile Menu offcanvas'),
            'footer-menu' => __('Footer Menu'),
            'nav-menu' => __('Nav Menu')
        )
    );
}
add_action('init', 'wpb_custom_new_menu');
