<?php

/**
 * Plugin Name:  Custom Post
 * Description: Plugin để tạo Custom Post cho sản phẩm.
 * Version: 1.0
 * Author:  Nhóm 6
 */

//  PRODUCT
// Hàm đăng ký Product
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
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-cart',
    );

    register_post_type('product', $args);
}

add_action('init', 'create_product_post_type');
add_theme_support('post-thumbnails');

// Tạo meta box để nhập giá sản phẩm
function add_product_price_meta_box()
{
    add_meta_box(
        'product_price_meta_box',       // ID của meta box
        'Giá sản phẩm',                 // Tiêu đề của meta box
        'display_product_price_meta_box', // Hàm callback hiển thị meta box
        'product',                      // CPT áp dụng
        'normal',                       // Vị trí
        'high'                          // Độ ưu tiên
    );
}
add_action('add_meta_boxes', 'add_product_price_meta_box');

// Hàm hiển thị nội dung của meta box
function display_product_price_meta_box($post)
{
    $product_price = get_post_meta($post->ID, '_product_price', true);
?>
<label for="product_price">Giá (VNĐ):</label>
<input type="number" id="product_price" name="product_price" value="<?php echo esc_attr($product_price); ?>"
    style="width: 100%;" />
<?php
}

// Lưu giá trị của meta box khi lưu bài viết
function save_product_price_meta_box($post_id)
{
    if (array_key_exists('product_price', $_POST)) {
        update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
    }
}
add_action('save_post', 'save_product_price_meta_box');

//Giảm giá sản phẩm
function add_discount_meta_box()
{
    add_meta_box(
        'product_discount',
        'Giảm Giá Sản Phẩm',
        'display_discount_meta_box',
        'product', // Thay 'product' bằng post type sản phẩm của bạn
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_discount_meta_box');

function display_discount_meta_box($post)
{
    $discount = get_post_meta($post->ID, '_product_discount', true);
    echo '<label for="product_discount">Giảm giá (%):</label>';
    echo '<input type="number" name="product_discount" value="' . esc_attr($discount) . '" min="0" max="100" step="1">';
}

function save_product_discount($post_id)
{
    if (isset($_POST['product_discount'])) {
        update_post_meta($post_id, '_product_discount', sanitize_text_field($_POST['product_discount']));
    }
}
add_action('save_post', 'save_product_discount');

//Loại sản phẩm
function create_product_taxonomy()
{
    $labels = array(
        'name' => 'Loại sản phẩm',
        'singular_name' => 'Loại sản phẩm',
        'search_items' => 'Tìm kiếm loại sản phẩm',
        'all_items' => 'Tất cả loại sản phẩm',
        'edit_item' => 'Chỉnh sửa loại sản phẩm',
        'update_item' => 'Cập nhật loại sản phẩm',
        'add_new_item' => 'Thêm loại sản phẩm mới',
        'new_item_name' => 'Tên loại sản phẩm mới',
        'menu_name' => 'Loại sản phẩm',
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'loai-san-pham'),
    );

    register_taxonomy('product_category', 'product', $args);
}
add_action('init', 'create_product_taxonomy');
// Thêm trường tùy chỉnh ảnh thumbnail cho taxonomy
function add_product_category_image_field()
{
?>
<div class="form-field">
    <label for="product_category_thumbnail"><?php _e('Ảnh thumbnail', 'text-domain'); ?></label>
    <input type="text" name="product_category_thumbnail" id="product_category_thumbnail" value="" style="width: 80%;" />
    <button class="upload_image_button button"><?php _e('Tải ảnh lên', 'text-domain'); ?></button>
    <p class="description"><?php _e('Chọn ảnh thumbnail cho loại sản phẩm.', 'text-domain'); ?></p>
</div>
<?php
}
add_action('product_category_add_form_fields', 'add_product_category_image_field');

// Lưu dữ liệu ảnh thumbnail cho taxonomy
function save_product_category_image_field($term_id)
{
    if (isset($_POST['product_category_thumbnail'])) {
        update_term_meta($term_id, 'product_category_thumbnail', esc_url($_POST['product_category_thumbnail']));
    }
}
add_action('created_product_category', 'save_product_category_image_field');

// Hiển thị trường tùy chỉnh ảnh thumbnail trong trang chỉnh sửa taxonomy
function edit_product_category_image_field($term)
{
    $thumbnail = get_term_meta($term->term_id, 'product_category_thumbnail', true);
?>
<tr class="form-field">
    <th scope="row" valign="top"><label
            for="product_category_thumbnail"><?php _e('Ảnh thumbnail', 'text-domain'); ?></label></th>
    <td>
        <input type="text" name="product_category_thumbnail" id="product_category_thumbnail"
            value="<?php echo esc_attr($thumbnail); ?>" style="width: 80%;" />
        <button class="upload_image_button button"><?php _e('Tải ảnh lên', 'text-domain'); ?></button>
        <p class="description"><?php _e('Chọn ảnh thumbnail cho loại sản phẩm.', 'text-domain'); ?></p>
    </td>
</tr>
<?php
}
add_action('product_category_edit_form_fields', 'edit_product_category_image_field');

// Cập nhật dữ liệu ảnh thumbnail khi chỉnh sửa taxonomy
function update_product_category_image_field($term_id)
{
    if (isset($_POST['product_category_thumbnail'])) {
        update_term_meta($term_id, 'product_category_thumbnail', esc_url($_POST['product_category_thumbnail']));
    }
}
add_action('edited_product_category', 'update_product_category_image_field');
//Giỏ hàng
// Khởi tạo session để lưu giỏ hàng
function sc_start_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'sc_start_session');

