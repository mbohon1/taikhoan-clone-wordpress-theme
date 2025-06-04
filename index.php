<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="products-section">
            <?php if (have_posts()) : ?>
                <div class="products-grid">
                    <?php 
                    // Custom query for products
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 12,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    
                    $products_query = new WP_Query($args);
                    
                    if ($products_query->have_posts()) :
                        while ($products_query->have_posts()) : $products_query->the_post();
                            // Get product meta
                            $price = get_post_meta(get_the_ID(), '_product_price', true);
                            $stock = get_post_meta(get_the_ID(), '_product_stock', true);
                            $sold = get_post_meta(get_the_ID(), '_product_sold', true);
                    ?>
                            <article class="product-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="product-image">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="product-content">
                                    <h2 class="product-title">
                                        <?php the_title(); ?>
                                    </h2>

                                    <div class="product-meta">
                                        <?php if ($price) : ?>
                                            <div class="product-price">
                                                <?php echo number_format($price, 0, ',', '.'); ?>đ
                                            </div>
                                        <?php endif; ?>

                                        <div class="product-stats">
                                            <?php if ($stock) : ?>
                                                <span class="product-stock">
                                                    <?php 
                                                    printf(
                                                        /* translators: %s: number of items in stock */
                                                        esc_html__('Còn lại: %s', 'taikhoan-clone'),
                                                        esc_html($stock)
                                                    ); 
                                                    ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($sold) : ?>
                                                <span class="product-sold">
                                                    <?php 
                                                    printf(
                                                        /* translators: %s: number of items sold */
                                                        esc_html__('Đã bán: %s', 'taikhoan-clone'),
                                                        esc_html($sold)
                                                    ); 
                                                    ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <a href="<?php the_permalink(); ?>" class="buy-button">
                                        <?php esc_html_e('MUA NGAY', 'taikhoan-clone'); ?>
                                    </a>
                                </div>
                            </article>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <?php
                // Pagination
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('Previous', 'taikhoan-clone'),
                    'next_text' => __('Next', 'taikhoan-clone'),
                ));
                ?>

            <?php else : ?>
                <div class="no-products">
                    <p><?php esc_html_e('No products found.', 'taikhoan-clone'); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Orders Section -->
        <div class="recent-orders">
            <h3><?php esc_html_e('ĐƠN HÀNG GẦN ĐÂY', 'taikhoan-clone'); ?></h3>
            <div class="orders-list">
                <?php
                // This would typically be populated with actual order data
                // For now, we'll add some dummy data
                ?>
                <div class="order-item">
                    <span class="order-user">...cec</span>
                    <span class="order-action"><?php _e('Mua', 'taikhoan-clone'); ?></span>
                    <span class="order-quantity">1</span>
                    <span class="order-product">Account Digital Ocean 3 Droplet</span>
                    <span class="order-price">199.000đ</span>
                    <span class="order-time">7 phút trước</span>
                </div>
                <!-- Add more order items as needed -->
            </div>
        </div>

        <!-- Recent Deposits Section -->
        <div class="recent-deposits">
            <h3><?php esc_html_e('NẠP TIỀN GẦN ĐÂY', 'taikhoan-clone'); ?></h3>
            <div class="deposits-list">
                <?php
                // This would typically be populated with actual deposit data
                // For now, we'll add some dummy data
                ?>
                <div class="deposit-item">
                    <span class="deposit-user">...cec</span>
                    <span class="deposit-action"><?php _e('thực hiện nạp', 'taikhoan-clone'); ?></span>
                    <span class="deposit-amount">210.000đ</span>
                    <span class="deposit-method">ACB</span>
                    <span class="deposit-time">10 phút trước</span>
                </div>
                <!-- Add more deposit items as needed -->
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
