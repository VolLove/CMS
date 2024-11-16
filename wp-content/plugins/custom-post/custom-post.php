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
        'supports' => array('title', 'editor', 'thumbnail', 'comments'),
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
    if ($quantity <= 0) {
        $quantity = 1;
    }
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
    } else {
        $size = '';
    }
    if (!empty($product_colors)) {
        if (!isset($product_colors[$color])) {
            wp_send_json_error(['message' => 'Chưa chọn màu!.']);
        }
    } else {
        $color = '';
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

//Cập nhật số lượng
function sc_update_cart_quantity()
{

    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $size = isset($_POST['size']) ? intval($_POST['size']) : '';;
    $color = isset($_POST['color']) ? sanitize_text_field($_POST['color']) : '';;

    if (isset($_SESSION['cart'][$product_id]['options'][$size][$color])) {
        $_SESSION['cart'][$product_id]['options'][$size][$color] = $quantity;
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product_id]['options'][$size][$color]);

            if (empty($_SESSION['cart'][$product_id]['options'][$size])) {
                unset($_SESSION['cart'][$product_id]['options'][$size]);
            }

            if (empty($_SESSION['cart'][$product_id]['options'])) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }
    wp_send_json_success();
}
add_action('wp_ajax_sc_update_cart_quantity', 'sc_update_cart_quantity');
add_action('wp_ajax_nopriv_sc_update_cart_quantity', 'sc_update_cart_quantity');

// ĐƠN HÀNG | HÓA ĐƠN
function register_order_post_type()
{
    $args = [
        'public' => false,
        'show_ui' => true,
        'label' => 'Đơn hàng',
        'supports' => ['title', 'editor', 'custom-fields'],
    ];

    register_post_type('order', $args);
}
add_action('init', 'register_order_post_type');



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
    sc_cart_content();
    $cart_page_html = ob_get_clean();

    wp_send_json_success(['cart_page_html' => $cart_page_html]);
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


