<?php
/*
Template Name: Check out page
*/
get_header(); // Gọi file header.php
?>
<main class="main">
    <div class="container">
        <?php echo do_shortcode('[checkout_page]'); ?>
    </div>
</main><!-- End .main -->
<?php
get_footer(); // Gọi file footer.php
?>