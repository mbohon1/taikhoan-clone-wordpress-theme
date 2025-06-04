</div><!-- .site-content -->

<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-social">
            <div class="social-links">
                <a href="https://www.facebook.com/profile.php?id=100092992969289" target="_blank" rel="noopener noreferrer" class="social-link">
                    <i class="fab fa-facebook"></i> Facebook (ƯU TIÊN)
                </a>
                <a href="https://zalo.me/g/eesgdp286" target="_blank" rel="noopener noreferrer" class="social-link">
                    <i class="fas fa-comments"></i> Zalo Group
                </a>
                <a href="https://www.youtube.com/@vps-edu-email/playlists" target="_blank" rel="noopener noreferrer" class="social-link">
                    <i class="fab fa-youtube"></i> Youtube
                </a>
            </div>
            
            <div class="footer-instructions">
                <a href="https://accountcloud.shop/client/blogs" target="_blank" rel="noopener noreferrer">
                    <?php _e('Hướng dẫn cơ bản (Basic instructions)', 'taikhoan-clone'); ?>
                </a>
            </div>
        </div>

        <div class="footer-notice">
            <p class="notice-vn">
                <?php _e('LƯU Ý: Tất cả tài khoản chỉ bảo hành login, sau khi check thành công vui lòng thay đổi thông tin bảo mật, sau 3h không bảo hành ạ', 'taikhoan-clone'); ?>
            </p>
            <p class="notice-en">
                <?php _e('NOTE: All accounts are only guaranteed for login, after successful check please change security information, after 3 hours no warranty', 'taikhoan-clone'); ?>
            </p>
        </div>

        <div class="footer-languages">
            <div class="language-selector">
                <a href="#" data-lang="vi" class="lang-item active">
                    <img src="https://flagicons.lipis.dev/flags/4x3/vn.svg" alt="Vietnamese" class="lang-flag">
                    Vietnamese
                </a>
                <a href="#" data-lang="en" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/us.svg" alt="English" class="lang-flag">
                    English
                </a>
                <a href="#" data-lang="fr" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/fr.svg" alt="French" class="lang-flag">
                    French
                </a>
                <a href="#" data-lang="de" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/de.svg" alt="German" class="lang-flag">
                    German
                </a>
                <a href="#" data-lang="es" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/es.svg" alt="Spanish" class="lang-flag">
                    Spanish
                </a>
                <a href="#" data-lang="hi" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/in.svg" alt="Hindi" class="lang-flag">
                    Hindi
                </a>
                <a href="#" data-lang="id" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/id.svg" alt="Indonesian" class="lang-flag">
                    Indonesian
                </a>
                <a href="#" data-lang="ms" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/my.svg" alt="Malay" class="lang-flag">
                    Malay
                </a>
                <a href="#" data-lang="pt" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/pt.svg" alt="Portuguese" class="lang-flag">
                    Portuguese
                </a>
                <a href="#" data-lang="ro" class="lang-item">
                    <img src="https://flagicons.lipis.dev/flags/4x3/ro.svg" alt="Romanian" class="lang-flag">
                    Romanian
                </a>
            </div>
        </div>

        <div class="footer-menu">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_class'     => 'footer-nav',
                'fallback_cb'    => false,
            ));
            ?>
        </div>

        <div class="footer-copyright">
            <p>
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                <?php _e('All rights reserved.', 'taikhoan-clone'); ?>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
