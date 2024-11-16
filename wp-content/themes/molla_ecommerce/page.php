<?php
get_header(); // Gọi file header.php
?>
<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        // Lấy nội dung của trang
        $content = get_the_content(); ?>

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content container" id="page-content">

        <?php echo apply_filters('the_content', $content); // Xử lý shortcode
                ?>
    </div>

</main>
<?php

    endwhile;
endif; ?>
<?php
get_footer(); // Gọi file footer.php
?>