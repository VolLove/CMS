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
        } else {
          alert(response.data.message);
        }
      }
    );
  });

  $("#checkout-form").on("submit", function (e) {
    e.preventDefault();

    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_process_checkout",
        customer_name: $("#customer_name").val(),
        customer_email: $("#customer_email").val(),
        customer_phone: $("#customer_phone").val(),
        customer_address: $("#customer_address").val(),
        notes: $("#notes").val(),
      },
      function (response) {
        if (response.success) {
          alert(response.data.message);
        } else {
          alert(response.data.message);
        }
      }
    );
  });
  // Xử lý xóa từng sản phẩm khỏi giỏ hàng
  $(document).on("click", "#remove-from-cart-btn", function (e) {
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
          reloadPageCartContent(); //Load lại trang giỏ hàng
        }
      }
    );
  });
  //Hủy hóa đơn
  $(document).on("click", "#cancel-order-btn", function (e) {
    e.preventDefault();
    const order_id = $(this).data("order-id");
    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_handle_order_cancellation",
        order_id: order_id,
      },
      function (response) {
        if (response.success) {
          reloadTableOrderContent();
        } else {
          alert(response.data.message);
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
          reloadPageCartContent(); //Load lại trang giỏ hàng
        }
      }
    );
  });

  //xử lý Thay đổi số lượng
  $(document).on("change", "#quantity", function () {
    const quantity = $(this).val();
    const productId = $(this).data("product-id");
    const size = $(this).data("size");
    const color = $(this).data("color"); // Lấy giá trị mới của input
    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_update_cart_quantity",
        product_id: productId,
        quantity: quantity,
        color: color,
        size: size,
      },
      function (response) {
        if (response.success) {
          reloadCartContent(); // Load lại giỏ hàng
          reloadPageCartContent(); //Load lại trang giỏ hàng
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
          $("#cart-dropdown-content").html(response.data.cart_html); // Cập nhật nội dung giỏ hàng
        }
      }
    );
  }
  function reloadPageCartContent() {
    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_get_page_cart_content",
      },
      function (response) {
        if (response.success) {
          $("#page-content").html(response.data.cart_page_html); // Cập nhật nội dung giỏ hàng
        }
      }
    );
  }
  function reloadTableOrderContent() {
    $.post(
      sc_vars.ajax_url,
      {
        action: "sc_get_order_table_content",
      },
      function (response) {
        if (response.success) {
          $("#tab-orders").html(response.data.order_table_html); // Cập nhật nội dung giỏ hàng
        }
      }
    );
  }
});
