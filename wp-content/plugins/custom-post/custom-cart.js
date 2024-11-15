jQuery(document).ready(function ($) {
  // Xử lý thêm vào giỏ hàng
  $("#add-to-card-form").submit(function (e) {
    e.preventDefault();
    const productId = $("#product-id").val();
    const quantity = $("#quantity").val();
    const colorID = $('input[name="color"]:checked').val();
    const sizeID = $("#size").val();
    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_add_to_cart",
        product_id: productId,
        quantity: quantity,
        color: colorID,
        size: sizeID,
      },
      function (response) {
        if (response.success) {
          reloadCartContent(); // Load lại giỏ hàng
          alert(response.data.message);
        } else {
          alert(response.data.message);
        }
      }
    );
  });
  // Xử lý xóa từng sản phẩm khỏi giỏ hàng
  $(".remove-from-cart-btn").on("click", function (e) {
    e.preventDefault();
    const productId = $(this).data("product-id");
    const size = $(this).data("size");
    const color = $(this).data("color");

    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_remove_from_cart",
        product_id: productId,
        size: size,
        color: color,
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
  } // Hàm load lại giỏ hàng
  function reloadPageCartContent() {
    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_get_page_cart_content",
      },
      function (response) {
        if (response.success) {
          $("#page-cart-content").html(response.data.cart_html); // Cập nhật nội dung giỏ hàng
        }
      }
    );
  }
});