function sc_cart_content()
{
    if (empty($_SESSION['cart'])) {
    } else { ?>

        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($_SESSION['cart'] as $product_id => $product_info) {
                                    $product = get_post($product_id);
                                    if ($product) {
                                        if (isset($product_info['options'])) {
                                            foreach ($product_info['options'] as $size => $colors) {
                                                foreach ($colors as $color => $quantity) {
                                                    $data = 'data-product-id = "' . $product_id . '"';
                                                    $product_price = (int)get_post_meta($product_id, '_product_price', true);
                                                    $product_colors = get_post_meta($product_id, '_product_colors', true);
                                                    $discount = (int)get_post_meta($product_id, '_product_discount', true);
                                                    $discount_price = $product_price * $discount / 100;
                                                    $product_size = get_term($size, 'size');
                                                    $total += ($product_price - $discount_price)  * $quantity;
                                                    $image_url = get_the_post_thumbnail_url($product_id, 'full'); //không có màu lấy ảnh thumbnail
                                                    if (isset($product_colors[$color])) {
                                                        $data = $data . 'data-color="' . $color . '"'; //lấy data color nếu có
                                                        $image_id = $product_colors[$color]; // Lấy ID ảnh của màu
                                                        $image_url = wp_get_attachment_url($image_id); // Lấy URL của ảnh
                                                    } ?>
                                                    <tr>
                                                        <td class="product-col">
                                                            <div class="product">
                                                                <figure class="product-media">
                                                                    <a href="#">
                                                                        <img src="<?php echo $image_url ?>" alt="Product image">
                                                                    </a>
                                                                </figure>

                                                                <h3 class="product-title">
                                                                    <a href="<?php echo get_permalink($product_id) ?>"><?php echo $product->post_title ?>
                                                                        <?php if (isset($product_size->name)) {
                                                                            $data = $data . 'data-size="' . $size . '"'; ?>

                                                                            <span class="cart-product-info">| Size:
                                                                                <?php echo $product_size->name ?></span>
                                                                        <?php } ?>
                                                                        <span class="cart-product-info">
                                                                            <?php echo $color ? '| Color: ' . $color : '' ?></span>
                                                                    </a>
                                                                </h3><!-- End .product-title -->
                                                            </div><!-- End .product -->
                                                        </td>
                                                        <td class="price-col">
                                                            <?php if (!empty($discount)) { ?>
                                                                <span class="old-price">
                                                                    <?php echo number_format($product_price, 0, ',', '.'); ?> VNĐ
                                                                </span>
                                                                <br>
                                                                <span class="new-price">
                                                                    <?php echo number_format($f_product_price = $product_price - ($product_price * $discount / 100), 0, ',', '.'); ?>
                                                                    VNĐ
                                                                </span>
                                                            <?php } else { ?>
                                                                <span>
                                                                    <?php echo number_format($f_product_price = $product_price, 0, '.', '.'); ?>
                                                                    VNĐ
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="quantity-col">
                                                            <div class="cart-product-quantity">
                                                                <input type="number" class="form-control" id="quantity"
                                                                    value="<?php echo $quantity ?>" min="1" step="1" data-decimals="0"
                                                                    <?php echo $data; ?> required>
                                                            </div><!-- End .cart-product-quantity -->
                                                        </td>
                                                        <td class="total-col">
                                                            <?php
                                                            $t = $f_product_price * $quantity;
                                                            echo number_format($t, 0, ',', '.'); ?>
                                                            VNĐ</td>
                                                        <td class="remove-col"><button <?php echo $data; ?> id="remove-from-cart-btn"
                                                                class="btn-remove"><i class="icon-close"></i></button>
                                                        </td>
                                                    </tr>

                                <?php }
                                            }
                                        }
                                    }
                                }
                                ?>

                            </tbody>
                        </table><!-- End .table table-wishlist -->

                        <div class="cart-bottom">
                            <a href="#" class="btn btn-outline-dark-2" id="clear-cart-btn">
                                Clear cart
                            </a>
                        </div><!-- End .cart-bottom -->
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td><?php echo number_format($total, 0, ',', '.') ?> VNĐ</td>

                                    </tr>
                                </tbody>
                            </table><!-- End .table table-summary -->
                            <?php
                            $page_checkout = get_page_by_path('thanh-toan');
                            if ($page_checkout) {
                                $page_checkout_url = get_permalink($page_checkout->ID);
                            } else {
                                $page_checkout_url = "";
                            } ?>
                            <a href="<?php echo $page_checkout_url ?>"
                                class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO
                                CHECKOUT</a>
                        </div><!-- End .summary -->

                        <a href="" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE
                                SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    <?php }
}

// Shortcode để hiển thị giỏ hàng
function sc_cart_content_shortcode()
{
    ob_start();
    sc_cart_content();
    return ob_get_clean();
}
add_shortcode('cart_content', 'sc_cart_content_shortcode');

function sc_checkout_content()
{
    if (!empty($_SESSION['cart'])) { ?>
        <div class="checkout">
            <form id="checkout-form" method="POST">
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                        <label>Name *</label>
                        <input id="customer_name" name="customer_name" type="text" class="form-control" required>

                        <label>Email *</label>
                        <input id="customer_email" name="customer_email" type="email" class="form-control" required>

                        <label>Phone *</label>
                        <input id="customer_phone" name="customer_phone" type="phone" class="form-control" required>

                        <label>Address *</label>
                        <input id="customer_address" name="customer_address" type="text" class="form-control" required>

                        <label>Order notes (optional)</label>
                        <textarea id="notes" name="notes" class="form-control" cols="30" rows="4"
                            placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary">
                            <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $total = 0;
                                    foreach ($_SESSION['cart'] as $product_id => $product_info) {
                                        $product = get_post($product_id);
                                        if ($product) {
                                            if (isset($product_info['options'])) {
                                                foreach ($product_info['options'] as $size => $colors) {
                                                    foreach ($colors as $color => $quantity) {
                                                        $product_price = (int)get_post_meta($product_id, '_product_price', true);
                                                        $discount = (int)get_post_meta($product_id, '_product_discount', true);
                                                        $discount_price = $product_price * $discount / 100;
                                                        $product_size = get_term($size, 'size');
                                                        $total += ($product_price - $discount_price)  * $quantity; ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo get_permalink($product_id) ?>">
                                                                    <?php echo ($color ? $color . ' ' : '') . $product->post_title . ($product_size->name ? ' | Size : ' . $product_size->name : '') ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <?php echo number_format($product_price - $discount_price, 0, '.', ','); ?>
                                                                VNĐ
                                                            </td>
                                                        </tr>
                                    <?php }
                                                }
                                            }
                                        }
                                    } ?>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td><?php echo number_format($total, 0, ',', '.') ?> VNĐ</td>
                                    </tr><!-- End .summary-subtotal -->
                                    <tr>
                                        <td>Shipping:</td>
                                        <td>Free shipping</td>
                                    </tr>
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td><?php echo number_format($total, 0, ',', '.') ?> VNĐ</td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                <span class="btn-text">Place Order</span>
                                <span class="btn-hover-text">Proceed to Checkout</span>
                            </button>
                        </div><!-- End .summary -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </form>
        </div>
<?php }
}
// Shortcode để hiển thị giỏ hàng
function sc_checkout_content_shortcode()
{
    ob_start();
    sc_checkout_content();
    return ob_get_clean();
}
add_shortcode('checkout_content', 'sc_checkout_content_shortcode');

//Hoa don
function sc_create_orders_table()
{
    global $wpdb;

    // Tên bảng
    $orders_table = $wpdb->prefix . 'orders';
    $order_items_table = $wpdb->prefix . 'order_items';

    // Kiểm tra charset
    $charset_collate = $wpdb->get_charset_collate();

    // SQL tạo bảng orders
    $sql_orders = "CREATE TABLE $orders_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(255) NOT NULL,
        customer_email VARCHAR(255) NOT NULL,
        customer_phone VARCHAR(255) NOT NULL,
        customer_address VARCHAR(255) NOT NULL,
        notes TEXT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        total_amount DECIMAL(10,2) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    // SQL tạo bảng order_items
    $sql_order_items = "CREATE TABLE $order_items_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        attributes TEXT,
        FOREIGN KEY (order_id) REFERENCES $orders_table(id) ON DELETE CASCADE
    ) $charset_collate;";

    // Tạo bảng
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_orders);
    dbDelta($sql_order_items);
}
register_activation_hook(__FILE__, 'sc_create_orders_table');

