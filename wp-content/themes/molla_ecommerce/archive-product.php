<?php
get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$search_query = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
$taxonomy_query = isset($_GET['product_category']) ? sanitize_text_field($_GET['product_category']) : '';

// Thiết lập query args
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 12, // Số sản phẩm trên mỗi trang
    'paged'          => $paged,
);

// Thêm điều kiện tìm kiếm từ khóa
if ($search_query) {
    $args['s'] = $search_query;
}

// Thêm điều kiện lọc theo taxonomy (nếu có)
if ($taxonomy_query) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_category',
            'field'    => 'slug',
            'terms'    => $taxonomy_query,
        ),
    );
}

// Thực hiện query
$query = new WP_Query($args);
?>

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Shop</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg">
                    <?php if ($query->have_posts()) : ?>
                    <div class="products mb-3">
                        <div class="row">
                            <?php while ($query->have_posts()) : $query->the_post();
                                    $discount = (int)get_post_meta(get_the_ID(), '_product_discount', true);
                                    $product_price = (int)get_post_meta(get_the_ID(), '_product_price', true);  ?>
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="product product-7 text-center">
                                    <figure class="product-media">
                                        <?php if (!empty($discount)) { ?>
                                        <span class="product-label label-sale">Discount <?php echo $discount ?>%</span>
                                        <?php } ?>
                                        <?php if (is_recent_product(get_the_ID())) : ?>
                                        <span class="product-label label-new">New</span>
                                        <?php endif; ?>

                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium'); ?>
                                            <?php endif; ?>
                                        </a>

                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                                    to wishlist</span></a>
                                        </div><!-- End .product-action-vertical -->
                                    </figure><!-- End .product-media -->

                                    <div class="product-body">
                                        <h3 class="product-title"><a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a></h3><!-- End .product-title -->
                                        <div class="product-price">
                                            <?php if (!empty($discount)) { ?>
                                            <span class="new-price" style="width: 100%;">
                                                <?php echo number_format($product_price - ($product_price * $discount / 100), 0, '.', ','); ?>
                                                VND
                                            </span>
                                            <span class="old-price" style="width: 100%;">
                                                <?php echo number_format($product_price, 0, '.', ','); ?> VND
                                            </span>

                                            <?php } else { ?>
                                            <span>
                                                <?php echo number_format($product_price, 0, '.', ','); ?> VND
                                            </span>
                                            <?php } ?>
                                        </div><!-- End .product-price -->
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: 20%;"></div>
                                                <!-- End .ratings-val -->
                                            </div><!-- End .ratings -->
                                            <span class="ratings-text">( 2 Reviews )</span>
                                        </div><!-- End .rating-container -->
                                    </div><!-- End .product-body -->
                                </div><!-- End .product -->
                            </div><!-- End .col-sm-6 col-lg-4 -->
                            <?php endwhile; ?>
                        </div><!-- End .row -->
                    </div><!-- End .products -->

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php
                                echo paginate_links(array(
                                    'total'   => $query->max_num_pages,
                                    'current' => $paged,
                                ));
                                ?>
                        </ul>
                    </nav>
                    <?php else : ?>
                    <p>Không tìm thấy sản phẩm nào.</p>
                    <?php endif; ?>

                    <?php wp_reset_postdata(); ?>

                </div><!-- End .col-lg-9 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div>
</main>

<?php
get_footer();
?>