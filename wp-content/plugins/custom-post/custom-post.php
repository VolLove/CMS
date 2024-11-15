<?php

/**
 * Plugin Name:  Custom Post
 * Description: Plugin để tạo Custom Post cho sản phẩm.
 * Version: 1.0
 * Author:  Nhóm 6
 */

function enqueue_admin_custom_styles()
{
    wp_enqueue_style(
        'admin-custom-styles', // Tên handle của stylesheet
        get_template_directory_uri() . '/bootstrap.min.css', // Đường dẫn tới file CSS
        array(), // Các stylesheets phụ thuộc (nếu có)
        '1.0.0' // Phiên bản của file CSS
    );
}
add_action('admin_enqueue_scripts', 'enqueue_admin_custom_styles');

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

//Thêm hỗ trợ thumnails
add_theme_support('post-thumbnails');

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
// Thêm trường tùy chỉnh ảnh thumbnail cho category
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

// Lưu dữ liệu ảnh thumbnail cho category
function save_product_category_image_field($term_id)
{
    if (isset($_POST['product_category_thumbnail'])) {
        update_term_meta($term_id, 'product_category_thumbnail', esc_url($_POST['product_category_thumbnail']));
    }
}
add_action('created_product_category', 'save_product_category_image_field');

// Hiển thị trường tùy chỉnh ảnh thumbnail trong trang chỉnh sửa category
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

// Cập nhật dữ liệu ảnh thumbnail khi chỉnh sửa category
function update_product_category_image_field($term_id)
{
    if (isset($_POST['product_category_thumbnail'])) {
        update_term_meta($term_id, 'product_category_thumbnail', esc_url($_POST['product_category_thumbnail']));
    }
}
add_action('edited_product_category', 'update_product_category_image_field');

// Giá sản phẩm
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

// Thêm trường giá
function display_product_price_meta_box($post)
{
    $product_price = get_post_meta($post->ID, '_product_price', true);
?>
<label for="product_price">Giá (VNĐ):</label>
<input type="number" id="product_price" name="product_price" value="<?php echo esc_attr($product_price); ?>"
    style="width: 100%;" />
<?php
}

//Lưu giá
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
        'product',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_discount_meta_box');

