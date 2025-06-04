<?php
/**
 * Template part for displaying product cards
 *
 * @package Taikhoan_Clone
 */

// Get product meta
$price = get_post_meta(get_the_ID(), '_product_price', true);
$stock = get_post_meta(get_the_ID(), '_product_stock', true);
$sold = get_post_meta(get_the_ID(), '_product_sold', true);
$category = get_the_terms(get_the_ID(), 'product_category');
?>

<article <?php post_class('product-card'); ?>>
    <div class="product-header">
        <?php if ($category && !is_wp_error($category)) : ?>
            <div class="product-category">
                <?php
                $category_icon = get_term_meta($category[0]->term_id, 'category_icon', true);
                if ($category_icon) : ?>
                    <img src="<?php echo esc_url($category_icon); ?>" alt="<?php echo esc_attr($category[0]->name); ?>" class="category-icon">
                <?php endif; ?>
                <span class="category-name"><?php echo esc_html($category[0]->name); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="product-content">
        <h2 class="product-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>

        <?php if (has_post_thumbnail()) : ?>
            <div class="product-image">
                <?php the_post_thumbnail('medium', array('class' => 'product-thumbnail')); ?>
            </div>
        <?php endif; ?>

        <div class="product-details">
            <?php if ($price) : ?>
                <div class="product-price">
                    <strong><?php echo number_format($price, 0, ',', '.'); ?>đ</strong>
                </div>
            <?php endif; ?>

            <div class="product-stats">
                <?php if ($stock !== '') : ?>
                    <div class="stock-info">
                        <span class="label"><?php esc_html_e('Còn lại:', 'taikhoan-clone'); ?></span>
                        <span class="value"><?php echo esc_html($stock); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($sold !== '') : ?>
                    <div class="sold-info">
                        <span class="label"><?php esc_html_e('Đã bán:', 'taikhoan-clone'); ?></span>
                        <span class="value"><?php echo esc_html($sold); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="product-actions">
            <a href="<?php the_permalink(); ?>" class="buy-button">
                <?php esc_html_e('MUA NGAY', 'taikhoan-clone'); ?>
            </a>
        </div>

        <?php if (has_excerpt()) : ?>
            <div class="product-description">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>

        <?php
        // Display warranty information if it exists
        $warranty = get_post_meta(get_the_ID(), '_product_warranty', true);
        if ($warranty) : ?>
            <div class="product-warranty">
                <?php echo wp_kses_post($warranty); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="product-footer">
        <?php
        // Add any additional product information or features here
        $additional_info = get_post_meta(get_the_ID(), '_additional_info', true);
        if ($additional_info) : ?>
            <div class="additional-info">
                <?php echo wp_kses_post($additional_info); ?>
            </div>
        <?php endif; ?>
    </div>
</article>
