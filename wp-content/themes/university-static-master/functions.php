<?php
// Thêm hỗ trợ cho menu
function theme_setup()
{
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'theme')
    ));
}
add_action('after_setup_theme', 'theme_setup');

function my_custom_theme_enqueue_styles()
{
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');

    wp_enqueue_style('responsive', get_stylesheet_directory_uri() . '/css/responsive.css', array('style'));
}

add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_styles');

function theme_enqueue_scripts()
{
    wp_enqueue_script(
        'custom-script',
        get_template_directory_uri() . '/js/script.js',
        array(),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
function custom_document_title($title)
{
    return '<strong>' . $title . '</strong>';
}
add_filter('document_title', 'custom_document_title');

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
// add_action('login_form', 'custom_login_security_code_field');

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
// add_filter('authenticate', 'custom_login_security_code_check', 30, 2);