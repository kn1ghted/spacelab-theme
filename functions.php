<?php

require_once(get_stylesheet_directory() . '/layouts/menu/uikitmenu.php');

// Add Custom JS CSS
function add_theme_scripts()
{
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('uikitcss', get_template_directory_uri() . '/assets/css/uikit.min.css', array(), '1.1', 'all');
    wp_enqueue_style('maincss', get_template_directory_uri() . '/assets/css/main.css', array(), '', 'all');
    wp_enqueue_script('uikitjs', get_template_directory_uri() . '/assets/js/uikit.min.js', array('jquery'), 1.1, false);
    wp_enqueue_script('icons', get_template_directory_uri() . '/assets/js/uikit-icons.min.js', array('jquery'), 1.1, false);
    //wp_enqueue_script('mainjs', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '', false);
    //wp_enqueue_script('counterjs', get_template_directory_uri() . '/assets/js/counterup.min.js', array('jquery'), '', false);
}
add_action('wp_enqueue_scripts', 'add_theme_scripts');

// title tag
add_theme_support('title-tag');

// post thumbnail
add_theme_support('post-thumbnails');

//Page Slug Body Class
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4);

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function fix_svg()
{
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action('admin_head', 'fix_svg');

// ACF Options Page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}

?>