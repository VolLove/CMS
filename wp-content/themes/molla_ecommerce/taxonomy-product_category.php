<?php
get_header();
// Lấy thông tin category hiện tại
$current_category = get_queried_object();

// Thiết lập các tham số cho truy vấn sản phẩm
$paged = (get_query_var('page')) ? get_query_var('page') : 1;
$args = array(
    'post_type' => 'product', // Thay bằng post type của bạn
    'posts_per_page' => 2,  // Số sản phẩm trên mỗi trang
    'paged' => $paged,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_category', // Thay bằng taxonomy bạn sử dụng
            'field'    => 'slug',
            'terms'    => $current_category->slug, // Lấy sản phẩm theo category hiện tại
        ),
    ),
);
// Truy vấn sản phẩm
$products = new WP_Query($args); ?>

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">

            <h1 class="page-title"><?php single_term_title();
                                    echo $paged; ?><span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home </a></li>
                <li class="breadcrumb-item"><a
                        href="<?php echo esc_url(get_post_type_archive_link('product')); ?>">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php single_term_title(); ?></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="toolbox">
                        <div class="toolbox-right">
                            <div class="toolbox-sort">
                                <label for="sortby">Sort by:</label>
                                <div class="select-custom">
                                    <select name="sortby" id="sortby" class="form-control">
                                        <option value="popularity" selected="selected">Most Popular</option>
                                        <option value="rating">Most Rated</option>
                                        <option value="date">Date</option>
                                    </select>
                                </div>
                            </div><!-- End .toolbox-sort -->
                        </div><!-- End .toolbox-right -->
                    </div><!-- End .toolbox -->

                    <div class="products mb-3">
                        <div class="row">

                            <?php if ($products->have_posts()) : ?>
                            <?php while ($products->have_posts()) :
                                    $products->the_post();
                                    $discount = (int)get_post_meta(get_the_ID(), '_product_discount', true);
                                    $product_price = (int)get_post_meta(get_the_ID(), '_product_price', true); ?>


                            <div class="col-6 col-md-4 col-lg-4">
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
                                                    to
                                                    wishlist</span></a>
                                        </div><!-- End .product-action-vertical -->

                                        <div class="product-action">
                                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                        </div><!-- End .product-action -->
                                    </figure><!-- End .product-media -->

                                    <div class="product-body">
                                        <h3 class="product-title"><a href="product.html">Brown paperbag waist pencil
                                                skirt</a></h3><!-- End .product-title -->
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
                            </div>
                            <?php endwhile; ?>
                        </div><!-- End .row -->
                        <?php else : ?>
                        <p>Không có sản phẩm nào trong danh mục này.</p>
                        <?php endif; ?>
                    </div><!-- End .products -->

                    <nav aria-label="Page navigation">
                        <!-- Phân trang -->
                        <div class="pagination">
                            <?php
                            echo paginate_links(array(
                                'total'        => $products->max_num_pages,
                                'current'      => $paged,
                                'format'       => '?page=%#%',
                                'show_all'     => false,
                                'end_size'     => 2,
                                'mid_size'     => 1,
                                'prev_next'    => true,
                                'prev_text'    => __('« Previous'),
                                'next_text'    => __('Next »'),
                                'type'         => 'plain',
                            ));
                            ?>
                        </div>
                    </nav>
                </div><!-- End .col-lg-9 -->
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
                            <label>Filters:</label>
                            <a href="#" class="sidebar-filter-clear">Clean All</a>
                        </div><!-- End .widget widget-clean -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true"
                                    aria-controls="widget-1">
                                    Category
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count">
                                        <?php
                                        $categories = get_terms(['taxonomy' => 'product_category', 'hide_empty' => false]);
                                        foreach ($categories as $category) :
                                            $checked = ($current_category->slug == $category->slug) ? 'checked' : '';
                                        ?>
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input <?php echo $checked; ?> type="checkbox" name="category"
                                                    value="<?php echo esc_attr($category->slug); ?>"
                                                    class="custom-control-input"
                                                    id="cat-<?php echo esc_attr($category->slug); ?>">
                                                <label class="custom-control-label"
                                                    for="cat-<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->
                                        <option value="">

                                        </option>
                                        <?php endforeach; ?>


                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
    <?php wp_reset_postdata(); ?>
</main>
<?php get_footer(); ?>