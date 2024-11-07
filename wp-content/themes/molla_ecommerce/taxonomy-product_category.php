<?php get_header(); ?>

<h1><?php single_term_title(); ?></h1>

<?php
// Hiển thị mô tả của category (nếu có)
$term_description = term_description();
if (!empty($term_description)) {
    echo '<div class="taxonomy-description">' . $term_description . '</div>';
}
?>

<div class="product-list">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <div class="product-item">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
        <?php endif; ?>
        <div class="product-excerpt">
            <?php the_excerpt(); ?>
        </div>
    </div>
    <?php endwhile; ?>
    <?php else : ?>
    <p>Không có sản phẩm nào trong danh mục này.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>