<?php
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
    <div class="generic-content">
        <?php the_content(); ?>
    </div>
</div>
<?php
get_footer(); // Gọi file footer.php
?>