<?php

/*
Template Name: Parent Page
*/
get_header(); // Gọi file header.php
?>

<div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/ocean.jpg)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title() ?></h1>
        <div class="page-banner__intro">
            <p>Learn how the school of your dreams got started.</p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">

    <div class="page-links">
        <h2 class="page-links__title"><a href="
        <?php
        $page = get_page_by_path('about-us');
        if ($page) {
            $page_url = get_permalink($page->ID);
            echo esc_url($page_url);
        }
        ?> ">About Us</a></h2>
        <ul class=" min-list">
            <li class="current_page_item"><a href="
            <?php
            $page = get_page_by_path('about-us/our-history/');
            if ($page) {
                $page_url = get_permalink($page->ID);
                echo esc_url($page_url);
            }
            ?>">Our History</a></li>
        </ul>
    </div>

    <div class="generic-content">
        <?php the_content(); ?>
    </div>
</div>
<?php
get_footer(); // Gọi file footer.php
?>