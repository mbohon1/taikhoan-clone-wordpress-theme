<?php
/**
 * Template for displaying single product
 *
 * @package Taikhoan_Clone
 */

get_header();

// Get product meta
$price = get_post_meta(get_the_ID(), '_product_price', true);
$stock = get_post_meta(get_the_ID(), '_product_stock', true);
$sold = get_post_meta(get_the_ID(), '_product_sold', true);
$warranty = get_post_meta(get_the_ID(), '_product_warranty', true);
?>

<div class="single-product-wrapper">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="product-<?php the_ID(); ?>" <?php post_class('single-product'); ?>>
                <div class="product-header">
                    <nav class="product-breadcrumb">
                        <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'taikhoan-clone'); ?></a>
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'product_category');
                        if ($terms && !is_wp_error($terms)) :
                            echo ' / ';
                            $term = array_shift($terms);
                            echo '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                        endif;
                        ?>
                        <?php echo ' / ' . get_the_title(); ?>
                    </nav>
                </div>

                <div class="product-content">
                    <div class="product-gallery">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="product-image">
                                <?php the_post_thumbnail('large', array('class' => 'main-image')); ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Additional product images
                        $gallery_images = get_post_meta(get_the_ID(), '_product_gallery', true);
                        if ($gallery_images) :
                        ?>
                            <div class="product-thumbnails">
                                <?php
                                $images = explode(',', $gallery_images);
                                foreach ($images as $image_id) :
                                    echo wp_get_attachment_image($image_id, 'thumbnail', false, array('class' => 'thumbnail'));
                                endforeach;
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-details">
                        <h1 class="product-title"><?php the_title(); ?></h1>

                        <div class="product-meta">
                            <?php if ($price) : ?>
                                <div class="product-price">
                                    <span class="price-label"><?php _e('Price:', 'taikhoan-clone'); ?></span>
                                    <span class="price-amount"><?php echo number_format($price, 0, ',', '.'); ?>đ</span>
                                </div>
                            <?php endif; ?>

                            <div class="product-stats">
                                <?php if ($stock !== '') : ?>
                                    <div class="stock-info">
                                        <span class="label"><?php _e('Còn lại:', 'taikhoan-clone'); ?></span>
                                        <span class="value"><?php echo esc_html($stock); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($sold !== '') : ?>
                                    <div class="sold-info">
                                        <span class="label"><?php _e('Đã bán:', 'taikhoan-clone'); ?></span>
                                        <span class="value"><?php echo esc_html($sold); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($warranty) : ?>
                            <div class="product-warranty">
                                <h3><?php _e('Warranty Information', 'taikhoan-clone'); ?></h3>
                                <?php echo wp_kses_post($warranty); ?>
                            </div>
                        <?php endif; ?>

                        <div class="product-description">
                            <?php the_content(); ?>
                        </div>

                        <div class="product-actions">
                            <div class="quantity-wrapper">
                                <label for="product-quantity"><?php _e('Quantity:', 'taikhoan-clone'); ?></label>
                                <input type="number" id="product-quantity" class="quantity-input" value="1" min="1" max="<?php echo esc_attr($stock); ?>">
                            </div>

                            <button class="buy-button" data-product-id="<?php the_ID(); ?>">
                                <?php _e('MUA NGAY', 'taikhoan-clone'); ?>
                            </button>
                        </div>

                        <div class="product-notice">
                            <p class="notice-text">
                                <?php _e('NOTE: All accounts are only guaranteed for login, after successful check please change security information, after 3 hours no warranty', 'taikhoan-clone'); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                <?php
                $related_args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'post__not_in' => array(get_the_ID()),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_category',
                            'field' => 'term_id',
                            'terms' => wp_get_post_terms(get_the_ID(), 'product_category', array('fields' => 'ids')),
                        ),
                    ),
                );

                $related_products = new WP_Query($related_args);

                if ($related_products->have_posts()) :
                ?>
                    <div class="related-products">
                        <h2><?php _e('Related Products', 'taikhoan-clone'); ?></h2>
                        <div class="products-grid">
                            <?php
                            while ($related_products->have_posts()) :
                                $related_products->the_post();
                                get_template_part('template-parts/product', 'card');
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<!-- Purchase Modal Template -->
<div class="purchase-modal" style="display: none;">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3><?php _e('Confirm Purchase', 'taikhoan-clone'); ?></h3>
        
        <div class="modal-product-info">
            <h4 class="modal-product-title"></h4>
            <div class="modal-product-price"></div>
        </div>

        <div class="modal-quantity">
            <label><?php _e('Quantity:', 'taikhoan-clone'); ?></label>
            <input type="number" class="modal-quantity-input" value="1" min="1">
        </div>

        <div class="modal-total">
            <span class="total-label"><?php _e('Total:', 'taikhoan-clone'); ?></span>
            <span class="total-amount"></span>
        </div>

        <div class="modal-actions">
            <button class="confirm-purchase"><?php _e('Confirm Purchase', 'taikhoan-clone'); ?></button>
            <button class="cancel-purchase"><?php _e('Cancel', 'taikhoan-clone'); ?></button>
        </div>
    </div>
</div>

<?php get_footer(); ?>
