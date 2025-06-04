<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="site-branding">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
            ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url('https://taikhoan.site/assets/storage/images/logo_dark_8C3.png'); ?>" alt="<?php bloginfo('name'); ?>">
                </a>
            <?php
            }
            ?>
        </div>

        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'nav-menu',
                'fallback_cb'    => false,
            ));
            ?>

            <div class="product-categories">
                <ul>
                    <li><a href="#" class="all-products"><?php _e('TẤT CẢ SẢN PHẨM', 'taikhoan-clone'); ?></a></li>
                    <li>
                        <a href="#" class="category-item">
                            <img src="<?php echo esc_url('https://taikhoan.site/assets/storage/images/categoryYUC.png'); ?>" alt="Google Cloud">
                            <?php _e('GOOGLE CLOUD', 'taikhoan-clone'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="category-item">
                            <img src="<?php echo esc_url('https://taikhoan.site/assets/storage/images/categoryBM3.png'); ?>" alt="Linode">
                            <?php _e('LINODE', 'taikhoan-clone'); ?>
                        </a>
                    </li>
                    <!-- Add other categories similarly -->
                </ul>
            </div>
        </nav>

        <div class="header-contact">
            <div class="contact-links">
                <a href="https://www.facebook.com/profile.php?id=100092992969289" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-facebook"></i> Facebook (ƯU TIÊN)
                </a>
                <a href="https://zalo.me/g/eesgdp286" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-comments"></i> Zalo Group
                </a>
                <a href="https://www.youtube.com/@vps-edu-email/playlists" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-youtube"></i> Youtube
                </a>
            </div>

            <div class="header-notice">
                <p><?php _e('LƯU Ý: Tất cả tài khoản chỉ bảo hành login, sau khi check thành công vui lòng thay đổi thông tin bảo mật, sau 3h không bảo hành ạ', 'taikhoan-clone'); ?></p>
                <p><?php _e('NOTE: All accounts are only guaranteed for login, after successful check please change security information, after 3 hours no warranty', 'taikhoan-clone'); ?></p>
            </div>
        </div>

        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
            <span class="menu-toggle-icon"></span>
            <?php esc_html_e('Menu', 'taikhoan-clone'); ?>
        </button>
    </div>
</header>

<div class="site-content">
