<?php get_header();
?>
<?php if (have_posts()) :
    while (have_posts()) : the_post();
        $product_price = (int)get_post_meta(get_the_ID(), '_product_price', true);
        $product_colors = get_post_meta(get_the_ID(), '_product_colors', true);
        $discount = get_post_meta(get_the_ID(), '_product_discount', true);
        // Lấy URL của ảnh thumbnail của bài đăng hiện tại
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $product_categories = get_the_terms(get_the_ID(), 'product_category');
        // Kiểm tra và hiển thị đường dẫn nếu tồn tại ảnh thumbnail
        if (!$thumbnail_url) {
            $thumbnail_url = "error";
        }
?>

<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <?php if (!empty($discount)) { ?>
                                    <span class="product-label label-sale">Discount <?php echo $discount ?>%</span>
                                    <?php } ?>
                                    <?php if (is_recent_product(get_the_ID())) : ?>
                                    <span class="product-label label-new">New</span>
                                    <?php endif; ?>

                                    <img id="product-zoom" src="<?php echo $thumbnail_url ?>"
                                        alt="<?php the_title(); ?>">
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    <a class="product-gallery-item active">
                                        <img src="<?php echo $thumbnail_url ?>" class="product-image"
                                            alt="<?php the_title(); ?>">
                                    </a>
                                    <?php
                                            $product_images = get_post_meta(get_the_ID(), '_product_images', true);
                                            if (!empty($product_images)) {
                                                foreach ($product_images as $image) { ?>
                                    <a class="product-gallery-item">
                                        <img src="<?php echo esc_url($image) ?>" class="product-image"
                                            alt="<?php the_title(); ?>">
                                    </a>
                                    <?php        }
                                            }
                                            ?>
                                </div><!-- End .product-image-gallery -->
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <form id="add-to-card-form" method="post">
                            <div class="product-details">
                                <h1 class="product-title"><?php the_title(); ?></h1>
                                <!-- End .product-title -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews
                                        )</a>
                                </div><!-- End .rating-container -->

                                <div class="product-price">
                                    <?php if (!empty($discount)) { ?>
                                    <span class="new-price">
                                        <?php echo number_format($product_price - ($product_price * $discount / 100), 0, '.', ','); ?>
                                        VND
                                    </span>
                                    <span class="old-price">
                                        <?php echo number_format($product_price, 0, '.', ','); ?> VND
                                    </span>
                                    <?php } else { ?>
                                    <span>
                                        <?php echo number_format($product_price, 0, '.', ','); ?> VND
                                    </span>
                                    <?php } ?>
                                </div><!-- End .product-price -->
                                <div class="product-content">
                                    <?php the_content(); ?>
                                </div><!-- End .product-content -->
                                <?php if (!empty($product_colors)) { ?>
                                <div class="details-filter-row details-row-size">
                                    <label>Color:</label>

                                    <div class="product-nav product-nav-thumbs " id="product-group-radio">
                                        <?php
                                                    $count = 0;
                                                    foreach ($product_colors as $color => $image_id) {
                                                        $image_url = wp_get_attachment_url($image_id); ?>
                                        <a class="product-radio-item <?php echo $count == 0 ? "active" : "" ?>">
                                            <input <?php echo $count == 0 ? "checked" : "" ?>
                                                value="<?php echo esc_attr($color)  ?>" type="radio" class="btn-check"
                                                autocomplete="off" name="color" id="btncheck<?php echo $count ?>" />
                                            <label for="btncheck<?php echo $count ?>">
                                                <img class="product-image" src=" <?php echo esc_url($image_url) ?>"
                                                    alt="<?php echo esc_html($color) ?>">
                                            </label>
                                        </a>
                                        <?php $count++;
                                                    } ?>
                                    </div><!-- End .product-nav -->
                                </div><!-- End .details-filter-row -->
                                <?php }
                                        // Lấy kích thước từ custom field của sản phẩm hiện tại
                                        // $product_sizes = get_post_meta(get_the_ID(), '_product_sizes', true);
                                        // Lấy danh sách các term (kích thước) từ taxonomy 'product_size' của sản phẩm hiện tại
                                        $product_sizes = wp_get_post_terms(get_the_ID(), 'size');

                                        if (!empty($product_sizes) && !is_wp_error($product_sizes)) { ?>

                                <div class="details-filter-row details-row-size">
                                    <label for="size">Size:</label>
                                    <div class="select-custom">
                                        <select name="size" id="size" class="form-control">
                                            <option>Select a size</option>
                                            <?php foreach ($product_sizes as $size) { ?>
                                            <option value="<?php echo esc_html($size->term_id) ?>">
                                                <?php echo esc_html($size->name) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .details-filter-row -->

                                <?php } ?>
                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                            value="1" min="1" max="10" step="1" data-decimals="0" required>
                                    </div><!-- End .product-details-quantity -->
                                </div><!-- End .details-filter-row -->


                                <div class="product-details-action">
                                    <button href="" type="submit" name="product-id" id="product-id"
                                        value="<?php echo get_the_ID() ?>" class="btn-product btn-cart"><span>add to
                                            cart</span>
                                    </button>

                                    <div class="details-action-wrapper">
                                        <a href="" class="btn-product btn-wishlist" title="Wishlist"><span>Add to
                                                Wishlist</span></a>
                                    </div><!-- End .details-action-wrapper -->
                                </div><!-- End .product-details-action -->

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <?php
                                                if (!empty($product_categories) && !is_wp_error($product_categories)) {
                                                    foreach ($product_categories as $category) {
                                                ?>
                                        <a href="<?php echo  esc_url(get_term_link($category)) ?>">
                                            <?php echo esc_html($category->name) ?>
                                        </a>,
                                        <?php }
                                                } ?>
                                    </div><!-- End .product-cat -->

                                    <div class="social-icons social-icons-sm">
                                        <span class="social-label">Share:</span>
                                        <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                                class="icon-facebook-f"></i></a>
                                        <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                                class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                                class="icon-instagram"></i></a>
                                        <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                                class="icon-pinterest"></i></a>
                                    </div>
                                </div><!-- End .product-details-footer -->
                            </div><!-- End .product-details -->
                        </form>
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                            role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab"
                            aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab"
                            role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping &amp;
                            Returns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                            role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                        aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <h3>Product Information</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat
                                mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper
                                suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam
                                porttitor mauris sit amet orci. Aenean dignissim pellentesque felis. Phasellus ultrices
                                nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique
                                cursus. </p>
                            <ul>
                                <li>Nunc nec porttitor turpis. In eu risus enim. In vitae mollis elit. </li>
                                <li>Vivamus finibus vel mauris ut vehicula.</li>
                                <li>Nullam a magna porttitor, dictum risus nec, faucibus sapien.</li>
                            </ul>

                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat
                                mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper
                                suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam
                                porttitor mauris sit amet orci. Aenean dignissim pellentesque felis. Phasellus ultrices
                                nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique
                                cursus. </p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                        aria-labelledby="product-info-link">
                        <div class="product-desc-content">
                            <h3>Information</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat
                                mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper
                                suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam
                                porttitor mauris sit amet orci. </p>

                            <h3>Fabric &amp; care</h3>
                            <ul>
                                <li>Faux suede fabric</li>
                                <li>Gold tone metal hoop handles.</li>
                                <li>RI branding</li>
                                <li>Snake print trim interior </li>
                                <li>Adjustable cross body strap</li>
                                <li> Height: 31cm; Width: 32cm; Depth: 12cm; Handle Drop: 61cm</li>
                            </ul>

                            <h3>Size</h3>
                            <p>one size</p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                        aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <h3>Delivery &amp; returns</h3>
                            <p>We deliver to over 100 countries around the world. For full details of the delivery
                                options we offer, please view our <a href="#">Delivery information</a><br>
                                We hope you’ll love every purchase, but if you ever need to return an item you can do so
                                within a month of receipt. For full details of how to make a return, please view our <a
                                    href="#">Returns information</a></p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                        aria-labelledby="product-review-link">
                        <?php
                                if (comments_open() || get_comments_number()) {
                                    comments_template();
                                }
                                ?>
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->

            <div class="row">
                <?php
                        $category_slugs = wp_list_pluck($product_categories, 'slug');
                        echo get_related_products($category_slugs) ?>
            </div>
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".product-image").forEach(function(img) {
        img.addEventListener("click", function() {
            const mainImage = document.querySelector(
                ".product-main-image img");
            if (mainImage) {
                mainImage.src = img.src;
            }
        });
    });
});
</script>
<?php
    endwhile;
endif; ?>
<?php get_footer(); ?>