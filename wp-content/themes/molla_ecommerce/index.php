<?php
get_header(); // Gọi file header.php
?>

<main class="main">
    <div class="intro-slider-container">
        <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl"
            data-owl-options='{"nav": false}'>
            <div class="intro-slide"
                style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/slider/slide-1.jpg);">
                <div class="container intro-content">
                    <h3 class="intro-subtitle">Bedroom Furniture</h3><!-- End .h3 intro-subtitle -->
                    <h1 class="intro-title">Find Comfort <br>That Suits You.</h1><!-- End .intro-title -->

                    <a href="<?php echo get_template_directory_uri(); ?>/category.html" class="btn btn-primary">
                        <span>Shop Now</span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->

            <div class="intro-slide"
                style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/slider/slide-2.jpg);">
                <div class="container intro-content">
                    <h3 class="intro-subtitle">Deals and Promotions</h3><!-- End .h3 intro-subtitle -->
                    <h1 class="intro-title">Ypperlig <br>Coffee Table <br><span
                            class="text-primary"><sup>$</sup>49,99</span></h1><!-- End .intro-title -->

                    <a href="<?php echo get_template_directory_uri(); ?>/category.html" class="btn btn-primary">
                        <span>Shop Now</span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->

            <div class="intro-slide"
                style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/slider/slide-3.jpg);">
                <div class="container intro-content">
                    <h3 class="intro-subtitle">Living Room</h3><!-- End .h3 intro-subtitle -->
                    <h1 class="intro-title">
                        Make Your Living Room <br>Work For You.<br>
                        <span class="text-primary">
                            <sup class="text-white font-weight-light">from</sup><sup>$</sup>9,99
                        </span>
                    </h1><!-- End .intro-title -->

                    <a href="<?php echo get_template_directory_uri(); ?>/category.html" class="btn btn-primary">
                        <span>Shop Now</span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->
        </div><!-- End .owl-carousel owl-simple -->

        <span class="slider-loader text-white"></span>
        <!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->

    <div class="mb-3 mb-lg-5"></div><!-- End .mb-3 mb-lg-5 -->

    <div class="banner-group">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-5">
                    <div class="banner banner-large banner-overlay banner-overlay-light">
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/banners/banner-1.jpg"
                                alt="Banner">
                        </a>

                        <div class="banner-content banner-content-top">
                            <h4 class="banner-subtitle">Clearence</h4><!-- End .banner-subtitle -->
                            <h3 class="banner-title">Coffee Tables</h3><!-- End .banner-title -->
                            <div class="banner-text">from $19.99</div><!-- End .banner-text -->
                            <a href="<?php echo get_template_directory_uri(); ?>/#"
                                class="btn btn-outline-gray banner-link">Shop Now<i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-lg-5 -->

                <div class="col-md-6 col-lg-3">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/banners/banner-2.jpg"
                                alt="Banner">
                        </a>

                        <div class="banner-content banner-content-bottom">
                            <h4 class="banner-subtitle text-grey">On Sale</h4><!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white">Amazing <br>Armchairs</h3>
                            <!-- End .banner-title -->
                            <div class="banner-text text-white">from $39.99</div><!-- End .banner-text -->
                            <a href="<?php echo get_template_directory_uri(); ?>/#"
                                class="btn btn-outline-white banner-link">Discover Now<i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-lg-3 -->

                <div class="col-md-6 col-lg-4">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/banners/banner-3.jpg"
                                alt="Banner">
                        </a>

                        <div class="banner-content banner-content-top">
                            <h4 class="banner-subtitle text-grey">New Arrivals</h4><!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white">Storage <br>Boxes & Baskets</h3>
                            <!-- End .banner-title -->
                            <a href="<?php echo get_template_directory_uri(); ?>/#"
                                class="btn btn-outline-white banner-link">Discover Now<i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->

                    <div class="banner banner-overlay banner-overlay-light">
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/banners/banner-4.jpg"
                                alt="Banner">
                        </a>

                        <div class="banner-content banner-content-top">
                            <h4 class="banner-subtitle">On Sale</h4><!-- End .banner-subtitle -->
                            <h3 class="banner-title">Lamps Offer</h3><!-- End .banner-title -->
                            <div class="banner-text">up to 30% off</div><!-- End .banner-text -->
                            <a href="<?php echo get_template_directory_uri(); ?>/#"
                                class="btn btn-outline-gray banner-link">Shop Now<i
                                    class="icon-long-arrow-right"></i></a>
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-lg-4 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .banner-group -->

    <div class="mb-3"></div><!-- End .mb-6 -->

    <div class="container">
        <?php display_top_10_best_selling_products_per_category() ?>
    </div><!-- End .container -->

    <div class="container">
        <hr class="mt-1 mb-6">
    </div><!-- End .container -->

    <div class="blog-posts">
        <div class="container">
            <h2 class="title text-center">From Our Blog</h2><!-- End .title-lg text-center -->

            <div class="owl-carousel owl-simple carousel-with-shadow" data-toggle="owl" data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                }
                            }
                        }'>
                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="<?php echo get_template_directory_uri(); ?>/single.html">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/blog/post-1.jpg"
                                alt="image desc">
                        </a>
                    </figure><!-- End .entry-media -->

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Nov 22, 2018</a>, 0 Comments
                        </div><!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="<?php echo get_template_directory_uri(); ?>/single.html">Sed adipiscing
                                ornare.</a>
                        </h3><!-- End .entry-title -->

                        <div class="entry-content">
                            <a href="<?php echo get_template_directory_uri(); ?>/single.html" class="read-more">Continue
                                Reading</a>
                        </div><!-- End .entry-content -->
                    </div><!-- End .entry-body -->
                </article><!-- End .entry -->

                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="<?php echo get_template_directory_uri(); ?>/single.html">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/blog/post-2.jpg"
                                alt="image desc">
                        </a>
                    </figure><!-- End .entry-media -->

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 12, 2018</a>, 0 Comments
                        </div><!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="<?php echo get_template_directory_uri(); ?>/single.html">Fusce lacinia
                                arcuet nulla.</a>
                        </h3><!-- End .entry-title -->

                        <div class="entry-content">
                            <a href="<?php echo get_template_directory_uri(); ?>/single.html" class="read-more">Continue
                                Reading</a>
                        </div><!-- End .entry-content -->
                    </div><!-- End .entry-body -->
                </article><!-- End .entry -->

                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="<?php echo get_template_directory_uri(); ?>/single.html">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demos/demo-2/blog/post-3.jpg"
                                alt="image desc">
                        </a>
                    </figure><!-- End .entry-media -->

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 19, 2018</a>, 2 Comments
                        </div><!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="<?php echo get_template_directory_uri(); ?>/single.html">Quisque volutpat
                                mattis eros.</a>
                        </h3><!-- End .entry-title -->

                        <div class="entry-content">
                            <a href="<?php echo get_template_directory_uri(); ?>/single.html" class="read-more">Continue
                                Reading</a>
                        </div><!-- End .entry-content -->
                    </div><!-- End .entry-body -->
                </article><!-- End .entry -->
            </div><!-- End .owl-carousel -->

            <div class="more-container text-center mt-2">
                <a href="<?php echo get_template_directory_uri(); ?>/blog.html"
                    class="btn btn-outline-darker btn-more"><span>View more articles</span><i
                        class="icon-long-arrow-right"></i></a>
            </div><!-- End .more-container -->
        </div><!-- End .container -->
    </div><!-- End .blog-posts -->
</main><!-- End .main -->
<?php
get_footer(); // Gọi file footer.php
?>