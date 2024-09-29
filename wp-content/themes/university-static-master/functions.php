<?php
// Thêm hỗ trợ cho menu
function theme_setup()
{
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'theme')
    ));
}
add_action('after_setup_theme', 'theme_setup');

function my_custom_theme_enqueue_styles()
{
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');

    wp_enqueue_style('responsive', get_stylesheet_directory_uri() . '/css/responsive.css', array('style'));
}

add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_styles');

function theme_enqueue_scripts()
{
    wp_enqueue_script(
        'custom-script',
        get_template_directory_uri() . '/js/script.js',
        array(),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
