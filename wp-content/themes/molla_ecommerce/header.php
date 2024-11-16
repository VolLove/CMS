<!DOCTYPE html>
<html <?php language_attributes(); ?>>


<!-- molla/index-1.html  22 Nov 2019 09:55:06 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <title>Molla - Bootstrap eCommerce Template</title> -->
    <title><?php bloginfo('name'); ?></title>
    <!-- Favicon -->
    <?php wp_head(); ?>
</head>

<body>
    <div class="page-wrapper">
        <header class="header header-2 header-intro-clearance">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                    </div><!-- End .header-left -->

                    <div class="header-right">

                        <ul class="top-menu">
                            <li>
                                <a href="<?php echo get_template_directory_uri(); ?>/#">Links</a>
                                <ul>
                                    <li>
                                        <?php if (is_user_logged_in()) : ?>
                                            <a href="<?php echo wp_logout_url(home_url()); ?>">Sign out</a>
                                        <?php else : ?>
                                            <a href="<?php echo wp_login_url(home_url()); ?>">Sign in / Sign up</a>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </li>
                        </ul><!-- End .top-menu -->
                    </div><!-- End .header-right -->

                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="<?php echo home_url(); ?>" class="logo">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png"
                                alt="Molla Logo" width="105" height="25">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <div
                            class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                            <a href="<?php echo get_template_directory_uri(); ?>/#" class="search-toggle"
                                role="button"><i class="icon-search"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper search-wrapper-wide">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q"
                                        placeholder="Search product ..." required>
                                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                    </div>

                    <div class="header-right">
                        <div class="account">
                            <a href="<?php
                                        $user_id = get_current_user_id();
                                        echo get_edit_profile_url($user_id); ?>" title="My account">
                                <div class="icon">
                                    <i class="icon-user"></i>
                                </div>
                                <p>Account</p>
                            </a>
                        </div><!-- End .compare-dropdown -->

                        <div class="wishlist">
                            <a href="<?php echo get_template_directory_uri(); ?>" title="Wishlist">
                                <div class="icon">
                                    <i class="icon-heart-o"></i>
                                    <span class="wishlist-count badge">3</span>
                                </div>
                                <p>Wishlist</p>
                            </a>
                        </div><!-- End .compare-dropdown -->

                        <div class="dropdown cart-dropdown" id="cart-dropdown-content">
                            <?php display_cart() ?>
                        </div><!-- End .cart-dropdown -->

                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->

            <div class="header-bottom sticky-header">
                <div class="container">
                    <div class="header-left">
                        <div class="dropdown category-dropdown">
                            <a href="" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" data-display="static" title="Browse Categories">
                                Browse Categories
                            </a>
                            <div class="dropdown-menu">
                                <?php show_custom_menu('browse-categories', 'side-nav', 'menu-vertical') ?>
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .category-dropdown -->
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <?php show_custom_menu('header-menu', 'main-nav', 'menu') ?>
                    </div><!-- End .header-center -->

                    <div class="header-right">
                        <i class="la la-lightbulb-o"></i>
                        <p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
                    </div>
                </div><!-- End .container -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->