<?php
/**
 * The template for displaying product archives
 *
 * @package Taikhoan_Clone
 */

get_header(); ?>

<div class="archive-header">
    <div class="container">
        <?php if (is_tax('product_category')) : ?>
            <h1 class="archive-title">
                <?php single_term_title(); ?>
            </h1>
            <?php
            $term_description = term_description();
            if (!empty($term_description)) :
                printf('<div class="archive-description">%s</div>', wp_kses_post($term_description));
            endif;
        else : ?>
            <h1 class="archive-title">
                <?php esc_html_e('TẤT CẢ SẢN PHẨM', 'taikhoan-clone'); ?>
            </h1>
        <?php endif; ?>
    </div>
</div>

<div class="site-content">
    <div class="container">
        <div class="content-wrapper">
            <!-- Product Categories Sidebar -->
            <aside class="product-sidebar">
                <div class="product-categories">
                    <h2><?php esc_html_e('Categories', 'taikhoan-clone'); ?></h2>
                    <ul class="category-list">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'product_category',
                            'hide_empty' => true,
                        ));

                        if (!empty($categories) && !is_wp_error($categories)) :
                            foreach ($categories as $category) :
                                $category_icon = get_term_meta($category->term_id, 'category_icon', true);
                        ?>
                                <li class="category-item">
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-link">
                                        <?php if ($category_icon) : ?>
                                            <img src="<?php echo esc_url($category_icon); ?>" alt="<?php echo esc_attr($category->name); ?>" class="category-icon">
                                        <?php endif; ?>
                                        <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                        <span class="category-count">(<?php echo esc_html($category->count); ?>)</span>
                                    </a>
                                </li>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="product-archive">
                <?php if (have_posts()) : ?>
                    <div class="products-grid">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/product', 'card');
                        endwhile;
                        ?>
                    </div>

                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'taikhoan-clone'),
                        'next_text' => __('Next', 'taikhoan-clone') . ' <i class="fas fa-chevron-right"></i>',
                        'screen_reader_text' => __('Posts navigation', 'taikhoan-clone'),
                    ));
                    ?>

                <?php else : ?>
                    <div class="no-products">
                        <p><?php esc_html_e('No products found in this category.', 'taikhoan-clone'); ?></p>
                    </div>
                <?php endif; ?>
            </main>
        </div>

        <!-- Recent Activity Section -->
        <div class="recent-activity">
            <!-- Recent Orders -->
            <section class="recent-orders">
                <h3><?php esc_html_e('ĐƠN HÀNG GẦN ĐÂY', 'taikhoan-clone'); ?></h3>
                <div class="orders-list">
                    <?php
                    // Get recent orders (customize this query based on your order storage method)
                    $recent_orders = get_posts(array(
                        'post_type' => 'shop_order',
                        'posts_per_page' => 10,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));

                    if (!empty($recent_orders)) :
                        foreach ($recent_orders as $order) :
                            // Get order details
                            $order_id = $order->ID;
                            $order_data = get_post_meta($order_id, '_order_data', true);
                    ?>
                            <div class="order-item">
                                <span class="order-id"><?php echo esc_html(substr($order->post_title, -3)); ?></span>
                                <span class="order-details">
                                    <?php
                                    if ($order_data) {
                                        echo esc_html($order_data['product_name']);
                                        echo ' - ';
                                        echo esc_html(number_format($order_data['price'], 0, ',', '.')) . 'đ';
                                    }
                                    ?>
                                </span>
                                <span class="order-time">
                                    <?php echo esc_html(human_time_diff(get_post_time('U', false, $order), current_time('timestamp')) . ' ' . __('ago', 'taikhoan-clone')); ?>
                                </span>
                            </div>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <p class="no-orders"><?php esc_html_e('No recent orders.', 'taikhoan-clone'); ?></p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Recent Deposits -->
            <section class="recent-deposits">
                <h3><?php esc_html_e('NẠP TIỀN GẦN ĐÂY', 'taikhoan-clone'); ?></h3>
                <div class="deposits-list">
                    <?php
                    // Get recent deposits (customize this query based on your deposit storage method)
                    $recent_deposits = get_posts(array(
                        'post_type' => 'deposit',
                        'posts_per_page' => 10,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));

                    if (!empty($recent_deposits)) :
                        foreach ($recent_deposits as $deposit) :
                            // Get deposit details
                            $deposit_id = $deposit->ID;
                            $deposit_data = get_post_meta($deposit_id, '_deposit_data', true);
                    ?>
                            <div class="deposit-item">
                                <span class="deposit-id"><?php echo esc_html(substr($deposit->post_title, -3)); ?></span>
                                <span class="deposit-amount">
                                    <?php
                                    if ($deposit_data) {
                                        echo esc_html(number_format($deposit_data['amount'], 0, ',', '.')) . 'đ';
                                        echo ' - ';
                                        echo esc_html($deposit_data['payment_method']);
                                    }
                                    ?>
                                </span>
                                <span class="deposit-time">
                                    <?php echo esc_html(human_time_diff(get_post_time('U', false, $deposit), current_time('timestamp')) . ' ' . __('ago', 'taikhoan-clone')); ?>
                                </span>
                            </div>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <p class="no-deposits"><?php esc_html_e('No recent deposits.', 'taikhoan-clone'); ?></p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</div>

<?php get_footer(); ?>
