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
                        <p>Special collection already available.</p><a
                            href="<?php echo get_template_directory_uri(); ?>/#">&nbsp;Read more ...</a>
                    </div><!-- End .header-left -->

                    <div class="header-right">

                        <ul class="top-menu">
                            <li>
                                <a href="<?php echo get_template_directory_uri(); ?>/#">Links</a>
                                <ul>
                                    <li>
                                        <div class="header-dropdown">
                                            <a href="<?php echo get_template_directory_uri(); ?>/#">USD</a>
                                            <div class="header-menu">
                                                <ul>
                                                    <li><a href="<?php echo get_template_directory_uri(); ?>/#">Eur</a>
                                                    </li>
                                                    <li><a href="<?php echo get_template_directory_uri(); ?>/#">Usd</a>
                                                    </li>
                                                </ul>
                                            </div><!-- End .header-menu -->
                                        </div>
                                    </li>
                                    <li>
                                        <div class="header-dropdown">
                                            <a href="<?php echo get_template_directory_uri(); ?>/#">English</a>
                                            <div class="header-menu">
                                                <ul>
                                                    <li><a
                                                            href="<?php echo get_template_directory_uri(); ?>/#">English</a>
                                                    </li>
                                                    <li><a
                                                            href="<?php echo get_template_directory_uri(); ?>/#">French</a>
                                                    </li>
                                                    <li><a
                                                            href="<?php echo get_template_directory_uri(); ?>/#">Spanish</a>
                                                    </li>
                                                </ul>
                                            </div><!-- End .header-menu -->
                                        </div>
                                    </li>
                                    <li><a href="<?php echo get_template_directory_uri(); ?>/#signin-modal"
                                            data-toggle="modal">Sign in / Sign up</a></li>
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

                        <a href="<?php echo get_template_directory_uri(); ?>/index.html" class="logo">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/logo.png"
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
                            <a href="<?php echo get_template_directory_uri(); ?>/dashboard.html" title="My account">
                                <div class="icon">
                                    <i class="icon-user"></i>
                                </div>
                                <p>Account</p>
                            </a>
                        </div><!-- End .compare-dropdown -->

                        <div class="wishlist">
                            <a href="<?php echo get_template_directory_uri(); ?>/wishlist.html" title="Wishlist">
                                <div class="icon">
                                    <i class="icon-heart-o"></i>
                                    <span class="wishlist-count badge">3</span>
                                </div>
                                <p>Wishlist</p>
                            </a>
                        </div><!-- End .compare-dropdown -->

                        <div class="dropdown cart-dropdown">
                            <a href="<?php echo get_template_directory_uri(); ?>/#" class="dropdown-toggle"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-display="static">
                                <div class="icon">
                                    <i class="icon-shopping-cart"></i>
                                    <span class="cart-count">2</span>
                                </div>
                                <p>Cart</p>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="<?php echo get_template_directory_uri(); ?>/product.html">Beige
                                                    knitted elastic runner shoes</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">1</span>
                                                x $84.00
                                            </span>
                                        </div><!-- End .product-cart-details -->

                                        <figure class="product-image-container">
                                            <a href="<?php echo get_template_directory_uri(); ?>/product.html"
                                                class="product-image">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/cart/product-1.jpg"
                                                    alt="product">
                                            </a>
                                        </figure>
                                        <a href="<?php echo get_template_directory_uri(); ?>/#" class="btn-remove"
                                            title="Remove Product"><i class="icon-close"></i></a>
                                    </div><!-- End .product -->

                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="<?php echo get_template_directory_uri(); ?>/product.html">Blue
                                                    utility pinafore denim dress</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">1</span>
                                                x $76.00
                                            </span>
                                        </div><!-- End .product-cart-details -->

                                        <figure class="product-image-container">
                                            <a href="<?php echo get_template_directory_uri(); ?>/product.html"
                                                class="product-image">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/cart/product-2.jpg"
                                                    alt="product">
                                            </a>
                                        </figure>
                                        <a href="<?php echo get_template_directory_uri(); ?>/#" class="btn-remove"
                                            title="Remove Product"><i class="icon-close"></i></a>
                                    </div><!-- End .product -->
                                </div><!-- End .cart-product -->

                                <div class="dropdown-cart-total">
                                    <span>Total</span>

                                    <span class="cart-total-price">$160.00</span>
                                </div><!-- End .dropdown-cart-total -->

                                <div class="dropdown-cart-action">
                                    <a href="<?php echo get_template_directory_uri(); ?>/cart.html"
                                        class="btn btn-primary">View Cart</a>
                                    <a href="<?php echo get_template_directory_uri(); ?>/checkout.html"
                                        class="btn btn-outline-primary-2"><span>Checkout</span><i
                                            class="icon-long-arrow-right"></i></a>
                                </div><!-- End .dropdown-cart-total -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->

            <div class="header-bottom sticky-header">
                <div class="container">
                    <div class="header-left">
                        <div class="dropdown category-dropdown">
                            <a href="<?php echo get_template_directory_uri(); ?>/#" class="dropdown-toggle"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-display="static" title="Browse Categories">
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