function sc_process_checkout()
{
    global $wpdb;

    // Lấy thông tin từ form thanh toán
    $customer_name = sanitize_text_field($_POST['customer_name']);
    $customer_email = sanitize_email($_POST['customer_email']);
    $customer_phone = sanitize_text_field($_POST['customer_phone']);
    $customer_address = sanitize_text_field($_POST['customer_address']);
    $notes = sanitize_text_field($_POST['notes']);
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    if (empty($customer_address)) {
        wp_send_json_error(['message' => 'Giỏ hàng trống.']);
    }
    // Kiểm tra giỏ hàng
    if (empty($cart)) {
        wp_send_json_error(['message' => 'Giỏ hàng trống.']);
    }

    // Tính tổng tiền
    $total_amount = 0;
    foreach ($cart as $product_id => $details) {
        foreach ($details['options'] as $size => $colors) {
            foreach ($colors as $color => $quantity) {
                $price = get_post_meta($product_id, '_product_price', true);
                $total_amount += $price * $quantity;
            }
        }
    }

    // Lưu thông tin hóa đơn
    $wpdb->insert(
        $wpdb->prefix . 'orders',
        [
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'customer_address' => $customer_address,
            'total_amount' => $total_amount,
            'notes' => $notes,
        ]
    );
    if ($order_id = $wpdb->insert_id) {

        // Lưu sản phẩm đã mua
        foreach ($cart as $product_id => $details) {
            foreach ($details['options'] as $size => $colors) {
                foreach ($colors as $color => $quantity) {
                    $wpdb->insert(
                        $wpdb->prefix . 'order_items',
                        [
                            'order_id' => $order_id,
                            'product_id' => $product_id,
                            'product_name' => get_the_title($product_id),
                            'quantity' => $quantity,
                            'price' => get_post_meta($product_id, '_product_price', true),
                            'attributes' => maybe_serialize(['size' => $size, 'color' => $color]),
                        ]
                    );
                }
            }
        }

        // Xóa giỏ hàng sau khi thanh toán thành công
        unset($_SESSION['cart']);

        // Trả về phản hồi thành công
        wp_send_json_success(['message' => 'Thanh toán thành công!']);
    }
}
add_action('wp_ajax_sc_process_checkout', 'sc_process_checkout');
add_action('wp_ajax_nopriv_sc_process_checkout', 'sc_process_checkout');
function sc_register_admin_menu()
{
    add_menu_page(
        'Quản lý hóa đơn', // Tiêu đề trang
        'Hóa đơn',         // Tên menu
        'manage_options',  // Quyền truy cập
        'sc-orders',       // Slug menu
        'sc_display_orders_page', // Hàm hiển thị
        'dashicons-list-view',    // Biểu tượng
        6
    );
}
add_action('admin_menu', 'sc_register_admin_menu');
function sc_display_orders_page()
{
    if (isset($_GET['order_id'])) {
        $order_id = intval($_GET['order_id']);
        sc_display_order_details($order_id);
        echo '<a href="' . admin_url('admin.php?page=sc-orders') . '">Quay lại danh sách hóa đơn</a>';
    } else {
        global $wpdb;

        $orders = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}orders");

        echo '<h1>Danh sách hóa đơn</h1>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Tổng tiền</th>
                <th>Tình trạng</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
              </tr></thead><tbody>';

        foreach ($orders as $order) {
            $details_url = admin_url('admin.php?page=sc-orders&order_id=' . $order->id);
            switch ($order->status) {
                case 'processing':
                    $_s = 'Đang xử lý';
                    break;
                case 'completed':
                    $_s = 'Đã hoàn thành';
                    break;
                case 'cancelled':
                    $_s = 'Đã hủy';
                    break;

                default:
                    $_s = 'Chờ xử lý';
                    break;
            }
            echo '<tr>
                    <td>' . $order->id . '</td>
                    <td>' . esc_html($order->customer_name) . '</td>
                    <td>' . esc_html($order->customer_email) . '</td>
                    <td>' . number_format($order->total_amount, 2) . ' VND</td>
                    <td>' . esc_html($_s) . '</td>
                    <td>' . esc_html($order->created_at) . '</td>
                    <td><a href="' . esc_url($details_url) . '">Xem chi tiết</a></td>
                  </tr>';
        }

        echo '</tbody></table>';
    }
}
function sc_display_order_details($order_id)
{
    global $wpdb;

    $order = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}orders WHERE id = %d", $order_id));

    echo '<h2>Chi tiết hóa đơn</h2>';

    // Form thay đổi tình trạng
    echo '<form method="post">';
    echo '<p><strong>Tình trạng:</strong></p>';
    echo '<select name="order_status">
            <option value="pending" ' . selected($order->status, 'pending', false) . '>Chờ xử lý</option>
            <option value="processing" ' . selected($order->status, 'processing', false) . '>Đang xử lý</option>
            <option value="completed" ' . selected($order->status, 'completed', false) . '>Đã hoàn thành</option>
            <option value="cancelled" ' . selected($order->status, 'cancelled', false) . '>Đã hủy</option>
          </select>';
    echo '<br><br><input type="submit" name="update_status" value="Cập nhật tình trạng" class="button button-primary"><br><br>';
    echo '</form>';

    // Cập nhật tình trạng
    if (isset($_POST['update_status'])) {
        $new_status = sanitize_text_field($_POST['order_status']);
        $wpdb->update(
            "{$wpdb->prefix}orders",
            ['status' => $new_status],
            ['id' => $order_id]
        );
        echo '<p>Tình trạng hóa đơn đã được cập nhật.</p>';
    }

    // Hiển thị các sản phẩm trong hóa đơn
    $order_items = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}order_items WHERE order_id = %d", $order_id)
    );

    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thuộc tính</th>
          </tr></thead><tbody>';

    foreach ($order_items as $item) {
        $attributes = maybe_unserialize($item->attributes);
        $attri = '';
        if (!empty($attributes['size'])) {
            $product_size = get_term($attributes['size'], 'size');
            $attri = $attri . ' Kích thước: ' . $product_size->name;
        }

        if (!empty($attributes['color'])) {
            $attri = $attri . ' Màu sắc: ' . $attributes['color'];
        }
        echo '<tr>
                <td>' . esc_html($item->product_name) . '</td>
                <td>' . $item->quantity . '</td>
                <td>' . number_format($item->price, 2) . ' VND</td>
                <td>' . esc_html($attri) . '</td>
              </tr>';
    }

    echo '</tbody></table>';
}