//Trường giảm giá
function display_discount_meta_box($post)
{
    $discount = get_post_meta($post->ID, '_product_discount', true);
    echo '<label for="product_discount">Giảm giá (%):</label>';
    echo '<input type="number" name="product_discount" value="' . esc_attr($discount) . '" min="0" max="100" step="1">';
}
//Lưu giảm giá
function save_product_discount($post_id)
{
    if (isset($_POST['product_discount'])) {
        update_post_meta($post_id, '_product_discount', sanitize_text_field($_POST['product_discount']));
    }
}
add_action('save_post', 'save_product_discount');
// Thêm meta box cho nhiều ảnh sản phẩm
function add_product_images_meta_box()
{
    add_meta_box(
        'product_images_meta_box',
        'Ảnh sản phẩm',
        'display_product_images_meta_box',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_product_images_meta_box');

// Hàm hiển thị meta box
function display_product_images_meta_box($post)
{
    // Lấy danh sách ảnh hiện tại
    $product_images = get_post_meta($post->ID, '_product_images', true);
?>

<div id="product-images-wrapper">
    <ul id="product-images-list">
        <?php
            if (!empty($product_images)) {
                foreach ($product_images as $image) {
                    echo '<li><img src="' . esc_url($image) . '" width="100" />';
                    echo '<input type="hidden" name="product_images[]" value="' . esc_url($image) . '">';
                    echo '<button type="button" class="remove-image-button">Xóa</button></li>'; ?>
        <?php }
            }
            ?>
    </ul>
    <button type="button" id="add-product-image-button">Thêm ảnh</button>
</div>

<script>
jQuery(document).ready(function($) {
    $('#add-product-image-button').click(function() {
        var frame = wp.media({
            title: 'Chọn ảnh sản phẩm',
            multiple: true,
            button: {
                text: 'Thêm ảnh'
            }
        });

        frame.on('select', function() {
            var images = frame.state().get('selection').toJSON();
            images.forEach(function(image) {
                $('#product-images-list').append(
                    '<li><img src="' + image.url + '" width="100" />' +
                    '<input type="hidden" name="product_images[]" value="' + image
                    .url + '">' +
                    '<button type="button" class="remove-image-button">Xóa</button></li>'
                );
            });
        });

        frame.open();
    });

    $('#product-images-list').on('click', '.remove-image-button', function() {
        $(this).closest('li').remove();
    });
});
</script>

<?php
}

// Lưu danh sách ảnh sản phẩm
function save_product_images($post_id)
{
    if (isset($_POST['product_images'])) {
        update_post_meta($post_id, '_product_images', array_map('esc_url', $_POST['product_images']));
    } else {
        delete_post_meta($post_id, '_product_images');
    }
}
add_action('save_post', 'save_product_images');

// Thêm meta box cho màu sản phẩm
function add_product_colors_meta_box()
{
    add_meta_box(
        'product_colors_meta_box',
        'Màu và Ảnh Sản Phẩm',
        'display_product_colors_meta_box',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_product_colors_meta_box');

// Hiển thị meta box
function display_product_colors_meta_box($post)
{
    $product_colors = get_post_meta($post->ID, '_product_colors', true);

    wp_nonce_field(basename(__FILE__), 'product_colors_nonce'); ?>

<table id="product-colors-table" style="width:100%;">
    <tr>
        <th>Màu</th>
        <th>Ảnh</th>
        <th>Hành động</th>
    </tr>

    <?php if (!empty($product_colors)) {
            foreach ($product_colors as $color => $image_id) {
                $image_url = wp_get_attachment_url($image_id);
                echo '<tr>';
                echo '<td><input type="text" name="product_colors[]" value="' . esc_attr($color) . '"></td>';
                echo '<td>
                    <input type="hidden" name="product_color_images[]" value="' . esc_attr($image_id) . '">
                    <img src="' . esc_url($image_url) . '" style="width: 60px; height: 60px;" class="color-image-preview"/>
                    <button type="button" class="select-color-image">Chọn ảnh</button>
                    </td>';
                echo '<td><button type="button" class="remove-color">Xóa</button></td>';
                echo '</tr>';
            }
        }
        ?>
</table>
<button type="button" id="add-product-color">Thêm màu</button>
<script>
jQuery(document).ready(function($) {
    // Xử lý khi nhấn "Thêm màu"
    $('#add-product-color').on('click', function(e) {
        e.preventDefault();

        // Tạo một hàng mới
        const newRow = `
            <tr>
                <td><input type="text" name="product_colors[]" placeholder="Nhập màu"></td>
                <td>
                    <input type="hidden" name="product_color_images[]" value="">
                    <img src="" style="width: 60px; height: 60px; display: none;" class="color-image-preview"/>
                    <button type="button" class="select-color-image">Chọn ảnh</button>
                </td>
                <td><button type="button" class="remove-color">Xóa</button></td>
            </tr>`;

        // Thêm hàng vào bảng
        $('#product-colors-table').append(newRow);
    });

    // Xử lý chọn ảnh từ thư viện phương tiện WordPress
    $(document).on('click', '.select-color-image', function(e) {
        e.preventDefault();
        const button = $(this);
        const imageInput = button.siblings('input[type="hidden"]');
        const imagePreview = button.siblings('.color-image-preview');

        // Mở thư viện phương tiện
        const customUploader = wp.media({
            title: 'Chọn ảnh cho màu',
            button: {
                text: 'Chọn ảnh'
            },
            multiple: false
        }).on('select', function() {
            const attachment = customUploader.state().get('selection').first().toJSON();
            imageInput.val(attachment.id); // Lưu ID ảnh vào input ẩn
            imagePreview.attr('src', attachment.url).show(); // Hiển thị ảnh đã chọn
        }).open();
    });

    // Xử lý xóa hàng màu
    $(document).on('click', '.remove-color', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });
});
</script>
<?php  }
// Lưu meta box khi lưu sản phẩm
function save_product_colors_meta($post_id)
{
    if (!isset($_POST['product_colors_nonce']) || !wp_verify_nonce($_POST['product_colors_nonce'], basename(__FILE__))) {
        return;
    }

    $colors = isset($_POST['product_colors']) ? array_map('sanitize_text_field', $_POST['product_colors']) : [];
    $images = isset($_POST['product_color_images']) ? array_map('sanitize_text_field', $_POST['product_color_images']) : [];

    $product_colors = array_combine($colors, $images);
    update_post_meta($post_id, '_product_colors', $product_colors);
}
add_action('save_post', 'save_product_colors_meta');

//Kích thước sản phẩm
function create_size_taxonomy()
{
    $labels = array(
        'name' => 'Size',
        'singular_name' => 'Size',
        'search_items' => 'Tìm kiếm size',
        'all_items' => 'Tất cả size',
        'edit_item' => 'Chỉnh sửa size',
        'update_item' => 'Cập nhật size',
        'add_new_item' => 'Thêm size mới',
        'new_item_name' => 'Tên size mới',
        'menu_name' => 'Size',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'size'),
    );
    register_taxonomy('size', 'product', $args);
}
add_action('init', 'create_size_taxonomy');
//Giỏ hàng
// Khởi tạo session để lưu giỏ hàng

function sc_start_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'sc_start_session');

/// Thêm sản phẩm vào giỏ hàng
function sc_add_to_cart()
{
    // Lấy ID sản phẩm, số lượng, size và màu từ yêu cầu AJAX
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $size = isset($_POST['size']) ? intval($_POST['size']) : '';;
    $color = isset($_POST['color']) ? sanitize_text_field($_POST['color']) : '';;
    //Kiểm tra sản phẩm, size, màu có tồn tại hay không
    $product = get_post($product_id);
    $product_colors = get_post_meta($product_id, '_product_colors', true);
    $product_size = get_term($size, 'size');
    $product_sizes = wp_get_post_terms($product_id, 'size');
    if (!empty($product_sizes)) {
        if (!isset($product_size->name)) {
            wp_send_json_error(['message' => 'Chưa chọn khích thước!.']);
        }
    }
    if (!empty($product_colors)) {
        if (!isset($product_colors[$color])) {
            wp_send_json_error(['message' => 'Chưa chọn màu!.']);
        }
    }
    if (!empty($product)) {
        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        if (isset($_SESSION['cart'][$product_id])) {
            // Kiểm tra xem sản phẩm đã có với size và color này chưa
            if (isset($_SESSION['cart'][$product_id]['options'][$size][$color])) {
                $_SESSION['cart'][$product_id]['options'][$size][$color] += $quantity;
            } else {
                $_SESSION['cart'][$product_id]['options'][$size][$color] = $quantity;
            }
        } else {
            // Nếu chưa có sản phẩm trong giỏ hàng, thêm mới
            $_SESSION['cart'][$product_id] = [
                'quantity' => $quantity,
                'options' => [
                    $size => [
                        $color => $quantity
                    ]
                ]
            ];
        }

        wp_send_json_success();
    } else {
        wp_send_json_error(['message' => 'Sản phẩm không tồn tại.']);
    }
}
add_action('wp_ajax_sc_add_to_cart', 'sc_add_to_cart');
add_action('wp_ajax_nopriv_sc_add_to_cart', 'sc_add_to_cart');

// Xử lý xóa sản phẩm khỏi giỏ hàng
// Xóa sản phẩm khỏi giỏ hàng
function sc_remove_from_cart()
{
    // Lấy ID sản phẩm, size, và color từ yêu cầu AJAX
    // unset($_SESSION['cart']);

    $product_id = intval($_POST['product_id']);
    $size = isset($_POST['size']) ? intval($_POST['size']) : '';
    $color = isset($_POST['color']) ? sanitize_text_field($_POST['color']) : '';
    // Kiểm tra nếu giỏ hàng đã được khởi tạo
    if (isset($_SESSION['cart'][$product_id])) {
        // Xóa sản phẩm có size và color cụ thể
        if (isset($_SESSION['cart'][$product_id]['options'][$size][$color])) {
            unset($_SESSION['cart'][$product_id]['options'][$size][$color]);

            // Nếu không còn size/color nào, xóa sản phẩm hoàn toàn khỏi giỏ hàng
            if (empty($_SESSION['cart'][$product_id]['options'][$size])) {
                unset($_SESSION['cart'][$product_id]['options'][$size]);
            }

            if (empty($_SESSION['cart'][$product_id]['options'])) {
                unset($_SESSION['cart'][$product_id]);
            }

            wp_send_json_success();
        }
    }
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
    display_cart(); // Gọi hàm hiển thị giỏ hàng
    $cart_html = ob_get_clean();

    wp_send_json_success(['cart_html' => $cart_html]);
}
add_action('wp_ajax_sc_get_cart_content', 'sc_get_cart_content');
add_action('wp_ajax_nopriv_sc_get_cart_content', 'sc_get_cart_content');

function sc_get_page_cart_content()
{
    ob_start();
    cart_content(); // Gọi hàm hiển thị giỏ hàng
    $cart_html = ob_get_clean();

    wp_send_json_success(['cart_html' => $cart_html]);
}
add_action('wp_ajax_sc_get_page_cart_content', 'sc_get_page_cart_content');
add_action('wp_ajax_nopriv_sc_get_page_cart_content', 'sc_get_page_cart_content');

// Load JavaScript cho Ajax
function sc_cart_scripts()
{
    wp_enqueue_script('custom-cart-js', plugins_url('/custom-cart.js', __FILE__), ['jquery'], null, true);
    wp_localize_script('custom-cart-js', 'sc_vars', ['ajax_url' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'sc_cart_scripts'); // Shortcode để hiển thị giỏ hàng