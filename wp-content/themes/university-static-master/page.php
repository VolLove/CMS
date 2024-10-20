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
</div>
<div class="container container--narrow page-section">
    <?php
    $parent_id = wp_get_post_parent_id(get_the_ID());

    if ($parent_id) {
    ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="
            <?php

            $page_url = get_permalink($parent_id);
            $parent_title = get_the_title($parent_id);

            echo esc_url($page_url);
            ?> 
            "><i class="fa fa-home" aria-hidden="true"></i> Back to
                    <?php
                    echo esc_html($parent_title)
                    ?>
                </a> <span class="metabox__main"><?php the_title() ?></span>
            </p>
        </div>
    <?php
    } else {
    ?>
        <?php
        $current_page_id = get_the_ID();

        $parent_id = $current_page_id;

        $args = array(
            'child_of' => $parent_id,
            'depth' => 1,
            'title_li' => '',
        );
        ?>
        <div class="page-links">
            <h2 class="page-links__title"><a href="
        <?php
        $page_url = get_permalink($parent_id);
        echo esc_url($page_url);
        ?> "><?php the_title() ?></a></h2>
            <ul class=" min-list">
                <?php echo wp_list_pages($args); ?>
            </ul>
        </div>
    <?php
    }
    ?>

    <div class="generic-content">
        <?php the_content(); ?>
    </div>
</div>
<?php
get_footer(); // Gọi file footer.php
?>