<?php
function my_custom_theme_enqueue_styles()
{
    // Đường dẫn tới thư mục theme
    $theme_directory = get_stylesheet_directory_uri();
    // Enqueue các file CSS
    wp_enqueue_style('line-awesome', $theme_directory . '/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css');
    wp_enqueue_style('bootstrap', $theme_directory . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('owl-carousel', $theme_directory . '/assets/css/plugins/owl-carousel/owl.carousel.css');
    wp_enqueue_style('magnific-popup', $theme_directory . '/assets/css/plugins/magnific-popup/magnific-popup.css');
    wp_enqueue_style('jquery-countdown', $theme_directory . '/assets/css/plugins/jquery.countdown.css');
    wp_enqueue_style('main', $theme_directory . '/assets/css/style.css');
    wp_enqueue_style('skin-demo', $theme_directory . '/assets/css/skins/skin-demo-2.css');
    wp_enqueue_style('demo', $theme_directory . '/assets/css/demos/demo-2.css');
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_styles');

function my_custom_theme_enqueue_scripts()
{
    // Đường dẫn tới thư mục theme
    $theme_directory = get_template_directory_uri();

    // Enqueue các file JS
    wp_enqueue_script('jquery', $theme_directory . '/assets/js/jquery.min.js', array(), null, true);
    wp_enqueue_script('bootstrap-bundle', $theme_directory . '/assets/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('hover-intent', $theme_directory . '/assets/js/jquery.hoverIntent.min.js', array('jquery'), null, true);
    wp_enqueue_script('waypoints', $theme_directory . '/assets/js/jquery.waypoints.min.js', array('jquery'), null, true);
    wp_enqueue_script('superfish', $theme_directory . '/assets/js/superfish.min.js', array('jquery'), null, true);
    wp_enqueue_script('owl-carousel', $theme_directory . '/assets/js/owl.carousel.min.js', array('jquery'), null, true);
    wp_enqueue_script('plugin', $theme_directory . '/assets/js/jquery.plugin.min.js', array('jquery'), null, true);
    wp_enqueue_script('magnific-popup', $theme_directory . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), null, true);
    wp_enqueue_script('countdown', $theme_directory . '/assets/js/jquery.countdown.min.js', array('jquery'), null, true);
    wp_enqueue_script('main', $theme_directory . '/assets/js/main.js', array('jquery'), null, true);
    wp_enqueue_script('demo-2', $theme_directory . '/assets/js/demo-2.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_scripts');
function create_product_post_type()
{
    $labels = array(
        'name' => 'Sản phẩm',
        'singular_name' => 'Sản phẩm',
        'menu_name' => 'Sản phẩm',
        'name_admin_bar' => 'Sản phẩm',
        'add_new' => 'Thêm mới',
        'add_new_item' => 'Thêm sản phẩm mới',
        'new_item' => 'Sản phẩm mới',
        'edit_item' => 'Chỉnh sửa sản phẩm',
        'view_item' => 'Xem sản phẩm',
        'all_items' => 'Tất cả sản phẩm',
        'search_items' => 'Tìm kiếm sản phẩm',
        'not_found' => 'Không tìm thấy',
        'not_found_in_trash' => 'Không tìm thấy trong thùng rác',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'san-pham'),
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'), // Thêm 'thumbnail' tại đây
        'menu_position' => 5,
        'menu_icon' => 'dashicons-cart',
    );

    register_post_type('product', $args);
}
add_action('init', 'create_product_post_type');
add_theme_support('post-thumbnails');
function display_products_list()
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
?>
            <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                <div class="product product-11 text-center">
                    <figure class="product-media">
                        <a href="<?php echo get_permalink() ?>">
                            <?php the_post_thumbnail('medium'); ?>

                        </a>

                        <div class="product-action-vertical">
                            <a href="<?php echo get_template_directory_uri(); ?>/#" class="btn-product-icon btn-wishlist "><span>add
                                    to
                                    wishlist</span></a>
                        </div><!-- End .product-action-vertical -->
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="#">Lighting</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="<?php echo get_permalink() ?>">
                                <?php echo get_the_title() ?></a></h3>
                        <!-- End .product-title -->
                        <div class="product-price">
                            $401,00
                        </div><!-- End .product-price -->
                    </div><!-- End .product-body -->
                    <div class="product-action">
                        <a href="<?php echo get_template_directory_uri(); ?>/#" class="btn-product btn-cart"><span>add to
                                cart</span></a>
                    </div><!-- End .product-action -->
                </div><!-- End .product -->
            </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
<?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>Không có sản phẩm nào.</p>';
    }
}
add_shortcode('product_list', 'display_products_list');
function create_product_taxonomy()
{
    $labels = array(
        'name'              => 'Loại sản phẩm',
        'singular_name'     => 'Loại sản phẩm',
        'search_items'      => 'Tìm kiếm loại sản phẩm',
        'all_items'         => 'Tất cả loại sản phẩm',
        'parent_item'       => 'Loại sản phẩm cha',
        'parent_item_colon' => 'Loại sản phẩm cha:',
        'edit_item'         => 'Chỉnh sửa loại sản phẩm',
        'update_item'       => 'Cập nhật loại sản phẩm',
        'add_new_item'      => 'Thêm loại sản phẩm mới',
        'new_item_name'     => 'Tên loại sản phẩm mới',
        'menu_name'         => 'Loại sản phẩm',
    );

    $args = array(
        'hierarchical'      => true, // true cho phép phân cấp giống như categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'loai-san-pham'),
    );

    register_taxonomy('product_category', array('product'), $args);
}
add_action('init', 'create_product_taxonomy');
function get_best_selling_products($num_products = 5)
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $num_products,
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul class="best-selling-products">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li>';
            // Hiển thị hình ảnh
            if (has_post_thumbnail()) {
                echo '<a href="' . get_permalink() . '">';
                the_post_thumbnail('medium');
                echo '</a>';
            }
            // Hiển thị tên sản phẩm
            echo '<a href="' . get_permalink() . '"><h2>' . get_the_title() . '</h2></a>';
            echo '</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>Không có sản phẩm bán chạy nào.</p>';
    }
}
add_action('product_list', 'get_best_selling_products');
