<?php
/*
Plugin Name: Custom Login Form
Description: Thay đổi form login
Version: 1.0
Author: Nhóm 6
*/

// Thay đổi URL trang login
function redirect_to_custom_login()
{
    $login_page = home_url('/login/'); // Đường dẫn đến trang login mà bạn vừa tạo
    $page_viewed = basename($_SERVER['REQUEST_URI']);

    if ($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
}
add_action('init', 'redirect_to_custom_login');

// Điều hướng login
function custom_login_redirect($redirect_to, $request, $user)
{
    // Kiểm tra xem người dùng có vai trò là 'administrator' không
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return admin_url(); // Chuyển hướng quản trị viên đến bảng điều khiển
        } else {
            return home_url(); // Chuyển hướng người dùng thông thường đến trang chủ
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

// Thay đổi URL sau khi đăng xuất
function custom_logout_redirect()
{
    wp_redirect(home_url('/login/')); // URL của trang login tùy chỉnh
    exit();
}
add_action('wp_logout', 'custom_logout_redirect');
