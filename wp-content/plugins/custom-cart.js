jQuery(document).ready(function ($) {
  // Xử lý thêm vào giỏ hàng
  $(".add-to-cart-btn").on("click", function (e) {
    e.preventDefault();
    const productId = $(this).data("product-id");
    const quantity = $(this).data("quantity") || 1;

    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_add_to_cart",
        product_id: productId,
        quantity: quantity,
      },
      function (response) {
        if (response.success) {
          reloadCartContent(); // Load lại giỏ hàng
        }
      }
    );
  });

  // Xử lý xóa từng sản phẩm khỏi giỏ hàng
  $(document).on("click", ".remove-from-cart-btn", function (e) {
    e.preventDefault();
    const productId = $(this).data("product-id");

    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_remove_from_cart",
        product_id: productId,
      },
      function (response) {
        if (response.success) {
          reloadCartContent(); // Load lại giỏ hàng
        }
      }
    );
  });

  // Xử lý xóa toàn bộ giỏ hàng
  $("#clear-cart-btn").on("click", function (e) {
    e.preventDefault();

    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_clear_cart",
      },
      function (response) {
        if (response.success) {
          reloadCartContent(); // Load lại giỏ hàng
        }
      }
    );
  });

  // Hàm load lại giỏ hàng
  function reloadCartContent() {
    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_get_cart_content",
      },
      function (response) {
        if (response.success) {
          $("#cart-content").html(response.data.cart_html); // Cập nhật nội dung giỏ hàng
        }
      }
    );
  }
});
