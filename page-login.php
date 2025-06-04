<?php
/**
 * Template Name: Login Page
 *
 * @package Taikhoan_Clone
 */

// Redirect if user is already logged in
if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

get_header();

// Initialize error messages
$error_messages = array();

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    $creds = array(
        'user_login'    => sanitize_text_field($_POST['username']),
        'user_password' => $_POST['password'],
        'remember'      => isset($_POST['rememberme'])
    );

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        $error_messages[] = $user->get_error_message();
    } else {
        wp_redirect(home_url());
        exit;
    }
}
?>

<div class="login-page">
    <div class="container">
        <div class="login-wrapper">
            <div class="login-content">
                <!-- Login Form Section -->
                <div class="login-form-section">
                    <h1 class="login-title"><?php esc_html_e('Login', 'taikhoan-clone'); ?></h1>

                    <?php if (!empty($error_messages)) : ?>
                        <div class="login-errors">
                            <?php foreach ($error_messages as $error) : ?>
                                <div class="error-message"><?php echo esc_html($error); ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="login-form" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                        <div class="form-group">
                            <label for="username">
                                <i class="fas fa-user"></i>
                                <?php esc_html_e('Username or Email', 'taikhoan-clone'); ?>
                            </label>
                            <input 
                                type="text" 
                                name="username" 
                                id="username" 
                                required 
                                class="form-control"
                                value="<?php echo isset($_POST['username']) ? esc_attr($_POST['username']) : ''; ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i>
                                <?php esc_html_e('Password', 'taikhoan-clone'); ?>
                            </label>
                            <div class="password-input-wrapper">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    required 
                                    class="form-control"
                                >
                                <button type="button" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group remember-me">
                            <label class="checkbox-label">
                                <input 
                                    type="checkbox" 
                                    name="rememberme" 
                                    id="rememberme" 
                                    value="forever"
                                    <?php echo isset($_POST['rememberme']) ? 'checked' : ''; ?>
                                >
                                <span class="checkbox-custom"></span>
                                <?php esc_html_e('Remember Me', 'taikhoan-clone'); ?>
                            </label>
                            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="forgot-password">
                                <?php esc_html_e('Forgot Password?', 'taikhoan-clone'); ?>
                            </a>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="login_submit" class="login-button">
                                <i class="fas fa-sign-in-alt"></i>
                                <?php esc_html_e('Log In', 'taikhoan-clone'); ?>
                            </button>
                        </div>

                        <?php wp_nonce_field('login_nonce', 'login_nonce_field'); ?>
                    </form>

                    <div class="login-separator">
                        <span><?php esc_html_e('OR', 'taikhoan-clone'); ?></span>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="social-login">
                        <?php if (function_exists('nextend_social_login')) : ?>
                            <div class="social-login-buttons">
                                <?php do_action('nextend_social_login'); ?>
                            </div>
                        <?php else : ?>
                            <button class="social-login-button facebook">
                                <i class="fab fa-facebook-f"></i>
                                <?php esc_html_e('Continue with Facebook', 'taikhoan-clone'); ?>
                            </button>
                            <button class="social-login-button google">
                                <i class="fab fa-google"></i>
                                <?php esc_html_e('Continue with Google', 'taikhoan-clone'); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Registration Link Section -->
                <div class="register-section">
                    <p>
                        <?php esc_html_e('Don\'t have an account?', 'taikhoan-clone'); ?>
                        <a href="<?php echo esc_url(wp_registration_url()); ?>" class="register-link">
                            <?php esc_html_e('Register Now', 'taikhoan-clone'); ?>
                        </a>
                    </p>
                </div>
            </div>

            <!-- Login Page Notice -->
            <div class="login-notice">
                <p class="notice-text">
                    <?php esc_html_e('NOTE: All accounts are only guaranteed for login, after successful check please change security information, after 3 hours no warranty', 'taikhoan-clone'); ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Add custom script for login page -->
<script>
jQuery(document).ready(function($) {
    // Toggle password visibility
    $('.toggle-password').on('click', function() {
        const passwordInput = $(this).siblings('input');
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Form validation
    $('.login-form').on('submit', function(e) {
        const username = $('#username').val().trim();
        const password = $('#password').val().trim();
        let isValid = true;

        // Remove existing error messages
        $('.form-error').remove();

        if (username === '') {
            $('#username').after('<span class="form-error"><?php esc_html_e("Please enter your username or email", "taikhoan-clone"); ?></span>');
            isValid = false;
        }

        if (password === '') {
            $('#password').after('<span class="form-error"><?php esc_html_e("Please enter your password", "taikhoan-clone"); ?></span>');
            isValid = false;
        }

        return isValid;
    });

    // Social login buttons
    $('.social-login-button').on('click', function(e) {
        e.preventDefault();
        // Add your social login handling code here
        alert('Social login functionality needs to be implemented');
    });
});
</script>

<?php get_footer(); ?>
