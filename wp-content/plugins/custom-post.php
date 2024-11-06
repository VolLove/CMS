<?php

/**
 * Plugin Name:  Custom Post
 * Description: Plugin để tạo Custom Post cho sản phẩm.
 * Version: 1.0
 * Author:  Nhóm 6
 */
// Hàm đăng ký Custom Post
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
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
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
