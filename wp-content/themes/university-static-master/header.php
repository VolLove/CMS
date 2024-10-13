<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
        href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i"
        rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body>
    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php echo wp_get_document_title() ?><strong>
                </a>
            </h1>
            <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search"
                    aria-hidden="true"></i></span>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <!-- navigation menu -->
                <nav class="main-navigation">
                    <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
                </nav>
                <div class="site-header__util">

                    <?php
                    // Kiểm tra xem người dùng đã đăng nhập hay chưa
                    if (is_user_logged_in()) {
                        // Hiển thị nút đăng xuất
                    ?>
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"
                        class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                    <?php
                    } else {
                    ?>
                    <a href="<?php echo esc_url(wp_login_url()); ?>"
                        class="btn btn--small btn--orange float-left push-right">Login</a>
                    <?php
                    }
                    ?>

                    <span class="search-trigger js-search-trigger"><i class="fa fa-search"
                            aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </header>