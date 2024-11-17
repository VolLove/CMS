<?php
function theme_create_cart_page()
{
    // Kiểm tra xem trang giỏ hàng đã tồn tại chưa
    $cart_page = get_page_by_path('gio-hang');

    // Nếu trang chưa tồn tại, tạo trang mới
    if (!$cart_page) {
        $new_page = array(
            'post_title'    => 'Shopping Cart',
            'post_content'  => '[cart_content]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => 'gio-hang'
        );

        // Tạo trang mới
        wp_insert_post($new_page);
    }
    // Kiểm tra xem trang thanh toán đã tồn tại chưa (dùng slug)
    $checkout_page = get_page_by_path('thanh-toan');

    // Nếu trang chưa tồn tại, tạo trang mới
    if (!$checkout_page) {
        $new_page_id = wp_insert_post(array(
            'post_title'    => 'Checkout',
            'post_content'  => '[checkout_content]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => 'thanh-toan'
        ));

        // Tạo trang mới
        wp_insert_post($new_page_id);
    }
    // Kiểm tra xem trang login đã tồn tại chưa (dùng slug)
    $login_page = get_page_by_path('login');

    // Nếu trang chưa tồn tại, tạo trang mới
    if (!$login_page) {
        $new_page_id = wp_insert_post(array(
            'post_title'    => 'Login',
            'page_template' => 'login.php',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => 'login'
        ));

        // Tạo trang mới
        wp_insert_post($new_page_id);
    }
}
// Gọi hàm tạo trang khi theme được kích hoạt
add_action('after_switch_theme', 'theme_create_cart_page');
// Đăng ký menu tùy chỉnh
function register_custom_menus()
{
    register_nav_menus(array(
        'header-menu' => __('Header Menu', 'text-domain'),
        'footer-menu' => __('Footer Menu', 'text-domain'),
        'browse-categories' => __('Browse Categories', 'text-domain'),
        'footer-menu-information' => __('Footer Menu Information', 'text-domain'),
        'footer-menu-service' => __('Footer Menu Service', 'text-domain'),
        'footer-menu-account' => __('Footer Menu Account', 'text-domain'),
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

function display_top_10_best_selling_products_per_category()
{
    // Lấy tất cả các loại sản phẩm (taxonomy)
    $categories = get_terms(array(
        'taxonomy' => 'product_category',
        'hide_empty' => true, // Chỉ lấy các loại có sản phẩm
    ));

    if ($categories && !is_wp_error($categories)) {
        $count = 0; ?>
<div class="heading heading-center mb-3">
    <h2 class="title">Top Selling Products</h2><!-- End .title -->
    <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
        <?php foreach ($categories as $category) {
                    $active_class = ($count === 0) ? 'active' : ''; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active_class ?>" id="top-<?php echo $count; ?>-link" data-toggle="tab"
                href="#top-<?php echo $count; ?>-tab" role="tab" aria-controls="top-<?php echo $count; ?>-tab"
                aria-selected="true"><?php echo esc_html($category->name); ?></a>
        </li>
        <?php $count++;
                } ?>
    </ul>
</div><!-- End .heading -->
<div class="tab-content">
    <div class="tab-content tab-content-carousel">
        <?php $count = 0;
                foreach ($categories as $category) {
                    $active_class = ($count === 0) ? 'active' : ''; ?>
        <div class="tab-pane p-0 fade show <?php echo $active_class ?>" id="top-<?php echo $count; ?>-tab"
            role="tabpanel" aria-labelledby="top-<?php echo $count; ?>-link">
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
                                    $query->the_post();
                                    $product_price = (int)get_post_meta(get_the_ID(), '_product_price', true);
                                ?>
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
                        <div class="product-cat">
                            <a href="#"><?php echo esc_html($category->name); ?></a>
                        </div>
                        <h3 class="product-title"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?>r</a>
                        </h3>
                        <!-- End .product-title -->
                        <div class="product-price">
                            <?php echo number_format($product_price, 0, ',', '.') . ' VNĐ'; ?>
                        </div><!-- End .product-price -->
                    </div><!-- End .product-body -->
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
</div><!-- End .tab-content -->
<?php } else {
        echo '<p>Không có loại sản phẩm nào.</p>';
    }
}

// Hiển thị giỏ hàng
function display_cart()
{ ?>

<a class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
    data-display="static">
    <div class="icon">
        <i class="icon-shopping-cart"></i>
        <span class="cart-count"><?php echo coutnCart() ?></span>
    </div>
    <p>Cart</p>
</a>

<?php if (empty($_SESSION['cart'])) { ?>

<div class="dropdown-menu dropdown-menu-right ">
    <div class="dropdown-cart-products">
        <?php echo "<p>Giỏ hàng trống.</p>"; ?>
    </div><!-- End .dropdown-cart-total -->
</div><!-- End .dropdown-menu -->
<?php } else { ?>
<div class="dropdown-menu dropdown-menu-right ">
    <div class="dropdown-cart-products">
        <?php $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $product_info) {
                    $product = get_post($product_id);
                    if ($product) {
                        // Hiển thị thông tin size và color
                        if (isset($product_info['options'])) {
                            foreach ($product_info['options'] as $size => $colors) {
                                foreach ($colors as $color => $quantity) {
                                    $data = 'data-product-id = "' . $product_id . '"'; //data cho button delete
                                    $product_price = (int)get_post_meta($product_id, '_product_price', true);
                                    $product_colors = get_post_meta($product_id, '_product_colors', true);
                                    $discount = get_post_meta($product_id, '_product_discount', true);
                                    $discount_price = $product_price * (int)$discount / 100;
                                    $product_size = get_term($size, 'size');
                                    $total += ($product_price - $discount_price)  * $quantity;
                ?>
        <div class="product">
            <div class="product-cart-details">
                <h4 class="product-title">
                    <span class="cart-product-qty"><?php echo $quantity ?> x </span> <a
                        href="<?php echo get_permalink($product_id) ?> "><?php echo $product->post_title ?></a>
                </h4>
                <span class="cart-product-info">
                    <?php if (!empty($discount)) { ?>
                    <span class="old-price">
                        <?php echo number_format($product_price, 0, '.', ','); ?> VND
                    </span>
                    <span class="new-price">
                        <?php echo number_format($product_price - ($product_price * $discount / 100), 0, '.', ','); ?>
                        VND
                    </span>
                    <?php } else { ?>
                    <span>
                        <?php echo number_format($product_price, 0, '.', ','); ?> VND
                    </span>
                    <?php } ?>
                </span><br>
                <?php if (isset($product_colors[$color])) {
                                                $data = $data . 'data-color="' . $color . '"'; //lấy data color nếu có
                                                $image_id = $product_colors[$color]; // Lấy ID ảnh của màu
                                                $image_url = wp_get_attachment_url($image_id); // Lấy URL của ảnh
                                            ?>
                <span class="cart-product-info">Color: <?php echo $color ?></span> <br>
                <?php } else {
                                                $image_url = get_the_post_thumbnail_url($product_id, 'full'); //không có màu lấy ảnh thumbnail
                                            } ?>

                <?php if (isset($product_size->name)) {
                                                $data = $data . 'data-size="' . $size . '"'; ?>

                <span class="cart-product-info">Size: <?php echo $product_size->name ?></span>
                <?php } ?>
            </div><!-- End .product-cart-details -->

            <figure class="product-image-container">
                <a href="<?php echo get_permalink($product_id) ?> " class="product-image">
                    <img src="<?php echo $image_url ?>" alt="product">
                </a>
            </figure>
            <button href="#" id="remove-from-cart-btn" class=" btn-remove" <?php echo $data; ?> title="Remove Product">
                <i class="icon-close"></i></button>
        </div>
        <?php
                                }
                            }
                        }
                    } else {
                        unset($_SESSION['cart'][$product_id]);
                    }
                } ?>
    </div><!-- End .cart-product -->

    <div class="dropdown-cart-total">
        <span>Total</span>

        <span class="cart-total-price"><?php echo  number_format($total, 0, ',', '.') ?> VND</span>
    </div><!-- End .dropdown-cart-total -->

    <div class="dropdown-cart-action">
        <?php
                $page_cart = get_page_by_path('gio-hang');
                if ($page_cart) {
                    $page_cart_url = get_permalink($page_cart->ID);
                } else {
                    $page_cart_url = "";
                } ?>
        <a href="<?php echo $page_cart_url; ?>" class="btn btn-primary">View Cart</a>
        <?php
                $page_checkout = get_page_by_path('thanh-toan');
                if ($page_checkout) {
                    $page_checkout_url = get_permalink($page_checkout->ID);
                } else {
                    $page_checkout_url = "";
                } ?>
        <a href="<?php echo $page_checkout_url ?>" class="btn btn-outline-primary-2"><span>Checkout</span><i
                class="icon-long-arrow-right"></i></a>
    </div><!-- End .dropdown-cart-total -->
</div><!-- End .dropdown-menu -->
<?php }
}

function coutnCart()
{
    if (empty($_SESSION['cart'])) {
        return 0;
    } else {
        $totalcount = 0;
        foreach ($_SESSION['cart'] as $product_id => $product_info) {
            if (isset($product_info['options'])) {
                foreach ($product_info['options'] as $size => $colors) {
                    foreach ($colors as $color => $quantity) {
                        $totalcount++;
                    }
                }
            }
        }
        return $totalcount;
    }
}
function custom_user_profile_url($rules)
{
    $new_rules = array(
        'profile/([^/]+)/?$' => 'index.php?page_id=307&user=$matches[1]',
    );

    return $new_rules + $rules;
}
add_filter('rewrite_rules_array', 'custom_user_profile_url');
function is_recent_product($post_id)
{
    $post_date = get_the_date('Y-m-d', $post_id); // Lấy ngày đăng của sản phẩm
    $current_date = date('Y-m-d'); // Ngày hiện tại
    $date_diff = (strtotime($current_date) - strtotime($post_date)) / (60 * 60 * 24); // Tính số ngày chênh lệch

    return $date_diff <= 7; // Trả về true nếu chênh lệch <= 7 ngày
}
function sc_display_user_orders()
{
    global $wpdb;
    $user_id = get_current_user_id();  // Lấy ID của người dùng hiện tại

    if (!$user_id) {
        echo 'Bạn cần đăng nhập để xem đơn hàng của mình.';
        return;
    }

    // Lấy tất cả đơn hàng của người dùng
    $orders = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}orders WHERE customer_email = %s ORDER BY created_at DESC",
        wp_get_current_user()->user_email
    ));

    if ($orders) {
        echo '<h2>Danh sách đơn hàng của bạn</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>
                <th>ID Đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hủy đơn hàng</th>
              </tr></thead><tbody>';

        foreach ($orders as $order) {
            echo '<tr>
                    <td>' . $order->id . '</td>
                    <td>' . esc_html($order->customer_name) . '</td>
                    <td>' . number_format($order->total_amount, 2) . ' VND</td>
                    <td>' . esc_html($order->status) . '</td>
                    <td>' . esc_html($order->created_at) . '</td>
                    <td>';

            if ($order->status === 'pending') {
                echo '<form method="post" action="">
                        <input type="hidden" name="cancel_order" value="' . $order->id . '">
                        <input type="submit" value="Hủy đơn hàng" class="button">
                      </form>';
            } else {
                echo 'Không thể hủy';
            }

            echo '</td>
                </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo 'Bạn chưa có đơn hàng nào.';
    }
}
function sc_handle_order_cancellation()
{
    if (isset($_POST['cancel_order']) && is_user_logged_in()) {
        global $wpdb;

        $order_id = intval($_POST['cancel_order']);
        $user_email = wp_get_current_user()->user_email;

        // Kiểm tra xem đơn hàng có thuộc về người dùng không
        $order = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}orders WHERE id = %d AND customer_email = %s",
            $order_id,
            $user_email
        ));

        if ($order && $order->status === 'pending') {
            // Cập nhật trạng thái đơn hàng thành đã hủy
            $wpdb->update(
                "{$wpdb->prefix}orders",
                array('status' => 'cancelled'), // Cập nhật trạng thái
                array('id' => $order_id),
                array('%s'),
                array('%d')
            );

            // Thông báo hủy thành công
            echo '<div class="updated"><p>Đơn hàng đã được hủy thành công.</p></div>';
        } else {
            // Thông báo nếu đơn hàng không hợp lệ hoặc đã bị hủy
            echo '<div class="error"><p>Không thể hủy đơn hàng này.</p></div>';
        }
    }
}
add_action('wp', 'sc_handle_order_cancellation');