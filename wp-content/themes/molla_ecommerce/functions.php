<?php
function my_custom_theme_enqueue_styles()
{
    // Đường dẫn tới thư mục theme
    $theme_directory = get_template_directory_uri();

    // Enqueue các file CSS
    wp_enqueue_style('line-awesome', $theme_directory . '/assets/vendor/line-awesome/line-awesome/css/line-awesome.min.css');
    wp_enqueue_style('bootstrap', $theme_directory . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('owl-carousel', $theme_directory . '/assets/css/plugins/owl-carousel/owl.carousel.css');
    wp_enqueue_style('magnific-popup', $theme_directory . '/assets/css/plugins/magnific-popup/magnific-popup.css');
    wp_enqueue_style('jquery-countdown', $theme_directory . '/assets/css/plugins/jquery.countdown.css');
    wp_enqueue_style('main-style', $theme_directory . '/assets/css/style.css');
    wp_enqueue_style('skin-demo', $theme_directory . '/assets/css/skins/skin-demo-2.css');
    wp_enqueue_style('demo', $theme_directory . '/assets/css/demos/demo-2.css');
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_styles');