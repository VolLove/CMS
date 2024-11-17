<?php
/*
Template Name: Custom Login
*/
get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/ocean.jpg)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title() ?></h1>
    </div>

    <div class="container container--narrow page-section">
        <div class="login-form-container">
            <?php
            wp_login_form();
            ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>