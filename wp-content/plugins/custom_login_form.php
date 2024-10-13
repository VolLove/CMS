<?php
/*
Plugin Name: Custom Login Form
Description: Thay đổi form login
Version: 1.0
Author: Nhóm 6
*/


//Thêm trường mã bảo mật vào form
function custom_login_security_code_field()
{
?>
<p>
    <label for="security_code">Mã bảo mật<br />
        <input type="text" name="security_code" id="security_code" class="input" size="20" /></label>
</p>
<?php
}
add_action('login_form', 'custom_login_security_code_field');

// Kiểm tra mã bảo mật khi người dùng đăng nhập
function custom_login_security_code_check($user, $password)
{
    if (isset($_POST['security_code'])) {
        $security_code = $_POST['security_code'];

        // Kiểm tra mã bảo mật (ví dụ: mã phải là '1234')
        if ($security_code !== '1234') {
            return new WP_Error('security_code_error', 'Sai mã bảo mật!');
        }
    }

    return $user;
}
add_filter('authenticate', 'custom_login_security_code_check', 30, 2);

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