// Thêm sản phẩm vào giỏ hàng
function sc_add_to_cart()
{
    // Lấy ID sản phẩm và số lượng từ yêu cầu AJAX
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    wp_send_json_success();
}
add_action('wp_ajax_sc_add_to_cart', 'sc_add_to_cart');
add_action('wp_ajax_nopriv_sc_add_to_cart', 'sc_add_to_cart');

// Xử lý xóa sản phẩm khỏi giỏ hàng
function sc_remove_from_cart()
{
    $product_id = intval($_POST['product_id']);
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    wp_send_json_success();
}
add_action('wp_ajax_sc_remove_from_cart', 'sc_remove_from_cart');
add_action('wp_ajax_nopriv_sc_remove_from_cart', 'sc_remove_from_cart');
// Xóa toàn bộ giỏ hàng
function sc_clear_cart()
{
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']); // Xóa giỏ hàng khỏi session
    }
    wp_send_json_success();
}
add_action('wp_ajax_sc_clear_cart', 'sc_clear_cart');
add_action('wp_ajax_nopriv_sc_clear_cart', 'sc_clear_cart');

// Hàm để lấy lại HTML của giỏ hàng
function sc_get_cart_content()
{
    ob_start();
    sc_display_cart(); // Gọi hàm hiển thị giỏ hàng
    $cart_html = ob_get_clean();

    wp_send_json_success(['cart_html' => $cart_html]);
}
add_action('wp_ajax_sc_get_cart_content', 'sc_get_cart_content');
add_action('wp_ajax_nopriv_sc_get_cart_content', 'sc_get_cart_content');

