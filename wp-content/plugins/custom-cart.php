<?php
/*
Plugin Name: Custom Cart
Description: Plugin giỏ hàng đơn giản.
Version: 1.0
Author: Your Name
*/

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