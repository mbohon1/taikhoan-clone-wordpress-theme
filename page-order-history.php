<?php
/**
 * Template Name: Order History
 *
 * @package Taikhoan_Clone
 */

// Redirect if user is not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

get_header();
?>

<div class="order-history-page">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?php esc_html_e('Order History', 'taikhoan-clone'); ?></h1>
        </div>

        <div class="order-history-content">
            <!-- Order History Tabs -->
            <div class="order-tabs">
                <ul class="nav-tabs">
                    <li class="tab-item active">
                        <a href="#orders" data-tab="orders">
                            <?php esc_html_e('ĐƠN HÀNG GẦN ĐÂY', 'taikhoan-clone'); ?>
                        </a>
                    </li>
                    <li class="tab-item">
                        <a href="#deposits" data-tab="deposits">
                            <?php esc_html_e('NẠP TIỀN GẦN ĐÂY', 'taikhoan-clone'); ?>
                        </a>
                    </li>
                </ul>

                <!-- Orders Tab Content -->
                <div id="orders" class="tab-content active">
                    <div class="order-filters">
                        <select class="order-status-filter">
                            <option value=""><?php esc_html_e('All Orders', 'taikhoan-clone'); ?></option>
                            <option value="completed"><?php esc_html_e('Completed', 'taikhoan-clone'); ?></option>
                            <option value="pending"><?php esc_html_e('Pending', 'taikhoan-clone'); ?></option>
                            <option value="cancelled"><?php esc_html_e('Cancelled', 'taikhoan-clone'); ?></option>
                        </select>

                        <div class="date-range">
                            <input type="date" class="date-from" placeholder="<?php esc_attr_e('From Date', 'taikhoan-clone'); ?>">
                            <input type="date" class="date-to" placeholder="<?php esc_attr_e('To Date', 'taikhoan-clone'); ?>">
                        </div>
                    </div>

                    <div class="orders-list">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e('Order ID', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Product', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Amount', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Status', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Date', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Actions', 'taikhoan-clone'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get user's orders
                                $current_user = wp_get_current_user();
                                $args = array(
                                    'post_type' => 'shop_order',
                                    'posts_per_page' => 10,
                                    'meta_query' => array(
                                        array(
                                            'key' => '_customer_user',
                                            'value' => $current_user->ID,
                                        ),
                                    ),
                                );

                                $orders = get_posts($args);

                                if ($orders) :
                                    foreach ($orders as $order) :
                                        $order_data = get_post_meta($order->ID, '_order_data', true);
                                        $status = get_post_meta($order->ID, '_order_status', true);
                                ?>
                                        <tr>
                                            <td>#<?php echo esc_html($order->ID); ?></td>
                                            <td><?php echo esc_html($order_data['product_name']); ?></td>
                                            <td><?php echo esc_html(number_format($order_data['amount'], 0, ',', '.')); ?>đ</td>
                                            <td>
                                                <span class="status-badge status-<?php echo esc_attr($status); ?>">
                                                    <?php echo esc_html(ucfirst($status)); ?>
                                                </span>
                                            </td>
                                            <td><?php echo get_the_date('Y-m-d H:i:s', $order); ?></td>
                                            <td>
                                                <button class="view-details" data-order-id="<?php echo esc_attr($order->ID); ?>">
                                                    <?php esc_html_e('View Details', 'taikhoan-clone'); ?>
                                                </button>
                                            </td>
                                        </tr>
                                <?php
                                    endforeach;
                                else :
                                ?>
                                    <tr>
                                        <td colspan="6" class="no-orders">
                                            <?php esc_html_e('No orders found.', 'taikhoan-clone'); ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Deposits Tab Content -->
                <div id="deposits" class="tab-content">
                    <div class="deposit-filters">
                        <select class="deposit-status-filter">
                            <option value=""><?php esc_html_e('All Deposits', 'taikhoan-clone'); ?></option>
                            <option value="completed"><?php esc_html_e('Completed', 'taikhoan-clone'); ?></option>
                            <option value="pending"><?php esc_html_e('Pending', 'taikhoan-clone'); ?></option>
                        </select>

                        <div class="date-range">
                            <input type="date" class="date-from" placeholder="<?php esc_attr_e('From Date', 'taikhoan-clone'); ?>">
                            <input type="date" class="date-to" placeholder="<?php esc_attr_e('To Date', 'taikhoan-clone'); ?>">
                        </div>
                    </div>

                    <div class="deposits-list">
                        <table class="deposits-table">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e('Transaction ID', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Amount', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Payment Method', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Status', 'taikhoan-clone'); ?></th>
                                    <th><?php esc_html_e('Date', 'taikhoan-clone'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get user's deposits
                                $args = array(
                                    'post_type' => 'deposit',
                                    'posts_per_page' => 10,
                                    'meta_query' => array(
                                        array(
                                            'key' => '_user_id',
                                            'value' => $current_user->ID,
                                        ),
                                    ),
                                );

                                $deposits = get_posts($args);

                                if ($deposits) :
                                    foreach ($deposits as $deposit) :
                                        $deposit_data = get_post_meta($deposit->ID, '_deposit_data', true);
                                        $status = get_post_meta($deposit->ID, '_deposit_status', true);
                                ?>
                                        <tr>
                                            <td>#<?php echo esc_html($deposit->ID); ?></td>
                                            <td><?php echo esc_html(number_format($deposit_data['amount'], 0, ',', '.')); ?>đ</td>
                                            <td><?php echo esc_html($deposit_data['payment_method']); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo esc_attr($status); ?>">
                                                    <?php echo esc_html(ucfirst($status)); ?>
                                                </span>
                                            </td>
                                            <td><?php echo get_the_date('Y-m-d H:i:s', $deposit); ?></td>
                                        </tr>
                                <?php
                                    endforeach;
                                else :
                                ?>
                                    <tr>
                                        <td colspan="5" class="no-deposits">
                                            <?php esc_html_e('No deposits found.', 'taikhoan-clone'); ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="order-details-modal" style="display: none;">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3><?php esc_html_e('Order Details', 'taikhoan-clone'); ?></h3>
        <div class="order-details-content"></div>
    </div>
</div>

<?php get_footer(); ?>