// Load JavaScript cho Ajax
function sc_cart_scripts()
{
    wp_enqueue_script('custom-cart-js', plugins_url('/custom-cart.js', __FILE__), ['jquery'], null, true);
    wp_localize_script('custom-cart-js', 'sc_vars', ['ajax_url' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'sc_cart_scripts'); // Shortcode để hiển thị giỏ hàng


//ĐƠN HÀNG
//Tạo bảng đơn hàng
function create_orders_table()
{
    global $wpdb;
    $table_name =  $wpdb->prefix . 'orders';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) UNSIGNED NOT NULL,
        customer_name text NOT NULL,
        customer_address text NOT NULL,
        customer_phone varchar(20) NOT NULL,
        customer_email varchar(100) NOT NULL,
        order_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        products longtext NOT NULL,
        status varchar(20) DEFAULT 'pending' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_orders_table');
//Thêm thông tin liên hệ
// Thêm trường điện thoại và địa chỉ vào hồ sơ người dùng
function add_custom_user_profile_fields($user)
{
?>
<h3>Thông tin liên hệ</h3>
<table class="form-table">
    <tr>
        <th><label for="phone">Số điện thoại</label></th>
        <td>
            <input type="text" name="phone" id="phone"
                value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" /><br>
            <span class="description">Nhập số điện thoại của bạn.</span>
        </td>
    </tr>
    <tr>
        <th><label for="address">Địa chỉ</label></th>
        <td>
            <textarea name="address" id="address" rows="5"
                class="regular-text"><?php echo esc_textarea(get_user_meta($user->ID, 'address', true)); ?></textarea><br>
            <span class="description">Nhập địa chỉ của bạn.</span>
        </td>
    </tr>
</table>
<?php
}
add_action('show_user_profile', 'add_custom_user_profile_fields');
add_action('edit_user_profile', 'add_custom_user_profile_fields');

// Lưu số điện thoại và địa chỉ vào cơ sở dữ liệu khi cập nhật hồ sơ
function save_custom_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    update_user_meta($user_id, 'address', sanitize_textarea_field($_POST['address']));
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

//Đăng ký menu đơn hàng
function register_orders_menu()
{
    add_menu_page(
        'Quản lý hóa đơn',
        'Hóa đơn',
        'manage_options',
        'manage_orders',
        'display_orders_list',
        'dashicons-list-view',
        6
    );

    // Đăng ký submenu cho chi tiết hóa đơn
    add_submenu_page(
        null, // Ẩn submenu khỏi menu chính
        'Chi tiết hóa đơn',
        'Chi tiết hóa đơn',
        'manage_options',
        'manage_order',
        'display_order_details'
    );
}
add_action('admin_menu', 'register_orders_menu');

// Hiển thị danh sách hóa đơn
function display_orders_list()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'orders';

    $orders = $wpdb->get_results("SELECT * FROM $table_name ORDER BY order_date DESC");

    echo '<div class="wrap"><h1>Quản lý hóa đơn</h1>';


    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>Hóa đơn</th><th>Ngày</th><th>Khách hàng</th><th>Tổng giá trị</th><th>Trạng thái</th><th>Chi tiết</th></tr></thead><tbody>';

    foreach ($orders as $order) {
        $products = maybe_unserialize($order->products);
        $total_price = 0;

        foreach ($products as $product_id => $quantity) {
            $price = (int)get_post_meta($product_id, '_product_price', true);
            $total_price += $price * $quantity;
        }

        echo '<tr>';
        echo '<td>' . esc_html($order->id) . '</td>';
        echo '<td>' . esc_html($order->order_date) . '</td>';
        echo '<td>' . esc_html($order->customer_name) . '</td>';
        echo '<td>' . esc_html(number_format($total_price, 0, ',', '.')) . ' VND</td>';
        echo '<td>' . esc_html($order->status) . '</td>';
        echo '<td><a href="' . admin_url('admin.php?page=manage_order&order_id=' . $order->id) . '">Xem</a></td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
}

// Hiển thị chi tiết hóa đơn
function display_order_details()
{
    if (!isset($_GET['order_id'])) {
        echo '<p>Không tìm thấy hóa đơn.</p>';
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'orders';
    $order_id = intval($_GET['order_id']);
    $order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $order_id));

    if (!$order) {
        echo '<p>Không tìm thấy hóa đơn.</p>';
        return;
    }

    if (isset($_POST['order_status']) && check_admin_referer('update_order_status_' . $order_id)) {
        $status = sanitize_text_field($_POST['order_status']);
        $wpdb->update($table_name, ['status' => $status], ['id' => $order_id]);
        $order->status = $status;
        echo '<div class="updated"><p>Đã cập nhật trạng thái đơn hàng.</p></div>';
    }

    echo '<div class="wrap"><h1>Chi tiết hóa đơn #' . esc_html($order->id) . '</h1>';
    echo '<p><strong>Ngày:</strong> ' . esc_html($order->order_date) . '</p>';
    echo '<p><strong>Khách hàng:</strong> ' . esc_html($order->customer_name) . '</p>';
    echo '<p><strong>Địa chỉ:</strong> ' . esc_html($order->customer_address) . '</p>';
    echo '<p><strong>Điện thoại:</strong> ' . esc_html($order->customer_phone) . '</p>';
    echo '<p><strong>Email:</strong> ' . esc_html($order->customer_email) . '</p>';

    $products = maybe_unserialize($order->products);
    $total_price = 0;

    echo '<h3>Sản phẩm</h3><table class="wp-list-table widefat fixed striped">';
    echo '<tr><th>Sản phẩm</th><th>Số lượng</th><th>Giá</th><th>Tổng</th></tr>';

    foreach ($products as $product_id => $quantity) {
        $product_name = get_the_title($product_id);
        $price = (int)get_post_meta($product_id, '_product_price', true);
        $total = $price * $quantity;
        $total_price += $total;

        echo '<tr>';
        echo '<td>' . esc_html($product_name) . '</td>';
        echo '<td>' . esc_html($quantity) . '</td>';
        echo '<td>' . esc_html(number_format($price, 0, ',', '.')) . ' VND</td>';
        echo '<td>' . esc_html(number_format($total, 0, ',', '.')) . ' VND</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<p><strong>Tổng cộng:</strong> ' . esc_html(number_format($total_price, 0, ',', '.')) . ' VND</p>';

    echo '<h3>Cập nhật trạng thái</h3>';
    echo '<form method="post">';
    wp_nonce_field('update_order_status_' . $order_id);
    echo '<select name="order_status">';
    echo '<option value="pending"' . selected($order->status, 'pending', false) . '>Đang xử lý</option>';
    echo '<option value="completed"' . selected($order->status, 'completed', false) . '>Đã thanh toán</option>';
    echo '<option value="canceled"' . selected($order->status, 'canceled', false) . '>Đã hủy</option>';
    echo '</select>';
    echo '<input type="submit" value="Cập nhật" class="button button-primary">';
    echo '</form>';
    echo '</div>';
}
// Shortcode hiển thị form thanh toán
function checkout_page_shortcode()
{
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!is_user_logged_in()) {
        return '<p>Vui lòng <a href="' . wp_login_url(get_permalink()) . '">đăng nhập</a> để tiếp tục.</p>';
    }
    $products = $_SESSION['cart'];
    if (empty($products)) {
        echo '<p>Giỏ hàng của bạn đang trống.</p>';
        return;
    }
    // Lấy thông tin người dùng hiện tại
    $current_user = wp_get_current_user();
    $user_name = $current_user->display_name;
    $user_email = $current_user->user_email;
    $user_phone = get_user_meta($current_user->ID, 'phone', true);
    $user_address = get_user_meta($current_user->ID, 'address', true);
    ob_start();
?>
<form id="checkout-form" method="POST">
    <div class="row">
        <div class="col-lg-7">
            <h2 class="checkout-title">Thông tin thanh toán</h2>
            <p>
                <label for="customer_name" class="sr-only">Tên khách hàng:</label>
                <input class="form-control" type="text" placeholder="Tên khách hàng" id="customer_name"
                    name="customer_name" required value="<?php echo esc_attr($user_name); ?>">
            </p>
            <p>
                <label for="customer_email" class="sr-only">Email:</label>
                <input id="customer_email" class="form-control" type="email" placeholder="Email" name="customer_email"
                    value="<?php echo esc_attr($user_email); ?>" required>
            </p>
            <p>
                <label for="customer_phone" class="sr-only">Số điện thoại:</label>
                <input id="customer_phone" class="form-control" type="text" placeholder="Số điện thoại"
                    name="customer_phone" value="<?php echo esc_attr($user_phone); ?>" required>
            </p>
            <p>
                <label for="customer_address" class="sr-only">Địa chỉ:</label>
                <textarea class="form-control" placeholder="Địa chỉ" id="customer_address" name="customer_address"
                    required><?php echo esc_textarea($user_address); ?></textarea>
            </p>
        </div>
        <aside class="col-lg-5">
            <div class="summary">
                <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                <table class="table table-summary">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><a href="#">Beige knitted elastic runner shoes</a></td>
                            <td>$84.00</td>
                        </tr>

                        <tr>
                            <td><a href="#">Blue utility pinafore denimdress</a></td>
                            <td>$76,00</td>
                        </tr>
                        <tr class="summary-subtotal">
                            <td>Subtotal:</td>
                            <td>$160.00</td>
                        </tr><!-- End .summary-subtotal -->
                        <tr>
                            <td>Shipping:</td>
                            <td>Free shipping</td>
                        </tr>
                        <tr class="summary-total">
                            <td>Total:</td>
                            <td>$160.00</td>
                        </tr><!-- End .summary-total -->
                    </tbody>
                </table><!-- End .table table-summary -->
                <button type="submit" name="checkout_submit" class="btn btn-outline-primary-2 btn-order btn-block">
                    Xác nhận thanh toán
                </button>
            </div><!-- End .summary -->
        </aside>
    </div>
</form>
<?php
    return ob_get_clean();
}
add_shortcode('checkout_page', 'checkout_page_shortcode');

// Xử lý đơn hàng sau khi form được gửi
function handle_checkout_submission()
{
    if (isset($_POST['checkout_submit'])) {
        global $wpdb;

        // Kiểm tra người dùng đã đăng nhập chưa
        if (!is_user_logged_in()) {
            return;
        }

        // Lấy thông tin từ form
        $customer_name = sanitize_text_field($_POST['customer_name']);
        $customer_email = sanitize_email($_POST['customer_email']);
        $customer_phone = sanitize_text_field($_POST['customer_phone']);
        $customer_address = sanitize_textarea_field($_POST['customer_address']);
        $user_id = get_current_user_id();

        // Kiểm tra giỏ hàng trong session
        $products = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (empty($products)) {
            echo '<p>Giỏ hàng của bạn đang trống.</p>';
            return;
        }

        // Thêm đơn hàng vào bảng 'orders'
        $table_name = $wpdb->prefix . 'orders';
        if ($wpdb->insert($table_name, array(
            'user_id' => $user_id,
            'customer_name' => $customer_name,
            'customer_address' => $customer_address,
            'customer_phone' => $customer_phone,
            'customer_email' => $customer_email,
            'order_date' => current_time('mysql'),
            'products' => maybe_serialize($products),
            'status' => 'pending',
        ))) {
        }

        // Xóa giỏ hàng khỏi session sau khi thanh toán thành công
        unset($_SESSION['cart']);

        // Hiển thị thông báo thành công
        echo '<p>Đơn hàng của bạn đã được đặt thành công. Cảm ơn bạn đã mua hàng!</p>';
    }
}

add_action('wp', 'handle_checkout_submission');