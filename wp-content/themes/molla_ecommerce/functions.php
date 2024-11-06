<?php
// Đăng ký menu tùy chỉnh
function register_custom_menus()
{
    register_nav_menus(array(
        'header-menu' => __('Header Menu', 'text-domain'),
        'footer-menu' => __('Footer Menu', 'text-domain'),
        'browse-categories' => __('Browse Categories', 'text-domain'),
    ));
}
add_action('after_setup_theme', 'register_custom_menus');
// Hiển thị menu
function show_custom_menu($theme_location, $container_class, $menu_class)
{
    wp_nav_menu(array(
        'theme_location' => $theme_location, // Tên vị trí menu đã đăng ký
        'container' => 'nav', // Thẻ bao quanh menu, có thể đổi thành 'div', 'section' nếu cần
        'container_class' => $container_class, // Class của thẻ bao quanh menu
        'menu_class' => $menu_class, // Class của <ul> chứa các mục menu
        'fallback_cb' => false // Không hiển thị menu mặc định nếu menu không tồn tại
    ));
}
function my_custom_theme_enqueue_styles()
{
    // Đường dẫn tới thư mục theme
    $theme_directory = get_stylesheet_directory_uri();
    // Enqueue các file CSS
    wp_enqueue_style('line-awesome', $theme_directory .
        '/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css');
    wp_enqueue_style('bootstrap', $theme_directory . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('owl-carousel', $theme_directory . '/assets/css/plugins/owl-carousel/owl.carousel.css');
    wp_enqueue_style('magnific-popup', $theme_directory . '/assets/css/plugins/magnific-popup/magnific-popup.css');
    wp_enqueue_style('jquery-countdown', $theme_directory . '/assets/css/plugins/jquery.countdown.css');
    wp_enqueue_style('style', $theme_directory . '/assets/css/style.css');
    wp_enqueue_style('skin-demo', $theme_directory . '/assets/css/skins/skin-demo-2.css');
    wp_enqueue_style('demo', $theme_directory . '/assets/css/demos/demo-2.css');
    wp_enqueue_style('main-style', $theme_directory . '/style.css');
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_styles');

function my_custom_theme_enqueue_scripts()
{
    // Đường dẫn tới thư mục theme
    $theme_directory = get_template_directory_uri();

    // Enqueue các file JS
    wp_enqueue_script('jquery', $theme_directory . '/assets/js/jquery.min.js', array(), null, true);
    wp_enqueue_script(
        'bootstrap-bundle',
        $theme_directory . '/assets/js/bootstrap.bundle.min.js',
        array('jquery'),
        null,
        true
    );
    wp_enqueue_script(
        'hover-intent',
        $theme_directory . '/assets/js/jquery.hoverIntent.min.js',
        array('jquery'),
        null,
        true
    );
    wp_enqueue_script('waypoints', $theme_directory . '/assets/js/jquery.waypoints.min.js', array('jquery'), null, true);
    wp_enqueue_script('superfish', $theme_directory . '/assets/js/superfish.min.js', array('jquery'), null, true);
    wp_enqueue_script('owl-carousel', $theme_directory . '/assets/js/owl.carousel.min.js', array('jquery'), null, true);
    wp_enqueue_script('plugin', $theme_directory . '/assets/js/jquery.plugin.min.js', array('jquery'), null, true);
    wp_enqueue_script(
        'magnific-popup',
        $theme_directory . '/assets/js/jquery.magnific-popup.min.js',
        array('jquery'),
        null,
        true
    );
    wp_enqueue_script('countdown', $theme_directory . '/assets/js/jquery.countdown.min.js', array('jquery'), null, true);
    wp_enqueue_script('main', $theme_directory . '/assets/js/main.js', array('jquery'), null, true);
    wp_enqueue_script('demo-2', $theme_directory . '/assets/js/demo-2.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_scripts');

function display_products_list()
{
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        'paged' => $paged
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) : ?>
        <div class="row justify-content-center">
            <?php while ($query->have_posts()) :
                $query->the_post(); ?>
                <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                    <div class="product product-11 text-center">
                        <figure class="product-media">
                            <a href="<?php echo get_permalink() ?>">
                                <?php the_post_thumbnail('medium'); ?>

                            </a>

                            <div class="product-action-vertical">
                                <a href="" class="btn-product-icon btn-wishlist "><span>add
                                        to
                                        wishlist</span></a>
                            </div><!-- End .product-action-vertical -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">
                                    <?php $terms = get_the_terms(get_the_ID(), 'product_category');
                                    if ($terms && !is_wp_error($terms)) {
                                        echo '<ul class="product-categories">';
                                        foreach ($terms as $term) {
                                            echo '<li>' . esc_html($term->name) . '</li>';
                                        }
                                        echo '</ul>';
                                    } ?>
                                </a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="<?php echo get_permalink() ?>">
                                    <?php echo get_the_title() ?></a></h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <?php
                                $product_price = get_post_meta(get_the_ID(), '_product_price', true);
                                if ($product_price) {
                                    echo  number_format($product_price, 0, ',', '.') . ' VNĐ';
                                }
                                ?>
                            </div><!-- End .product-price -->
                        </div><!-- End .product-body -->
                        <div class="product-action">
                            <a href="" class="btn-product btn-cart"><span>add to
                                    cart</span></a>
                        </div><!-- End .product-action -->
                    </div><!-- End .product -->
                </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
            <?php endwhile; ?>
        </div><!-- End .row -->
        <?php
        // Phân trang
        $pagination_args = array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'mid_size' => 2,
            'prev_text' => __('&laquo; Trước'),
            'next_text' => __('Tiếp &raquo;')
        );
        ?>
        <nav aria-label="Page navigation">
            <div class="pagination">
                <?php echo paginate_links($pagination_args); ?>
            </div>
        </nav>
    <?php

        wp_reset_postdata();
    else :
        echo '<p>Không có sản phẩm nào.</p>';
    endif;
}
function display_top_10_best_selling_products_per_category()
{
    // Lấy tất cả các loại sản phẩm (taxonomy)
    $categories = get_terms(array(
        'taxonomy' => 'product_category',
        'hide_empty' => true, // Chỉ lấy các loại có sản phẩm
        'number' => 3, // Chỉ lấy 3 loại sản phẩm
    ));

    if ($categories && !is_wp_error($categories)) {
        $count = 0; ?>
        <div class="container">
            <ul class="nav nav-pills nav-border-anim nav-big justify-content-center mb-3" role="tablist">
                <?php foreach ($categories as $category) {
                    $active_class = ($count === 0) ? 'active' : ''; ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_class ?>" id="products-<?php echo $count; ?>-link" data-toggle="tab"
                            href="#products-<?php echo $count; ?>-tab" role="tab" aria-controls="products-<?php echo $count; ?>-tab"
                            aria-selected="true"><?php echo esc_html($category->name); ?></a>
                    </li>
                <?php $count++;
                } ?>
            </ul>
        </div><!-- End .container -->
        <div class="container-fluid">
            <div class="tab-content tab-content-carousel">
                <?php $count = 0;
                foreach ($categories as $category) {
                    $active_class = ($count === 0) ? 'active' : ''; ?>
                    <div class="tab-pane p-0 fade show <?php echo $active_class ?>" id="products-<?php echo $count; ?>-tab"
                        role="tabpanel" aria-labelledby="products-<?php echo $count; ?>-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                            data-owl-options='{"nav": false,"dots": true,"margin": 20,"loop": false,"responsive": {"0": {"items":2},"480": {"items":2},"768": {"items":3},"992": {"items":4},"1200": {"items":5},"1600": {"items":6,"nav": true}}}'>
                            <?php $args = array(
                                // Truy vấn 10 sản phẩm bán chạy nhất trong loại sản phẩm này
                                'post_type' => 'product',
                                'posts_per_page' => 10, // Thay bằng meta key phù hợp
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_category',
                                        'field' => 'term_id',
                                        'terms' => $category->term_id,
                                    ),
                                ),
                            );
                            $query = new WP_Query($args);
                            if ($query->have_posts()) { ?>
                                <?php while ($query->have_posts()) {
                                    $query->the_post(); ?>
                                    <div class="product product-11 text-center">
                                        <figure class="product-media">
                                            <a href="<?php echo get_permalink() ?>">
                                                <?php if (has_post_thumbnail()) {
                                                    the_post_thumbnail('thumbnail');
                                                } ?>
                                            </a>

                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-wishlist"><span>add to
                                                        wishlist</span></a>
                                            </div><!-- End .product-action-vertical -->
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <h3 class="product-title"><a href="product.html"><?php the_title(); ?>r</a></h3>
                                            <!-- End .product-title -->
                                            <div class="product-price">
                                                $251,00
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                        <div class="product-action">
                                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                        </div><!-- End .product-action -->
                                    </div><!-- End .product -->

                                <?php } ?>

                            <?php       } else {
                                echo $count;
                            }
                            // Reset lại truy vấn
                            wp_reset_postdata(); ?>
                        </div><!-- End .owl-carousel -->
                    </div><!-- .End .tab-pane -->
                <?php
                    $count++;
                } ?>

            </div><!-- End .tab-content -->
        </div><!-- End .container-fluid -->
<?php } else {
        echo '<p>Không có loại sản phẩm nào.</p>';
    }
}
